<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreditTransfer extends Model
{
    protected $fillable = [
        'user_id',
        'credit_transfer_request_id',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function creditTransferRequest() {
        return $this->belongsTo(CreditTransferRequest::class, 'credit_transfer_request_id', 'id');
    }
}
