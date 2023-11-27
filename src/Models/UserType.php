<?php

namespace Gtd\Extension\User\Models;


use Illuminate\Database\Eloquent\Model;



class UserType extends Model
{
    
    protected $table = 'gtd_user_types';
    protected $fillable = [
        'type_name',
    ];
    
}
