<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\categories;
use App\Models\fooditems;
use App\Models\food_price_quantity;

class CategoriesController extends Controller
{
    //
    public function display() {
        $datas = categories::all();      
        $result = [];
        foreach( $datas as $data ){
            if($data['status'] === 0){
                $result[] = $data;
            }
        }
        if($result > 0){
            return response()->json($result);
        }
        else{
            return response()->json(['message' => 'No data found']);
        } 
        // $data = categories::with(["fooditem", "fooditem.foodprice"])->get();
    }

    public function bycategory(Request $request) {
        $catergoryid = $request->input('id');
        $data = categories::with(["fooditem", "fooditem.foodprice"])->where("id", $catergoryid)->get();
        
        return response()->json($data);
    }

    public function deletecategory(Request $request) {
        $categoryid = $request->input('id');

        $category = categories::find($categoryid);
        if ($category) {
            
            $category->status = 1;
            $category->save();
            return response()->json(['message' => 'deleted sucessfully', 'data' => $category]);
            // $category->delete();
        }
        else{
            return response()->json(['message' => 'no catergory found']);
        }
    }

    public function updatecategory(Request $request, $id) {
    $data = $request->all();
    $category = categories::find($id);

    if ($category) {
        $category->update($data);

        return response()->json(['message' => 'Category updated successfully']);
    } else {
        return response()->json(['message' => 'Category not found'], 404);
    }
}


    
}