<?php

namespace App\Models;

use App\traits\HasActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model
{
    use SoftDeletes,HasActivity;

    protected $fillable = [
        'name',
        'slog',
    ];
}
