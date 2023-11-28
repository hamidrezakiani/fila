<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\UserActivity */
class UserActivityResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'model' => $this->model,
            'action' => $this->action,
            'parameter' => json_decode($this->parameter),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
