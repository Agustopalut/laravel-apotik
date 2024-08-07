<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('products.index',[
            'products' => Products::with('category')->orderBy('id','DESC')->get()
            // di orderBy id DESC, tujuan agar mendapatkan id terbesar / data terbaru yang di input 
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        return view("products.create",[
            'categories' => Category::all(),
        ]);
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'about' => 'required|string',
            'price' => 'required|integer',
            'category_id' => 'required|integer',
            'photo' => 'required|image|mimes:jpg,png,jpeg,svg,webp'
        ]);
        // jika datanya sudah siap
        DB::beginTransaction();

        try {
            if($request->hasFile('photo')) {
                // apakah user benar mengirim sebuah gambar/icon

                $iconPath = $request->file('photo')->store('products_photo','public');
                $validate['photo'] = $iconPath;//melakukan validasi dari image yang dikirim 

            }

            $validate['slug'] = Str::slug($request->name); // membuat slug otomatis 
            // obat sakit = obat-sakit
            $newProducts = Products::create($validate);

            DB::commit();

            return redirect()->route('admin.products.index');
        } catch(\Exception $e) {
            // jika gagal 
            DB::rollBack();
            // data tidak jadi masuk ke database
            // method ValidationException, itu sudah otomatis mengemabalikan ke halaman sebelum nya 
            $error = ValidationException::withMessages([
                'system_error' => ['system eror!' . $e->getMessage()]
            ]);

            throw $error;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Products $product)
    {
        return view('products.edit',[
            'product' => $product,
            'categories' => Category::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Products $product)
    {
        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'about' => 'required|string',
            'price' => 'required|integer',
            'category_id' => 'required|integer',
            'photo' => 'sometimes|image|mimes:jpg,png,jpeg,svg,webp'
            // hanya photo yang bersifat sometimes 
        ]);
        // jika datanya sudah siap
        DB::beginTransaction();

        try {
            if($request->hasFile('photo')) {
                // apakah user benar mengirim sebuah gambar/icon

                $iconPath = $request->file('photo')->store('products_photo','public');
                $validate['photo'] = $iconPath;//melakukan validasi dari image yang dikirim 

            }

            $validate['slug'] = Str::slug($request->name); // membuat slug otomatis 
            // obat sakit = obat-sakit
            $product->update($validate);
            DB::commit();

            return redirect()->route('admin.products.index');
        } catch(\Exception $e) {
            // jika gagal 
            DB::rollBack();
            // data tidak jadi masuk ke database
            // method ValidationException, itu sudah otomatis mengemabalikan ke halaman sebelum nya 
            $error = ValidationException::withMessages([
                'system_error' => ['system eror!' . $e->getMessage()]
            ]);

            throw $error;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Products $product)
    {
        // dd($product);
        try {

            $product->delete(); // delete data cara1

            // DB::find($category->id)->delete(); // cara 2

            return redirect()->back();
        } catch (\Exception $e) {

            $error = ValidationException::withMessages([
                'system_erros' => ['system_error!' . $e->getMessage()]
            ]);

            throw $error;

        }
    }
}
