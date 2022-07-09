<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable=[
        'message',
        'sender',
        'receiver',
        'seen_at',
    ];

    public function senderUser()
    {
        return $this->belongsTo(User::class,'sender');
    }

    public function receiverUser()
    {
        return $this->belongsTo(User::class,'receiver');
    }
}
