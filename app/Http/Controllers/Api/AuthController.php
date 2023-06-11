<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\FacilityResource;
use App\Http\Resources\TourismResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends ApiController
{
    /**
     * Create User
     * @param Request $request
     * @return User 
     */
    public function createUser(Request $request)
    {
        if ($request->role == 0) {
            $validator = $this->apiValidation($request, [
                'name' => 'required|string|max:255',
                'lName' => 'required|string|max:255',
                'mobile' => 'required|string|max:255|unique:users,mobile',
                'password' => 'required|string|max:255',
                'email' => 'email|unique:users,mobile|max:255',
            ]);
            if ($validator instanceof Response) return $validator;
            $user = User::create([
                'name' => $request->name,
                'lName' => $request->lName,
                'mobile' => $request->mobile,
                'password' => Hash::make($request->password),
                'email' => $request->email,
                'valid' => 1,
                'role' => $request->role,
                'birth'=> $request->birth,
                'gender'=>$request->gender,
            ]);
            $token = $user->createToken("API TOKEN")->plainTextToken;
            return $this->apiResponse(['client' => new UserResource($user),'token'=>$token], self::STATUS_CREATED, 'add client successfully');
        }
        if ($request->role == 1) {
            $validator = $this->apiValidation($request, [
                'name' => 'required|string|max:255',
                'mobile' => 'required|string|max:255|unique:users,mobile',
                'password' => 'required|string|max:255',
                'lat' => 'required',
                'long' => 'required',
                'email' => 'email|unique:users,mobile|max:255',
            ]);
            if ($validator instanceof Response) return $validator;
            $license = $request->file('license');
            $destinationPathImg = public_path('uploads/licenses/');
            if (!$license->move($destinationPathImg, $license->getClientOriginalName())) {
                return 'Error saving the file.';
            }
            $user = User::create([
                'name' => $request->name,
                'lat' => $request->lat,
                'mobile' => $request->mobile,
                'password' => Hash::make($request->password),
                'email' => $request->email,
                'valid' => 0,
                'long'=> $request->long,
                'role' => $request->role,
                'license'=>$license->getClientOriginalName() ,
                'description'=>$request->description,
            ]);
            $token = $user->createToken("API TOKEN")->plainTextToken;
            return $this->apiResponse(['tourism' => new TourismResource($user),'token'=>$token], self::STATUS_CREATED, 'add tourism successfully');
        }
        if ($request->role == 2) {
            $validator = $this->apiValidation($request, [
                'name' => 'required|string|max:255',
                'mobile' => 'required|string|max:255|unique:users,mobile',
                'password' => 'required|string|max:255',
                'lat' => 'required',
                'long' => 'required',
                'category_id'=>'required',
                'email' => 'email|unique:users,mobile|max:255',
            ]);
            if ($validator instanceof Response) return $validator;
            $license = $request->file('license');
        $destinationPathImg = public_path('uploads/licenses/');
        if (!$license->move($destinationPathImg, $license->getClientOriginalName())) {
            return 'Error saving the file.';
        }

        $license = $license->getClientOriginalName();
            $user = User::create([
                'name' => $request->name,
                'lat' => $request->lat,
                'mobile' => $request->mobile,
                'password' => Hash::make($request->password),
                'email' => $request->email,
                'valid' => 0,
                'long'=> $request->long,
                'role' => $request->role,
                'category_id'=>$request->category_id,
                'license'=>$license,
                'description'=>$request->description,
            ]);
            $token = $user->createToken("API TOKEN")->plainTextToken;
            return $this->apiResponse(['facility' => new FacilityResource($user),'token'=>$token], self::STATUS_CREATED, 'add facility successfully');
        }

       


        
    }

    
    
    public function login(Request $request)
    {
        
         $validate = $this->apiValidation($request,[
            'mobile'=>'required',
            'password' => 'required',
        ]);

        if ($validate instanceof Response) return $validate;

        $user = User::where('mobile', $request->mobile)->with('category')->first();

        if (!$user || !Hash::check($request->password, $user->password)) {

          return $this->apiResponse(null,self::STATUS_UNAUTHORIZED,'your password or email invalid ');
          
        }
        if ($user->valid == 0) {

            return $this->apiResponse(null,self::STATUS_UNAUTHORIZED,'User Not Valid ');
            
          }
        $token = $user->createToken("API TOKEN")->plainTextToken;
        if ($user->role == 0) {
            return $this->apiResponse(['client'=>new UserResource($user),'token'=>$token],self::STATUS_OK,'login successfully');
        }
        if ($user->role == 1) {
            return $this->apiResponse(['tourism'=>new TourismResource($user),'token'=>$token],self::STATUS_OK,'login successfully');
        }
        if ($user->role == 2) {
            $facility = $user;
            return $this->apiResponse(['facility'=>new FacilityResource($facility),'token'=>$token],self::STATUS_OK,'login successfully');
        }
       
        
        
    }
}