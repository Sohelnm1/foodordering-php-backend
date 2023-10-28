<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Partners extends Model
{
    use HasFactory;
    protected $hidden = ['created_at','updated_at','status'];
    protected $fillable = ["name","link","image","branch_id","status","slug"];

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

    public function branch(){
        return  $this->belongsTo(Branch::class,"banch_id","id");
    }
}