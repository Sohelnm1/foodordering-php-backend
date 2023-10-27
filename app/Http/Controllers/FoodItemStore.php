<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\fooditems;

class FoodItemStore extends Controller
{
    //
     public function foodstore(Request $request){
        // $data = $request->all();

        $data = $request->validate([
            "Image" => "required|string",
            "Name" => "required|string",
            "Description" => "required|string",
            "CatergoryID" => "required|integer",
            "branch_id" => "required|integer"

        ]);
        $result = fooditems::create($data);

        return response()->json( ['message' => 'added sucessfully', 'data' => $result], 201 );
    }
}