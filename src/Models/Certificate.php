<?php

namespace Gtd\Extension\User\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Gtd\Extension\User\Models\User;

class Certificate extends Model
{
    protected $table = 'gtd_certificates';
    
    protected $dates = [
        'created_at','updated_at','start_date','end_date'
    ];

    protected $fillable = [
        'order_id',
        'certi_type',
        'certi_name',
        'certi_no',
        'user_id',
        'team_id',
        'operate_id',
        'start_date',
        'end_date',
        'serial',
        'certi_product',
        'status',
    ];

    protected $appends = ['certi_type_name'];

    protected static function booted()
    {
        static::retrieved(function ($item) {
            
            if(Carbon::now()->gt($item->end_date))
            {
                User::where(['id'=>$item->user_id])->update(['badge_certificate'=>0]);
            }

        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo('Gtd\Extension\User\Models\User','user_id','id');
    }


    public function getCertiTypeNameAttribute()
    {
        switch($this->certi_type)
        {
            case 'personal':
                return '个人';
            break;
            case 'team':
                return '团队';
            break;
            case 'company':
                return '企业';
            break;
            case 'organization':
                return '组织用户';
            break;
            case 'edu':
                return '教育机构';
            break;
        }
    }
}
