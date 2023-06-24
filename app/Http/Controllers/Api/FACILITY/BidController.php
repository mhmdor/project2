<?php

namespace App\Http\Controllers\Api\FACILITY;
use App\Http\Controllers\Api\ApiController;
use App\Models\Ads;
use App\Models\bid;
use App\Models\Facility;
use App\Models\tourism;
use App\Traits\RestfulTrait;
use Brick\Math\BigDecimal;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TourismResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BidController extends ApiController
{
    public function create_bid(Request $request){

        $validator = $this -> apiValidation($request , [
            'title' => 'required|string|max:50',
            'descrption' => 'required|string|max:222',
            'price' => 'required|int',
            'image' => 'required',
        ]);

        if($validator instanceof Response) return $validator;

        $image = $request->file('image');
        $destinationPathImg = public_path('uploads/BID/');
        if (!$image->move($destinationPathImg, $image->getClientOriginalName())) {
            return 'Error saving the file.';
        }

        $id = Auth::id();
        $facility_id  = Facility::where('user_id','=',$id)->first()->id;

        $bid = bid::create([
            'title' => $request->title,
            'descrption' => $request->descrption,
            'price' => $request->price,
            'image' => $image->getClientOriginalName(),
            'facility_id' => $facility_id
        ]);

        return $this->apiResponse(['bid' => $bid ],self::STATUS_CREATED,'add bid successfully');
    }

    public function get_bids()
    {
        $id = Auth::id();
        $facility_id = Facility::where('user_id','=',$id)->first()->id;
        $bidsCount = bid::where('facility_id',$facility_id)->count();
        if ($bidsCount > 0) {
            $bids = bid::where('facility_id',$facility_id)->get();
            return $this->apiResponse(['bids' => $bids],self::STATUS_CREATED,"bids got get successfully");
        } else {
            return $this->apiResponse(['Error' => "Not Found"], 404, 'No Data');
        }
    }

    public function edit_bid(Request $request,$id){

        $validator = $this -> apiValidation($request , [
            'title' => 'required|string|max:50',
            'descrption' => 'required|string|max:222',
            'price' => 'required|int',
            //'image' => 'required',
        ]);
        $bid = bid::findOrFail($id);
        if($validator instanceof Response) return $validator;

        $bid -> update([
            'title' => $request->title,
            'descrption' => $request->descrption,
            'price' => $request->price,
            // 'image' => $image->getClientOriginalName(),
        ]);
        return   $this->apiResponse(['bid' => $bid], self::STATUS_CREATED, 'Update bids successfully');
    }

    public function remove_bids($id)
    {
        $bid = bid::findOrFail($id);
        $bid -> delete();
        return "deleted successfully";
    }


}
