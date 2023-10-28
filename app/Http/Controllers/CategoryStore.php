<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\categories;

class CategoryStore extends Controller
{
    //
     public function store(Request $request){
    $category = new categories();
    $category->Name = $request->input('Name');
    $category->branch_id = $request->input('branch_id');
    $category->Description = $request->input('Description');

    if ($request->hasFile('file')) {
        $file = $request->file('file');
        $category->Image = $file->getClientOriginalName();
        $file->move('uploads/', $category->Image);
    } else {
        return response(['message' => "no file uploaded"]);
    }

    $category->save();

    return response()->json(['message' => 'added successfully'], 201);
}


    
}