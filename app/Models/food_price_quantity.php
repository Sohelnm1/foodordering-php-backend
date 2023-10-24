<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class food_price_quantity extends Model
{
    use HasFactory;
    protected $hidden = ['id','status'];
    protected $table = 'food_price_quantity';
    protected $fillable = ["FoodID", "Price" , "Quantity"];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($category) {
            $category->slug = Str::slug($category->Price);
        });

        self::updating(function ($category) {
            $category->slug = Str::slug($category->Price);
        });
    }

    // public function fooditemsmodel(){
    //     return $this->belongsTo(fooditems::class, "FoodID" , "id");
    // }
}