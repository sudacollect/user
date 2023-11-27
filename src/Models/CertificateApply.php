<?php

namespace Gtd\Extension\User\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CertificateApply extends Model
{
    protected $table = 'gtd_certificate_applies';
    
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

    public function user(): BelongsTo
    {
        return $this->belongsTo('Gtd\Extension\User\Models\User','user_id','id');
    }
    
}
