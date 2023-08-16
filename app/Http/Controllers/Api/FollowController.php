<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Follow;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class FollowController extends ApiController
{
    const STATUS_CREATED = 201;

    public function follow($follow_id, Request $request){

       //$followed_id = User::query()->exists($follow_id);
       $follow = User::query()->where('id','=',$follow_id)->first();
       if(!$follow){
          return 'this id not exist';
       }
        $user_id = Auth::id();
       $followed = Follow::query()->create([
           'user_id' => $user_id,
           'followed_id' => $follow_id
       ]);
        return $this->apiResponse(['follow ' => $followed ],self::STATUS_CREATED, 'add follow successfully');
    }

    public function UnFollow($id){


        $user_id = Auth::id();
        $follower = Follow::query()
             -> where('user_id','=',$user_id)
             -> where('followed_id','=',$id)
             -> first();
        if(!$follower){
            return 'this id is not exist';
        }
        Follow::query()
            -> where('user_id','=',$user_id)
            -> where('followed_id','=',$id)
            -> delete();

        return "unfollowed successfully";
    }

    public function get_followers($follow_id){

        $follow = Follow::query()->where('followed_id','=',$follow_id)->first();
        if(!$follow){
            return "this id does not exist";
        }
        $follow = Follow::query()->
        where('followed_id','=',$follow_id)->get();
        return $follow;
    }

}
