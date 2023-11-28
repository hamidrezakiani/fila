<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserActivity extends Model
{
    protected $fillable = ['user_id','model','parameter','action'];
    protected $casts = [
        'parameter' => 'json',
    ];
}
