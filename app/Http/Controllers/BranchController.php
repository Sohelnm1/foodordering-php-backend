<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\categories;
use App\Models\fooditems;

class BranchController extends Controller
{
    //
    public function store(Request $request) {
           $branch = $request->validate([
            "name" => "required|string",
            "phone" => "required|integer",
            "address" => "required|string",
            "email" => "required|string",
            "longitude" => "required|string",
            "latitude" => "required|string"
        ]);

        $response = Branch::create($branch);

        return response()->json(['message' => "New branch added" , 'data' => $response]);
    }
    public function get(){
        $response = Branch::all();

        return response()->json(['message' => "here's your data" , 'data' => $response]);
    }
    
    public function getcategorybybranch(Request $request, $branchname){
        // $branchname = $request->input('id');
        $data = Branch::with(["category"])->where("id", $branchname)->get();

        
        return response()->json($data);
    }

     public function getcategorybybranchname(Request $name){
        $category = Branch::whereHas('category', function ($query) use ($name) {
            $query->where('name', 'like', '%'.$name.'%');
        })->with('category')->get();

        return response($category);

        

        // $result = [];
        // foreach( $category as $data ){
        //     if($data['status'] === 0){
        //         $result[] = $data;
        //     }
        // }
        // if($result){
        //     return response()->json($result);
        // }
        // else{
        //     return response()->json(['message' => 'No category found']);
        // } 
    }

    // public function foodbybranch(Request $name){
    //     $foods = Branch::whereHas('food', function ($query) use ($name) {
    //         $query->where('name', 'like', '%'.$name.'%');
    //     })->get();

    //     return response($foods);
    // }

    public function foodbybranch($name){
        $addresses = Branch::whereHas('food', function ($query) use ($name) {
            $query->where('phone', 'like', '%'.$name.'%');
        })->with('food:id,Name')->get();

        return response($addresses);

        // $result = [];
        // foreach( $addresses as $data ){
        //     if($data['status'] === 0){
        //         $result[] = $data;
        //     }
        // }
        // if($result){
        //     return response()->json($result);
        // }
        // else{
        //     return response()->json(['message' => 'No Address found']);
        // } 
    }

    public function newcategorybybranch(Request $request, $branchname ){
        $data = $request->validate([
            "file" => "required",
            "Name" => "required|string",
            "Description" => "required|string",
        ]);

        $branch = Branch::where('name', 'like', '%' . $branchname . '%')->first();

            if ($branch) {
        
                $category = new categories();
                $category->Name = $data['Name'];
                $category->branch_id = $branch->id;
                $category->Description = $data['Description'];

                if ($request->hasFile('file')) {
                    $file = $request->file('file');
                    $category->Image = $data['file']->getClientOriginalName();
                    $file->move('uploads/', $category->Image);
                } 
                else 
                {
                    return response(['message' => "no file uploaded"]);
                }

                $category->save();

                return response()->json(['message' => 'added successfully'], 201);

            } 
            else {
                return response()->json(['message' => 'User not found']);
            }  
    }

    public function newfoodbybranch(Request $request, $branchname ,$categoryname){
        $data = $request->validate([
            "file" => "required",
            "Name" => "required|string",
            "Description" => "required|string"

        ]);
        

        $branch = Branch::where('slug', 'like', '%' . $branchname . '%')->first();

        // return response($branch);

        if ($branch) {
            $categories = $branch->category()->where('Name', 'like', '%' . $categoryname . '%')->select('id', 'Name')->get();

            // return response($categories);


            if ($categories->isNotEmpty()) {

                $response = [];

                foreach ($categories as $category) {
                    $food = new fooditems();
                    $food->Name = $data['Name'];
                    $food->branch_id = $branch->id;
                    $food->Description = $data['Description'];
                    // $food->Image = $data['Image'];
                    $food->CatergoryID = $category->id;

                    if ($request->hasFile('file')) {
                        $file = $request->file('file');
                        $food->Image = $data['file']->getClientOriginalName();
                        $file->move('uploads/fooditem', $food->Image);
                    } 
                    else 
                    {
                        return response(['message' => "no file uploaded"]);
                    }

                    $food->save();
                    $response[] = $food;
                }

                return response()->json(['message' => 'added successfully', 'data' => $response ], 201);
 
            }
            else {
                return response()->json(['message' => 'Category not found']);
            }
        } 
        else {
            return response()->json(['message' => 'Branch not found']);
        }
    }

    public function displayfoodbybranchcategory(Request $request, $branchname, $categoryname) {
        $branch = Branch::where('slug', $branchname)->first();

        if ($branch) {
            $foodItems = $branch->food()->whereHas('foodcategory', function ($query) use ($categoryname) {
                $query->where('Name', $categoryname);
            })->select('id', 'Name', 'Description', 'Image')->get();

            if ($foodItems->isNotEmpty()) {
                return response()->json(['message' => 'Food items in this category', 'data' => $foodItems]);
            } else {
                return response()->json(['message' => 'No food items in this category']);
            }
        } 
        else 
        {
            return response()->json(['message' => 'No branch by this name']);
        }
}




}