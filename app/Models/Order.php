<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Order extends Model
{
    use HasFactory;
        protected $table = "order";
        protected $hidden = ["id"];
        protected $fillable = [
        "Name",
        "Amount",
        "Qty",
        "FoodID",
        "Userid",
        "status"
        ];

        public static function boot()
        {
         parent::boot();

            self::creating(function ($category) {
             $category->slug = Str::slug($category->Name);
            });

            self::updating(function ($category) {
             $category->slug = Str::slug($category->Name);
             });
         }


    public function fooditem(){
        return $this->belongsTo(fooditems::class, "FoodID", "id");
    }
    public function user(){
        return $this->belongsTo(User::class, "Userid", "id");
    }

}