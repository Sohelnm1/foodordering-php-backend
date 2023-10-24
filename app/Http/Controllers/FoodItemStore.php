<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\fooditems;

class FoodItemStore extends Controller
{
    //
     public function foodstore(Request $request){
        $data = $request->all();
        $result = fooditems::create($data);

        return response()->json( ['message' => 'added sucessfully', 'data' => $result], 201 );
    }
}