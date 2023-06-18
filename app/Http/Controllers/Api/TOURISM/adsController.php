<?php

namespace App\Http\Controllers\Api\TOURISM;

use App\Http\Controllers\Api\ApiController;
use App\Models\Ads;
use App\Models\tourism;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class adsController extends ApiController
{
    public function createAds(Request $request){

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
        $tourism_id = tourism::where('user_id','=',$id)->first()->id;
       

        $ads = Ads::create([
            'title' => $request->title,
            'descrption' => $request->descrption,
            'tourism_id' => $tourism_id,
            'image' => $image->getClientOriginalName(),
        ]);
      return   $this->apiResponse(['ads' => $ads], self::STATUS_CREATED, 'add ads successfully');
    }

    public function getAds()
    {
        $id = Auth::id();
        $tourism_id = tourism::where('user_id','=',$id)->first()->id;
        $adsCount = Ads::where('tourism_id',$tourism_id)->count();
        if ($adsCount > 0) {
            $ads = Ads::where('tourism_id',$tourism_id)->get();
            return   $this->apiResponse(['ads' => $ads], self::STATUS_CREATED, 'get ads successfully');
        } else {
            return $this->apiResponse(['Error' => "Not Found"], 404, 'No Data');
        }
    }
  
    public function editAds(Request $request,$id){

        $validator = $this -> apiValidation($request , [
            'title' => 'required|string|max:50',
            'descrption' => 'required|string|max:222',
            //'image' => 'required',
        ]);

        $ads = Ads::findOrFail($id);

        if($validator instanceof Response) return $validator;




        $ads -> update([
            'title' => $request->title,
            'descrption' => $request->descrption,
            // 'image' => $image->getClientOriginalName(),
        ]);
        return   $this->apiResponse(['ads' => $ads], self::STATUS_CREATED, 'Update ads successfully');
    }


    public function removeAds($id)
    {
        $ads = Ads::findOrFail($id);
        $ads->delete();
        return "deleted successfully";
    }
    
}
