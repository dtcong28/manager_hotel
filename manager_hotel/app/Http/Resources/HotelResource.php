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
            'name' => isset($hotel->name) ? $hotel->name : '',
            'address' => isset($hotel->address) ? $hotel->address : '',
            'email' => isset($hotel->email) ? $hotel->email : '',
            'phone' => isset($hotel->phone) ? $hotel->phone : '',
            'website' => isset($hotel->website) ? $hotel->website : '',
            'introduce' => isset($hotel->introduce) ? $hotel->introduce : '',
            'introduce_restaurant' => isset($hotel->introduce_restaurant) ? $hotel->introduce_restaurant : '',
        ];
    }
}
