<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Partners;
use App\Models\Branch;

class PartnersController extends Controller
{

    public function store(Request $request) {
        $data = $request->validate([
            'name' => 'required|string',
            'link' => 'required|string',
            'image' => 'required|image|max:100', 
            'branch_id' => 'required|string',
        ]);

        $partner = new Partners();
        $partner->name = $data['name'];
        $partner->link = $data['link'];
        $partner->branch_id = $data['branch_id'];

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = $data['name'] . '.' . $file->getClientOriginalExtension();
        
            if ($file->getSize() <= 100000) {
                $file->move('uploads/branch/partner/', $filename);
                $partner->image = $filename;
            } else {
            return response(['error' => 'Image size is too large. Maximum allowed size is 100KB']);
        }
        } else {
            return response(['error' => "No file uploaded"]);
        }

    $partner->save();

    return response()->json(['message' => 'Added successfully'], 201);
    }


    public function partnerstorebybranch(Request $request, $branchname) {
        
        $branch = Branch::where('name', $branchname)->first();

        if (!$branch) {
            return response()->json(['error' => 'Branch not found'], 404);
        }

        $data = $request->validate([
            'name' => 'required|string',
            'link' => 'required|string',
            'image' => 'required|image|max:100',
        ]);

        $partner = new Partners();
        $partner->name = $data['name'];
        $partner->link = $data['link'];
        $partner->branch_id = $branch->id; 

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = $data['name'] . '.' . $file->getClientOriginalExtension();
            $file->move('uploads/branch/partner/', $filename);
            $partner->image = $filename;
        } else {
            return response(['message' => 'No file uploaded']);
        }

        $partner->save();

        return response()->json(['message' => 'Partner added successfully'], 201);
    }
    
    public function partnersbybranch($branchname){

        $branch = Branch::where('slug', $branchname)->first();

        if(!$branch){
            return response()->json(['error' => 'Branch not found'], 404);
        }
        else {
            $branchid = $branch->id;
            // return resposne($branch->id);
            $data = Partners::where('branch_id', $branchid)->get();
            
            if ($data->isNotEmpty()){
                return response()->json(['data' => $data],200);
            }
            else {
                return response()->json(['error' => 'No partners found']);
            }
        }
    }

    public function displaypartners(){
        $partners = Partners::all();

        if ($partners->isNotEmpty()){
            return response()->json(['data' => $partners]);
        }
        else {
            return response()->json(['error' => 'No partners found']);
        }
    }

}