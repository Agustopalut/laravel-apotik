<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Products;
use App\Models\User;

class Carts extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','product_id','created_at','updated_at'];

    public function product() {
        return $this->belongsTo(Products::class);
        // sebuah cart, pasti memiliki 1 product 
    }

    public function user() {
        return $this->belongsTo(User::class);
        // sebuah cart, pasti memiliki 1 user
    }
}
