<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreditTransferRequest extends Model
{
    protected $fillable = [
        'user_id',
        'to_user_id',
        'amount',
        'status',
        'verified_at',
    ];

    public function toUser() {
        return $this->belongsTo(User::class, 'to_user_id', 'id');
    }
}
