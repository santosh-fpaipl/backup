<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\AddressResource;

class SupplierResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //return parent::toArray($request);

        return [
            "name" => $this->user->name,
            "alias" => $this->user->alias,
            "email" => $this->user->email,
            "contacts" => $this->user->contacts,
            "address_id" => AddressResource::collection($this->addresses),
            "gst" => $this->gst,
            "pan" => $this->pan,
            "sid" => $this->sid,
            "description" => $this->description,

        ];
    }
}
