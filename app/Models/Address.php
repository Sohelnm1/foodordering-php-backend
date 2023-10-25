<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\User;


class Address extends Model
{
    use HasFactory;
    protected $table = "address";
    protected $hidden = ["id"];
    protected $fillable = [
        "Address1",
        "Address2",
        "State",
        "Country",
        "User_id"
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($category) {
            $category->slug = Str::slug($category->Address1);
        });

        self::updating(function ($category) {
            $category->slug = Str::slug($category->Address1);
        });
    }

    // public function address(){
    //     return $this->belongsTo(User::class,"User_id" , "id");

    public function user(){
    return $this->belongsTo(User::class, "User_id", "id");
    }


}