<?php

// app/Models/Visit.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    protected $fillable = [
        'user_id',
        'ip_address',
        'user_agent',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}