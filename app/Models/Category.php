<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Products;

class Category extends Model
{
    use HasFactory;

   protected $fillable = ['name','slug','icon','created_at','updated_at'];

   public function product() {
    return $this->hasMany(Products::class);
   }
}
