<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TransactionDetails;
class ProductTransaction extends Model
{
    use HasFactory;

    protected $guarded = ['id']; //id tidak boleh diisi karena diisi otomatis oleh mysql 

    public function user() {
        return $this->belongsTo(User::class);
        // sebuah transaksi pasti 1 user yang melakukan nya 
    }

    public function transaction_details() {
        return $this->hasMany(TransactionDetails::class);
        // 1 transaksi bisa melakukan banyak transaksi product
    }
}
