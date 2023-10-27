<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\fooditems;

class FoodItemsController extends Controller
{
    //
    public function getall() {
        $datas = fooditems::all();    
        foreach( $datas as $data ){
            if($data['status'] === 0){
                $result[] = $data;
            }
        }
        if($result> 0){
            return response()->json($result);
        }
        else{
            return response()->json(['message' => 'No data found']);
        } 
    }
    public function updatefood(Request $request, $id){
        $data = $request->all();
        $fooditem = fooditems::find($id);
        if( $fooditem ){
            $fooditem->update($data);
            return response()->json(['message' => 'updated sucessfully' , 'data' => $fooditem]);
        }
        else {
            return response()->json(['message' => 'no data found' ]);
        }

    }

    public function deletefood(Request $request){
       $foodid = $request->input('id');

        $food = fooditems::find($foodid);
        if ($food) {
            
            $food->status = 1;
            $food->save();
            return response()->json(['message' => 'deleted sucessfully', 'data' => $food]);
            // $category->delete();
        }
        else{
            return response()->json(['message' => 'no catergory found']);
        }
    }

    public function foodwithcatergoryprice(){

        $food = fooditems::with(["foodcategory","foodprice" ])->get();


        if($food){
            // return response()->json([
            //     "Name" => $food->foodwithcatergoryprice->Name,
            //     "Description" => $food->foodwithcatergoryprice->Description,
            // ]);
            return response()->json($food);
        }
        else{
            return response()->json(['message' => 'not found']);
        }
    }

    // public function foodwithcatergoryprice() {
    // $food = fooditems::with(["foodcategory", "foodprice"])->get();

    // $result = [];

    // foreach ($food as $fooditem) {
    //     $result[] = [
    //         "Name" => $fooditem->foodcategory->Name,
    //         "Description" => $fooditem->foodcategory->Description,
    //     ];
    // }

    // if (!empty($result)) {
    //     return response()->json($result);
    // } else {
    //     return response()->json(['message' => 'not found']);
    // }
    // }

    public function fooditembycategory(Request $request, $categoryname){
        
    }
}