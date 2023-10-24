<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\food_price_quantity;

class FoodPriceQuantityController extends Controller
{
    //
        public function getall() {
        $datas = food_price_quantity::all();
        $result = [];
        foreach( $datas as $data ){
            if($data['status'] === 0){
                $result[] = $data;
            }
        }
        if($result){
            return response()->json(['message' => 'fetched sucessfully', 'data' => $result ]);
        }
        else{
            return response()->json(['message' => 'No data found']);
        } 
    }

    public function updateprice(Request $request, $id){
        $data = $request->all();
        $fooditem = food_price_quantity::find($id);
        if( $fooditem ){
            $fooditem->update($data);
            return response()->json(['message' => 'updated sucessfully' , 'data' => $fooditem]);
        }
        else {
            return response()->json(['message' => 'no data found' ]);
        }

    }

    public function deleteprice(Request $request){
       $foodid = $request->input('id');

        $foodprice = food_price_quantity::find($foodid);
        if ($foodprice) {
            
            $foodprice->status = 1;
            $foodprice->save();
            return response()->json(['message' => 'deleted sucessfully', 'data' => $foodprice]);
            // $category->delete();
        }
        else{
            return response()->json(['message' => 'no catergory found']);
        }
    }

}