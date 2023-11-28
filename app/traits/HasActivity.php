<?php

namespace App\traits;
use App\Models\UserActivity;
trait HasActivity
{
    protected static function boot()
    {
        parent::boot();
        static::created(function ($model){
            $array = explode("\\", __CLASS__);
            UserActivity::create([
                'user_id' => auth('api')->id(),
                'model' => end($array),
                'action' => 'create',
                'parameter' => json_encode($model)
            ]);
        });
        static::updated(function ($model){
            $array = explode("\\", __CLASS__);
            UserActivity::create([
                'user_id' => auth('api')->id(),
                'model' => end($array),
                'action' => 'update',
                'parameter' => json_encode($model)
            ]);
        });
        static::deleted(function ($model){
            $array = explode("\\", __CLASS__);
            UserActivity::create([
                'user_id' => auth('api')->id(),
                'model' => end($array),
                'action' => 'delete',
                'parameter' => json_encode($model)
            ]);
        });
    }
}
