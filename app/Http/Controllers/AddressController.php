<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Address;
use App\Models\User;

class AddressController extends Controller
{
    //
    public function newaddress(Request $request){
        $address = $request->validate([
            "Address1" => "required|string",
            "Address2" => "string",
            "State" => "required|string",
            "Country" => "required|string",
            "User_id" => "required|integer"
        ]);

        $response = Address::create($address);

        return response()->json(['message' => "New address added" , 'data' => $response]);
    }


    public function useraddress($name){
        $addresses = Address::whereHas('user', function ($query) use ($name) {
            $query->where('name', 'like', '%'.$name.'%');
        })->with('user:id,name,email')->get();

        $result = [];
        foreach( $addresses as $data ){
            if($data['status'] === 0){
                $result[] = $data;
            }
        }
        if($result){
            return response()->json($result);
        }
        else{
            return response()->json(['message' => 'No Address found']);
        } 
    }

    // $users = User::whereHas('posts', function($q){
    //     $q->where('created_at', '>=', '2015-01-01 00:00:00');
    // })->get();


    public function getalladdress(){

        $datas = Address::with('user')->get();      
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



    public function update(Request $request , $id){


        $address = $request->all();

        $address = $request->validate([
            "Address1" => "required|string",
            "Address2" => "string",
            "State" => "required|string",
            "Country" => "required|string"
        ]);

        $addressid = Address::find($id);

        if ($addressid){
            $addressid->update($address);
            return response()->json(['message' => "Updated" , "data" => $address]);
        }
        else{
            return response()->json(['message' => 'no data found']);
        }

    }

    public function updateByname(Request $request , $name, $address){
        // $address = $request->all();

        $updatedata = $request->validate([
            "Address1" => "required|string",
            "Address2" => "string",
            "State" => "required|string",
            "Country" => "required|string"
        ]);

        $addresses = Address::whereHas('user', function ($query) use ($name) {
        $query->where('name', 'like', '%'.$name.'%');
        })->orWhere('Address1','like', '%'.$address.'%')->with('user:id,name,email')->get();

        $result = [];
        foreach($addresses as $data) {
            if($data->slug == $address && $data->user->name == $name){
                $result[] = $data;
            }
        }
        // return response($result);

        // return response($addresses);

         if (empty($result)) {
        return response()->json(['message' => 'No matching address found']);
        }

        foreach ($result as $address) {

            $attributes = [
                "Address1" => $updatedata["Address1"],
                "Address2" => $updatedata["Address2"],
                "State" => $updatedata["State"],
                "Country" => $updatedata["Country"]
            ];

            $address->update($attributes);
        }

        return response()->json(['message' => 'updated', 'data' => $address]);
    }

    public function deleteaddress(Request $request , $id){

        $address = Address::find($id);
        if ($address) {
            
            $address->status = 1;
            $address->save();
            return response()->json(['message' => 'deleted sucessfully', 'data' => $address]);
            // $category->delete();
        }
        else{
            return response()->json(['message' => 'no address found']);
        }

    }

    public function userdeleteaddress(Request $request, $name, $addressname){
        $address = Address::whereHas('user', function ($query) use ($name) {
        $query->where('name', 'like', '%'.$name.'%');
        })->orWhere('slug','like', '%'.$addressname.'%')->with('user:id,name')->get();

        // return response($address);

        foreach ($address as $data) {
            
            if ($data->slug === $addressname && $data->user->name === $name) {
                $data->status = 1;
                $data->save();
                return response()->json(['message' => "Status updated"]);
            }
        }
        return response()->json(['message' => "No matching address found"]);

    }

    public function adduseraddress(Request $request, $username ){
        $data = $request->validate([
            "Address1" => "required|string",
            "Address2" => "required|string",
            "State" => "required|string",
            "Country" => "required|string" 
        ]);

            $user = User::where('name', 'like', '%' . $username . '%')->first();

            // return($user);

            if ($user) {
                // Address create
                $address = new Address([
                'Address1' => $data['Address1'],
                'Address2' => $data['Address2'],
                'State' => $data['State'],
                'Country' => $data['Country'],
                'User_id' => $user->id,
                ]);
                $address->save();
                return response()->json(['message' => 'Address added successfully']);

            } 
            else {
                return response()->json(['message' => 'User not found']);
            }
    }

}