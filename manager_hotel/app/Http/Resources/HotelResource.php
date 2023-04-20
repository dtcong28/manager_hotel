<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Repositories\Eloquent\HotelRepository;

class HotelResource extends JsonResource
{
    protected $repository;

    public function __construct()
    {
        $this->repository = app(HotelRepository::class);

    }
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $hotel = $this->repository->first();

        return [
            'name' => $hotel->name,
            'address' => $hotel->address,
            'email' => $hotel->email,
            'phone' => $hotel->phone,
            'website' => $hotel->website,
            'introduce' => $hotel->introduce,
        ];
    }
}
