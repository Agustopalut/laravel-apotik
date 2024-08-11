<?php

namespace App\Http\Controllers;

use App\Models\ProductTransaction;
use App\Models\TransactionDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Traits\HasRoles;


class ProductTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $user = User::where("id", '=' ,Auth::user()->id);
        $user = Auth::user();
        if($user->hasRole('buyer')) {
            // jika yang login itu sebagai pembeli  
            // $user = User::where('id', '=', Auth::user()->id);

            $product_transaction = $user->product_transaction()->orderBy('id','DESC')->get(); //jika ingin di urutkan
            // $product_transaction = $user->product_transaction; // jika tidak ingin diurutkan
            // kita tidak bisa menggunakan $user->product_transaction->orderBy('id','DESC'), karena kita ingin melakukan orderBY
            // mendapatkan product transaction dari user yang login 

        } else {
            $product_transaction = ProductTransaction::orderBy('id','DESC')->get();
        }   
        return view('product-transactions.index',[
            'product_transaction' => $product_transaction
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
    public function store(Request $request)
    {   

        $user = Auth::user();

        $validated = $request->validate([
            'city' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'note' => 'required|string',
            'proof' => 'required|image|mimes:jpg,jpeg,png,svg,webp',
            'phone_number' => 'required|string|max:255',
            'post_code' => 'required|string|max:255',
        ]);
        DB::beginTransaction();
        try {

            if($request->hasFile('proof')) {
            // upload file
                $iconPath = $request->file('proof')->store('payment-proof','public');
                $validated['proof'] = $iconPath;
            }
            // melakukan validasi ulang 
            // angka nya kita ubah dahulu ke perak
            // 1000 = 100 perak
            $subTotalCents = 0;
            $promoCents = 10000 * 100;

            $cartItems = $user->cart; // mendapatkan semuanya cart dari user yang login 
    

            foreach($cartItems as $item) {
                $subTotalCents += $item->product->price * 100; //100 perak
            }


            $taxCents = (int)round(11 * $subTotalCents / 100); //ppn 11%
            $insuranceCents = (int)round(23 * $subTotalCents / 100); //insurance 23%

            $grandTotalCents = $subTotalCents + $taxCents + $insuranceCents + $promoCents;

            $grandTotal = $grandTotalCents / 100; // mengembalikan perak ke ribuan (cents ke dolar jika menggunakan dolar )
            $validated['user_id'] = $user->id;
            $validated['is_paid'] = false;
            $validated['total_amount'] = $grandTotal;

            $newTransaction = ProductTransaction::create($validated);

            foreach ($cartItems as $item) {

                TransactionDetails::create([
                    'product_transaction_id' => $newTransaction->id,
                    'product_id' => $item->product->id,
                    'price' => $item->product->price
                ]);
                

                $item->delete(); // setelah dimasukan ke transaction details, hapus dari keranjang nya 
            }

            DB::commit();

            return redirect()->route('product-transaction.index');

        } catch(\Exception $e) {

            DB::rollBack();
            $error = ValidationException::withMessages([
                'system_error' => ['sytem_error!'. $e->getMessage()]
            ]);

            throw $error;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductTransaction $productTransaction)
    {
        $product_transaction = ProductTransaction::with('transaction_details.product')->find($productTransaction->id);        // karena transaction details berelasi ke table product, maka kita bisa mengambil data product nya langsung
        // mendapatkan data transaksi details berdasarkan id product_transaction nya 


        return view('product-transactions.details',[
            'transaction' => $product_transaction
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductTransaction $productTransaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductTransaction $productTransaction)
    {
        try {

            ProductTransaction::where('id','=',$productTransaction->id)->update([
                'is_paid' => 1
            ]);
    
            return redirect()->back();

        } catch (\Exception $e) {
            $error = ValidationException::withMessages([
                'system_error' => ['system_erro!' . $e->getMessage()]
            ]);

            throw $error;
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductTransaction $productTransaction)
    {
        //
    }
}
