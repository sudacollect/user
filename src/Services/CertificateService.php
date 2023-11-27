<?php

namespace Gtd\Extension\User\Services;

use Illuminate\Encryption\Encrypter;
use Illuminate\Support\Carbon;
use Illuminate\Support\Arr;
use Log;

class CertificateService
{
    
    public static function makeExtkey($slug, $expired_time)
    {
        $checks = [
            'SLUG'      => $slug,
            'SUDA'     => 'suda',
            'TIME'      => $expired_time
        ];
        ksort($checks);
        
        $str = implode('_*_',$checks);
        $key = sha1($str);
        $key .= $expired_time;
        
        return $key;
    }
    
    private static function makeSign($data)
    {    
        $keys = array_keys($data);
        $static_keys = ['product','certi_no','start_date','end_date','timestamp'];
        $diff = array_diff($static_keys, $keys);
        // 缺少键值
        if(count($diff) > 0)
        {
            return false;
        }

        $correct_data = [];
        $correct_data['product'] = $data['product'];
        $correct_data['certi_no'] = $data['certi_no'];
        $correct_data['start_date']  = date('Y-m-d H:i:s',strtotime($data['start_date']));
        $correct_data['end_date']    = date('Y-m-d H:i:s',strtotime($data['end_date']));
        $correct_data['timestamp']    = $data['timestamp'];
        
        // 去掉时间因素
        $signature = sha1('gtd'.$correct_data['product'].'X'.$correct_data['certi_no'].$correct_data['timestamp'].'suda');
        return $signature;
    }
    
    public static function getSignature($data){
        
        $sign = self::makeSign($data);
        
        if(!$sign){
            return false;
        }
        return $sign;
    }
    
    //验证授权码是否正确
    public static function checkSignature($signature,$data,$old_data)
    {
        
        if(Carbon::now()->gte($data['end_date'])){
            return false;
        }

        //新数据 || 旧数据验证不通过,则启用新数据
        $sign = self::makeSign($data);
        
        if($sign && $signature == $sign){
            return true;
        }
        
        return false;
    }
    
    public static function encryptData(array $data)
    {
        $cipher = 'AES-128-CBC';
        
        $sign = self::makeSign($data);

        $product = $data['product'];

        $encrypt_key = self::getEncryptKey($product);
        $iv = self::getIv($cipher, $data['end_date'].$data['certi_no']);
        
        $serial = \openssl_encrypt(
            serialize($data),
            $cipher, $encrypt_key, 0, $iv
        );

        return base64_encode($serial);
    }
    
    private static function getEncryptKey($product="suda")
    {
        $data = [
            'product'       => $product,
            'certificate'   => 1,
        ];
        $encrypt_key = sha1(serialize($data));
        return $encrypt_key;
    }

    private static function getIv($cipher,$iv_str)
    {
        $iv_len = openssl_cipher_iv_length($cipher);
        return substr(md5($iv_str), 0, $iv_len);
    }

}