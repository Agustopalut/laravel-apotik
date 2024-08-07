<?php

namespace App\Http\Controllers;

use App\Models\Carts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class CartsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $my_cart = Carts::where('user_id',Auth::user()->id)->with('product')->get();
        // mendapatkan cart yang dimiliki oleh user yang dicari 

        return view('front.cart',[
            'my_carts' => $my_cart
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($productId) 
    {
        // dd($productId);
        $user = Auth::user();

        // mengecek apakah sebelum nya user sudah menambahkan product tersebut ke dalam keranjang
        // ini untuk mencegah adanya duplicate data di keranjang 
        $existingCart = Carts::where("user_id", $user->id)->where('product_id',$productId)->first();
        
        if($existingCart) {
            // jika ada, maka kita cukup redirect ke halaman keranjang
            return redirect()->route('carts.index');
        }

        // jika belum pernah
        // baru simpan ke database 
        DB::beginTransaction();
        try{

            Carts::create([
                'user_id' => $user->id,
                'product_id' => $productId
            ]);

            DB::commit();

            return redirect()->route('carts.index');

        } catch (\Exception $e) {

            DB::rollBack();
            $error  =ValidationException::withMessages([
                'system_error' => ['system_error' . $e->getMessage()],
            ]);

            throw $error;

        };
    }

    /**
     * Display the specified resource.
     */
    public function show(Carts $carts)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Carts $carts)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Carts $carts)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Carts $cart)
    {
        // dd($cart->id);
        try {

            $cart->delete(); // karena sudah pasti mendapatkan id nya, kita tinggal delete saja 
            return redirect()->back(); // kembalikan ke halaman cart

             
        } catch (\Exception $e) {

            $error = ValidationException::withMessages([
                'system.error' => ['system_error'. $e->getMessage()],
            ]);

            throw $error;

        }
    }
}
