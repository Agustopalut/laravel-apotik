<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Products;
use App\Models\ProductTransaction;

class TransactionDetails extends Model
{
    use HasFactory;

    protected $fillable = ['product_transaction_id','price','product_id','created_at','updated_at'];

    public function product_transaction() {
        return $this->belongsTo(ProductTransaction::class);
        // sebuah transaksi pasti 1 transaksi yang melakukan 
    }
    public function product() {
        return $this->belongsTo(Products::class);
        // pasti 1 product yang berelasi 
    }
}
