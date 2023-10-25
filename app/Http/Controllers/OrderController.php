<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\fooditems;

class OrderController extends Controller
{
    //
    public function orderstore(Request $request) {
        $order = $request->validate([
            "Name" => "required|string",
            "Amount" => "required|integer",
            "Qty" => "required|integer",
            "FoodID" => "required|integer",
            "Userid" => "required|integer"
        ]);

        $response = Order::create($order);

        return response()->json(['message' => "New order added" , 'data' => $response]);
    }

    public function createuserorder(Request $request, $username, $orderitem ){
        $data = $request->validate([
            "Name" => "required|string",
            "Amount" => "required|integer",
            "Qty" => "required|integer"
        ]);

            $user = User::where('name', 'like', '%' . $username . '%')->first();
    
            $foodItem = fooditems::where('slug', 'like', '%' . $orderitem . '%')->first();

            // return response($foodItem);
            // return response($user);


            if ($user && $foodItem) {
                // order create
                $order = new Order([
                'Name' => $data['Name'],
                'Amount' => $data['Amount'],
                'Qty' => $data['Qty'],
                'Userid' => $user->id,
                'FoodID' => $foodItem->id,
                ]);
                $order->save();
                return response()->json(['message' => 'Order created successfully']);

            } 
            else {
                return response()->json(['message' => 'User or food item not found']);
            }

    }

    public function userorder($name){

        // $datas = Order::with(['fooditem', 'user'])->get();  
        
        // $datas = Order::whereHas('user', function ($query) use ($name) {
        //     $query->where('name', 'like', '%'.$name.'%');
        // })->with(['fooditem','user'])->get();

        $datas = Order::whereHas('user', function ($query) use ($name) {
            $query->where('name', 'like', '%'.$name.'%');
        })->get();


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
    }
    
    //  public function useraddress($name){
    //     $addresses = Address::whereHas('user', function ($query) use ($name) {
    //         $query->where('name', 'like', '%'.$name.'%');
    //     })->with('user:id,name,email')->get();

    //     return response()->json(['data' => $addresses]);
    
    //     }


    public function orderall(){
        $data = Order::all();
        return response()->json(["message" => "here are all orders", "data" => $data]);
    }


    public function userdelete(Request $request, $name, $ordername){

        $orders = Order::whereHas('user', function ($query) use ($name) {
        $query->where('name', 'like', '%'.$name.'%');
        })->orWhere('Name','like', '%'.$ordername.'%')->with('user:id,name')->get();

        // return response($orders);

        foreach ($orders as $order) {
            
        if ($order->Name === $ordername && $order->user->name === $name) {
            $order->status = 1;
            $order->save();
            return response()->json(['message' => "Status updated"]);
        }
    }
    return response()->json(['message' => "No matching order found"]);
    }


}