<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\FoodItemsController;
use App\Http\Controllers\FoodPriceQuantityController;
use App\Http\Controllers\CategoryStore;
use App\Http\Controllers\FoodItemStore;
use App\Http\Controllers\FoodPriceStore;
use App\Http\Controllers\FoodItemCategoryController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\BranchController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Branch store 
Route::post('/branchstore',[BranchController::class,'store']);

// Branch display
Route::get('/branchget',[BranchController::class,'get']);

// category display by branch id
Route::get('/branch/{branchid}/categorybybranch',[BranchController::class, 'getcategorybybranch']);

// category display by branch name not working
Route::get('/branch/{branchname}/categorybybranchname',[BranchController::class, 'getcategorybybranchname']);

// food display by branchname not working
Route::get('/branch/{branchname}/foodbybranch',[BranchController::class, 'foodbybranch']);

// category store by branchname 
Route::post('/branch/{branchname}/newcategory',[BranchController::class,"newcategorybybranch"]);

// Food store by branchname & categoryname
Route::post('/branch/{branchname}/newfood/{categoryname}', [BranchController::class,"newfoodbybranch"]);

// Food display by branchname & categoryname 
Route::get('/branch/{branchame}/category/{categoryname}',[BranchController::class, "displayfoodbybranchcategory"]);

// Update delete pending from branch and display also


//  Display all catergories list 
Route::get("/categories",[CategoriesController::class,'display']);

//  Store new category 
Route::post('/categoriestore',[CategoryStore::class,'store']);

//  Display all fooditems list 
Route::get("/foods",[FoodItemsController::class,'getall']);

//  Store new fooditems
Route::post('/fooditems',[FoodItemStore::class,'foodstore']);

// Display all food with their category and price 
Route::get("/getfood", [FoodItemsController::class,'foodwithcatergoryprice']);

// Display all food with category name 
Route::get("/getfood/{categoryname}", [FoodItemsController::class,'fooditembycategory']);
// in process

//  Display all foodprice list 
Route::get("/foodprice",[FoodPriceQuantityController::class,'getall']);

//  Store new fooditem price
Route::post('/foodprice',[FoodPriceStore::class,'store']);

// Login api
Route::post('/auth/login',[AuthController::class,'login']);

// Register api
Route::post('/auth/register',[AuthController::class,'register']);


// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/auth/logout',[AuthController::class,'logout']);

    // get category by name 
    Route::post("/catergorybyname/{name}",[CategoriesController::class, 'categoryname']);

    //  Getting data by id category food and price
    Route::get("/categorybyid",[CategoriesController::class,'bycategory']);

    //  delete catergory setting status 1
    Route::get("/deletecategory",[CategoriesController::class,'deletecategory']);

    //  Update category by id
    Route::put("/updatecategory/{id}",[CategoriesController::class,'updatecategory']);

    // Update fooditem 
    Route::put('/updatefooditem/{id}', [FoodItemsController::class, 'updatefood']);

    // Delete fooditem
    Route::get("/deletefooditem", [FoodItemsController::class,'deletefood']);

    //  Update Food item
    Route::put('/updateprice/{id}', [FoodPriceQuantityController::class, 'updateprice']);

    // Delete foodprice 
    Route::get("/foodpricedelete", [FoodPriceQuantityController::class,'deleteprice']);

    // New Address store 
    Route::post('/useraddress', [AddressController::class,"newaddress"]);

    // New address by user 
    Route::post('/user/{name}/newaddress', [AddressController::class,"adduseraddress"]);

    // list address of users
    Route::get('/getuseraddress/{name}',[AddressController::class,"useraddress"]);

    // get all address of each users
    Route::get('/alladdress',[AddressController::class,"getalladdress"]);

    // Update address
    Route::put('/update/{id}',[AddressController::class,"update"]);

    // Update address by username 
    Route::put('/user/{name}/address/{addressname}',[AddressController::class,"updateByname"]);

    // set status to 1 delete
    Route::post('/delete/address/{id}', [AddressController::class, "deleteaddress"]);

    // set status to 1 delete
    Route::post('/user/{name}/deleteaddress/{addressname}', [AddressController::class, "userdeleteaddress"]);


    // store orders random
    Route::post('/order', [OrderController::class, "orderstore"]);

    // create order by user
    Route::post('/user/{user}/order/{orderitem}', [OrderController::class, "createuserorder"]);

    // read user orders 
    Route::get('/order/{name}', [OrderController::class, "userorder"]);

    // read all orders 
    Route::get('/order', [OrderController::class, "orderall"]);

    // delete orders
    // Route::post('/order', [OrderController::class, "deleteall"]);

    // delete user orders
    Route::post('/user/{name}/orderdelete/{order}', [OrderController::class, "userdelete"]);

});