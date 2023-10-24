<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\food_price_quantity;

class FoodPriceStore extends Controller
{
    //
     public function store(Request $request){
        $data = $request->all();
        $result = food_price_quantity::create($data);

        return response()->json( ['message' => 'added sucessfully', 'data' => $result], 201 );
    }
}