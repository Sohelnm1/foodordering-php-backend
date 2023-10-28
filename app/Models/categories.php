<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

use App\Models\fooditems;

class categories extends Model
{
    use HasFactory;
    protected $hidden = ['status','created_at','updated_at','branch_id','id'];
    protected $table = 'categories';
    protected $fillable = ['Image','Name','Description','branch_id','slug'];

    public function fooditem() {
        return $this->hasMany(fooditems::class, "CatergoryID", "id");
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
    
}