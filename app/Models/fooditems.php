<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\categories;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;



class fooditems extends Model
{
    use HasFactory;
    protected $hidden = ['id','status','created_at','updated_at','CatergoryID','branch_id'];
    protected $table = 'fooditems';
    protected $fillable = ['Image','Name','Description','CatergoryID','branch_id'];

    public function foodprice() {
        return $this->hasMany(food_price_quantity::class, "FoodID", "id");
    }

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

    public function foodcategory(){
        return  $this->belongsTo(categories::class,"CatergoryID","id");

    }
}