<?php

namespace Gtd\Extension\User\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class UserGrade extends Model
{
    
    protected $table = 'gtd_user_grades';
    protected $fillable = [
        'grade_name',
    ];
    
    public function userType(): BelongsTo
    {
        return $this->belongsTo('Gtd\Extension\User\Models\UserType','type_id','id');
    }
}
