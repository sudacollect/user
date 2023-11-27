<?php

namespace Gtd\Extension\User\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Gtd\Suda\Traits\MediaTrait;

class User extends Authenticatable
{
    use Notifiable;
    use MediaTrait;
    
    protected $table = 'gtd_users';
    protected $fillable = [
        'team_id',
        'username',
        'password',
        'salt',
        'nickname',
        'realname',
        'email',
        'phone',
        'gender',
        'credit',
        'type_id',
        'grade_id',
        'link',
        'link_wechat','link_qq','link_twitter','link_github','link_blog',
        'province','city','district','address',

        'source',
        'invite_code',
        'registration_reason',
    ];
    
    protected $appends = ['status_text'];
    
    public function avatar()
    {
         return $this->hasOne('Gtd\Suda\Models\Mediatable','mediatable_id','id')
            ->where('mediatable_type','Gtd\Extension\User\Models\User')
            ->where('position','avatar')
            ->with('media');
    }

    public function getStatusTextAttribute()
    {
        switch($this->status)
        {
            case 1:
                return '已验证';
            break;
            case 2:
                return '禁用';
            break;
            default:
                return '未验证';
            break;
        }
    }

    public function userType(): BelongsTo
    {
        return $this->belongsTo('Gtd\Extension\User\Models\UserType','type_id','id');
    }

    public function userGrade(): BelongsTo
    {
        return $this->belongsTo('Gtd\Extension\User\Models\UserGrade','grade_id','id');
    }

    public function certificate(): HasOne
    {
        return $this->hasOne('Gtd\Extension\User\Models\Certificate','user_id','id');
    }
    
    public function getAuthIdentifier()
    {
        return $this->getKey();
    }
    
    public function getAuthPassword()
    {
        return $this->password;
    }
    
    public function routeNotificationForMail($notification)
    {
        return $this->email;
    }
    
    
}
