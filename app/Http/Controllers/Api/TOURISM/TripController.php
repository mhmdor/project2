<?php

namespace App\Http\Controllers\Api\TOURISM;

use App\Models\Ads;
use App\Models\Trip;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TourismResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\ApiController;

class TripController extends ApiController
{
    /**
     * Create User
     * @param Request $request
     * @return string
     */
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
            'description' => $request->descrption,
            'price' => $request->price,
            'status' => $request->status,
            'date' => $request->date,
            'user_id' => Auth::id()
        ]);

        return $this->apiResponse(['trip' => $trip],200, 'add trip successfully');
    }


}
