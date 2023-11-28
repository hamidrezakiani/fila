<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasActivity;
class Post extends Model
{
    use SoftDeletes,HasActivity;

    protected $fillable = [
        'title',
        'text',
    ];
}
