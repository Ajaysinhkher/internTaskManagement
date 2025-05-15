<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class message extends Model
{
    protected $fillable = [
        'sender_id',
        'sender_type',
        'receiver_id',
        'receiver_type',
        'message',
        'read_at'
    ];

    // sender can be either user or admin
    public function sender()
    {
        return $this->morphTo();
    }

    // receiver can be either user or admin
    public function receiver()
    {
        return $this->morphTo();
    }
}
