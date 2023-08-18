<?php
namespace App\Http\Controllers\Api;

use App\Models\Complain;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ComplainController extends ApiController
{
    public function createComplain(Request $request){

        $validator = $this -> apiValidation($request , [
            'complained_id' => 'required',
            'complainant_id' => 'required'
        ]);
        if($validator instanceof Response) return $validator;

        $cc = User::where('id','=',$request->complained_id)->exists();
        $c = User::where('id','=',$request->complainant_id)->exists();

        if(!$cc || !$c){
            return " not exist";
        }

        $complain= Complain::create([
            'complained_id' => $request->complained_id,
            'complainant_id' => $request->complainant_id,
            'status' => $request->status,
        ]);
        return $this->apiResponse(['complain' => $complain],self::STATUS_CREATED, 'add complain successfully');
    }

    public function showComplaint($complained_id){

        $cc = User::where('id','=',$complained_id)->exists();
        if(!$cc){
            return " not exist";
        }
        $complained_id = Complain::where('complained_id',$complained_id)
            ->pluck('complained_id')->first();
        $complained = User::where('id', $complained_id)->get();


        $complainant_ids = Complain::where('complained_id',$complained_id)
            ->pluck('complainant_id');
        $complainant = User::query();
       foreach ($complainant_ids as $complainant_id){
           $complainant =  $complainant->orWhere('id',$complainant_id);
       }
        $complainant = $complainant-> get();

        return $this->apiResponse(['complained'=>$complained,'complainant' => $complainant],self::STATUS_CREATED, 'show complain successfully');
    }


    public function UnReadCOMP(){
        $complins = Complain::where('status',0)->get();
        return $complins;
    }

    public function ReadCOMP(){
        $complins = Complain::where('status',1)->get();
        return $complins;
    }
    public function OWNER_READ($id){

        Complain::findOrFail($id);
        $complins = Complain::find($id);

            if($complins->status == 0){
                 $complins -> update(['status'=>1]);
                return $complins;
            }
            else
            {
                return "this complaint is readed";
            }

    }

}
