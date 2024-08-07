<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Carts;

class Products extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'about',
        'slug',
        'photo',
        'category_id',
        'created_at',
        'updated_at',
    ];

    public function scopeFilter($query, $filters) {
        $query->when($filters['search'] ?? false, function ($query,$search) {
            $query->where('name','LIKE','%' . $search .'%');
        });
    }


    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function cart() {
        return $this->hasMany(Carts::class);
        // user bisa menyimpan banyak product pada carts 
    }
}
