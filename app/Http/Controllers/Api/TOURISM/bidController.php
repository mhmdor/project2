<?php

namespace App\Http\Controllers\Api\TOURISM;

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

class bidController extends ApiController
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
        $get = Facility::query()->where('user_id','=',$id)->get('id');
        $data = json_decode(  $get, true);
        $id = $data[0]['id'];
        $facility_id = intval($id);


        $bid = bid::create([
            'title' => $request->title,
            'descrption' => $request->descrption,
            'price' => $request->price,
            'image' => $image->getClientOriginalName(),
            'facility_id' => $facility_id
        ]);
        return response()->json( $bid );
    }

    public function edit_bid(Request $request,$id){

        $validator = $this -> apiValidation($request , [
            'title' => 'required|string|max:50',
            'descrption' => 'required|string|max:222',
            'price' => 'required|int',
            'image' => 'required',
        ]);

        $bid = bid::findOrFail($id);

        if($validator instanceof Response) return $validator;

        $image = $request->file('image');
        $destinationPathImg = public_path('uploads/BID/');
        if (!$image->move($destinationPathImg, $image->getClientOriginalName())) {
            return 'Error saving the file.';
        }
        $id = Auth::id();
        $get = Facility::query()->where('user_id','=',$id)->get('id');
        $data = json_decode(  $get, true);
        $id = $data[0]['id'];
        $facility_id = intval($id);

        $bid = bid::update([
            'title' => $request->title,
            'descrption' => $request->descrption,
            'price' => $request->price,
            'image' => $image->getClientOriginalName(),
            'facility_id' => $facility_id
        ]);

        return response()->json( $bid );
    }

    public function remove_bids($id)
    {
        $b = bid::findOrFail($id);
        $b->delete();
        return "deleted successfully";
    }

    public function get_bids()
    {
        $bidsCount = bid::count();
        if ($bidsCount > 0) {
            $bids = bid::get();
            return $bids;
        } else {
            return  'No bids found';
        }
    }
}
