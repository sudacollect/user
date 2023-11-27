<?php

namespace Gtd\Extension\User\Models;


use Illuminate\Database\Eloquent\Model;



class UserChange extends Model
{
    
    protected $table = 'gtd_user_changes';
    protected $fillable = [
        'user_id',
        'email',
        'phone',
        'token',
    ];
    
}
