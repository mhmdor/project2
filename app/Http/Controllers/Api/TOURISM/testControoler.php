<?php

namespace App\Http\Controllers\Api\TOURISM;

use App\Http\Controllers\Api\ApiController;
use App\Models\Trip;
use App\Traits\RestfulTrait;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TourismResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class testControoler extends ApiController
{


 use RestfulTrait;
    public function createTrip(Request $request)
    {

        $validator = $this->apiValidation($request, [
            'title' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|integer|min:0',
            'date' => 'required|date',
            'status' => 'required|integer|in:0,1',
        ]);
        if ($validator instanceof Response) return $validator;
        $trip = Trip::create([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'status' => $request->status,
            'date' => $request->date,
            'user_id' => Auth::id()
        ]);
    //self::STATUS_CREATED
       return $this->apiResponse(['tourism' => new TourismResource($trip)], 200 , 'add trip successfully');

    }
}
