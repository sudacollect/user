<?php

namespace Gtd\Extension\User\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Invite extends Model
{
    protected $table = 'gtd_invites';
    
    protected $fillable = [
        'user_id',
        'invite_code',
        'invite_user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo('Gtd\Extension\User\Models\User','user_id','id');
    }

    public function invite_user(): HasOne
    {
        return $this->hasOne('Gtd\Extension\User\Models\User','id','invite_user_id');
    }
}
