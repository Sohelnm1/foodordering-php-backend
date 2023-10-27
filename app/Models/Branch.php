<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use App\Models\categories;
use App\Models\fooditems;

class Branch extends Model
{
    protected $table = 'branch';
    protected $hidden = ['created_at','updated_at','status'];
    protected $fillable = ['name','phone','address','email','longitude' ,'latitude','status'];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($category) {
            $category->slug = Str::slug($category->name);
        });

        self::updating(function ($category) {
            $category->slug = Str::slug($category->name);
        });
    }

    public function category() {
        return $this->hasMany(categories::class, "branch_id", "id");

    }
    public function food() {
        return $this->hasMany(fooditems::class, "branch_id", "id");
    }

}