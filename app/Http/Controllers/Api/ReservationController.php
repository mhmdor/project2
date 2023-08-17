<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;

use App\Models\Ads;
use App\Models\profile;
use App\Models\reservation;
use App\Models\tourism;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends ApiController
{


    public function createReserve(Request $request){

        $validator = $this -> apiValidation($request , [

            'numOfClients' => 'required|max:50',
            'total_price' => 'required'
        ]);
        if($validator instanceof Response) return $validator;

        $id = Auth::id();
        $profile_id = profile::where('user_id','=',$id)->first()->id;

        $reserve = reservation::create([
            'numOfClients' => $request->numOfClients,
            'note' => $request->note,
            'total_price' => $request->total_price,
            'vaild' => $request->vaild,
            'profile_id' => $profile_id
        ]);
        return $this->apiResponse(['reserve' => $reserve],self::STATUS_CREATED, 'add ads successfully');
    }


    public function getreserves()
    {
        $id = Auth::id();
        $profile_id = profile::where('user_id','=',$id)->first()->id;
        $resrevation = reservation::where('profile_id', $profile_id)->count();
        if ($resrevation > 0) {
            $resrevations = reservation::where('profile_id', $profile_id)->get();
            return   $this->apiResponse(['resrevations' => $resrevations], self::STATUS_CREATED, 'get ads successfully');
        } else {
            return $this->apiResponse(['Error' => "Not Found"], 404, 'No Data');
        }
    }


    public function edit_reserve(Request $request,$id){

        $validator = $this -> apiValidation($request , [
            'numOfClients' => 'required|max:50',
            'total_price' => 'required'

        ]);
        $reserve = reservation::findOrFail($id);

        if($validator instanceof Response) return $validator;

        $reserve  -> update([
            'numOfClients' => $request->numOfClients,
            'note' => $request->note,
            'total_price' => $request->total_price,

        ]);
        return  $this->apiResponse(['reserve' => $reserve], self::STATUS_CREATED, 'Update ads successfully');
    }


    public function remove_reserve($id)
    {
      $reserve= reservation::findOrFail($id);
        $reserve->delete();
        return "deleted successfully";
    }

}
