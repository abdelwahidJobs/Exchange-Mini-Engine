<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request) // <- no type hint, no return type
    {
        return [
            'id'      => $this->id,
            'name'    => $this->name,
            'email'   => $this->email,
            'balance' => (float) $this->balance,

            'assets' => $this->assets->map(function ($asset) {
                return [
                    'id'        => $asset->id,
                    'symbol'        => $asset->symbol,
                    'amount'        => (float) $asset->amount,
                    'locked_amount' => (float) $asset->locked_amount,
                ];
            }),
        ];
    }
}
