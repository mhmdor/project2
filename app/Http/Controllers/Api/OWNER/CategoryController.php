<?php

namespace App\Http\Controllers\Api\OWNER;

use App\Http\Controllers\Api\ApiController;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends ApiController
{
   public function createCategory(Request $request ){

       $validator = $this-> apiValidation($request ,['name' => 'required']);
       if($validator instanceof Response) return $validator;
       $category = Category::create(['name' => $request -> name]);
       return $this->apiResponse(['category' => $category],self::STATUS_CREATED, 'add category successfully');
   }

   public function removeCategory($id){
       $category = Category::findOrFail($id);
       $category -> delete();
       return 'removed successfully';
   }

   public function getCategory($id){
       $category = Category::findOrFail($id);
       $category ->first();
       return $category;
   }

   public function GetAllCategory(){

       $category = Category::all();
       return $category;
   }

   public function EditCategory($id,Request $request){
       $category = Category::findOrFail($id);
       $validator = $this-> apiValidation($request ,['name' => 'required']);
       if($validator instanceof Response) return $validator;
       $category -> update(['name' => $request -> name]);
       return $category;
   }
}
