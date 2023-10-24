<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\categories;

class CategoryStore extends Controller
{
    //
     public function store(Request $request){
        $data = $request->all();
        // $data['status'] = 0;
        $result = categories::create($data);

        return response()->json( ['message' => 'added sucessfully', 'data' => $result], 201 );
    }

    
}