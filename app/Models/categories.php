<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class categories extends Model
{
    use HasFactory;
    protected $hidden = ['id','status'];
    protected $table = 'categories';
    protected $fillable = ['Image','Name','Description','slug'];

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