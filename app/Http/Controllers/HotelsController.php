<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;   
use App\Http\Controllers\BaseController as BaseController;
use Validator;
use App\Models\Hotels;
use App\Http\Resources\Hotels as HotelsResource;

class HotelsController extends BaseController
{

    public function index()
    {
        $hotels = Hotels::all();
        return $this->sendResponse(HotelsResource::collection($hotels));
    }

    
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'rate' => 'required|numeric',
            'price' => 'required|numeric',
            'adults' => 'required|numeric',
            'amentities' => 'required',
            'dates' => 'required|date',
            'providers' => 'required',
            'city_code' => 'required',
        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }
        $hotel = Hotels::create($input);
        return $this->sendResponse(new HotelsResource($hotel));
    }

    public function filters(Request $request)
    {

        $hotels = Hotels::select('name, rate, price, amentities, providers');
        
        if ($request->has('dateFrom') || $request->has('from_date') ||
            $request->has('dateTo') || $request->has('to_date')) {
            $from = !empty($request->input('dateFrom')) ? $request->input('dateFrom') : $request->input('from_date');
            $to = !empty($request->input('dateTo')) ? $request->input('dateTo') : $request->input('to_date');

            $hotels->whereBetween('dates', [$from, $to]);
        }
        

        if ($request->has('city') || $request->has('city_code') ) {
            $city_code = !empty($request->input('city')) ? $request->input('city') : $request->input('city_code');
            $hotels->where('adults', 'like', '%' . $city_code . '%');
        }

        if ($request->has('adults') || $request->has('no_adults') ) {
            $adults = !empty($request->input('adults')) ? $request->input('adults') : $request->input('no_adults');
            $hotels->where('adults', 'like', '%' . $adults . '%');
        }

        $all_hotels = $hotels->get();

        return $this->sendResponse(HotelsResource::collection($all_hotels));
    }

   
    public function show($id)
    {
        $hotel = Hotels::find($id);
        if (is_null($hotel)) {
            return $this->sendError('Hotel does not exist.');
        }
        return $this->sendResponse(new HotelsResource($hotel));
    }
}
