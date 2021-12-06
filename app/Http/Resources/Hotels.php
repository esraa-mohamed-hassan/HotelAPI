<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Hotels extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // dd($this->providers);
        if($this->providers == 'A'){
            return [
                'Hotel' => $this->name,
                'Rate' => $this->rate,
                'Fare' => $this->price,
                'roomAmenities' => $this->amentities,
            ];
        }else{
           
            if(!empty($this->discount)){
                return $data = [
                    'hotelName' => $this->name,
                    'Rate' => $this->rate,
                    'Price' => $this->price,
                    'amenities' => $this->amentities,
                    'discount' => $this->discount,
                ];
            }else{
                return $data = [
                    'hotelName' => $this->name,
                    'Rate' => $this->rate,
                    'Price' => $this->price,
                    'amenities' => $this->amentities,
                ];
            }
            return $data;
        }
    }
}
