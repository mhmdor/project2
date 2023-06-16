<?php

namespace App\Http\Controllers\Api\TOURISM;

use App\Http\Controllers\Api\ApiController;
use App\Models\Ads;
use App\Models\tourism;
use App\Models\User;
use App\Traits\RestfulTrait;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TourismResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class adeController extends ApiController
{
    public function create_Ade(Request $request){

        $validator = $this -> apiValidation($request , [
            'title' => 'required|string|max:50',
            'descrption' => 'required|string|max:222',
            'image' => 'required',
        ]);

        if($validator instanceof Response) return $validator;

        $image = $request->file('image');
        $destinationPathImg = public_path('uploads/Ads/');
        if (!$image->move($destinationPathImg, $image->getClientOriginalName())) {
            return 'Error saving the file.';
        }
        $id = Auth::id();
        $get = tourism::where('user_id','=',$id)->get('id');
        $data = json_decode(  $get, true);
        $id = $data[0]['id'];
        $tourism_id = intval($id);

        $ads = Ads::create([
            'title' => $request->title,
            'descrption' => $request->descrption,
            'tourism_id' => $tourism_id,
            'image' => $image->getClientOriginalName(),
        ]);
        return response()->json($ads);
    }
   public  function test(){
        echo "hre";
   }
    public function edit_ade(Request $request,$id){

        $validator = $this -> apiValidation($request , [
            'title' => 'required|string|max:50',
            'descrption' => 'required|string|max:222',
            //'image' => 'required',
        ]);

        $ade = Ads::findOrFail($id);

        if($validator instanceof Response) return $validator;

//        $image = $request->file('image');
//        $destinationPathImg = public_path('uploads/BID/');
//        if (!$image->move($destinationPathImg, $image->getClientOriginalName())) {
//            return 'Error saving the file.';
//        }


        $ade -> update([
            'title' => $request->title,
            'descrption' => $request->descrption,
            // 'image' => $image->getClientOriginalName(),
        ]);
        return response()->json($ade);
    }


    public function remove_ade($id)
    {
        $ade = Ads::findOrFail($id);
        $ade->delete();
        return "deleted successfully";
    }
    public function get_ads()
    {
        $adsCount = Ads::count();
        if ($adsCount > 0) {
            $ads = Ads::get();
            return $ads;
        } else {
            return 'No ads found';
        }
    }
}
