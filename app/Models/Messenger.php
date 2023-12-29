<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Messenger extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable
     *
     * @var array<string>
     */
    protected $fillable = [
        'user_id', 'receiver_id', 'message', 'read_at'
    ];

    protected $casts = [
        'read_at' => 'datetime'
    ];

    public function receiver()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

