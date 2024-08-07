<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('category.index',[
            'categories' => Category::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('category.create');
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'required|image|mimes:jpg,png,jpeg,svg'
        ]);
        // jika datanya sudah siap
        DB::beginTransaction();

        try {
            if($request->hasFile('icon')) {
                // apakah user benar mengirim sebuah gambar/icon

                $iconPath = $request->file('icon')->store('category_icon','public');
                $validate['icon'] = $iconPath;//melakukan validasi dari image yang dikirim 

            }

            $validate['slug'] = Str::slug($request->name); // membuat slug otomatis 
            // obat sakit = obat-sakit
            $newCategory = Category::create($validate);

            DB::commit();

            return redirect()->route('admin.categories.index');
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
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {

        return view('category.edit',[
            'category' => $category,
        ]);
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //
        $validate = $request->validate([
            'name' => 'sometimes|string|max:255',
            'icon' => 'sometimes|image|mimes:jpg,png,jpeg,svg'
            // sometimes artinya bersifat optional, bisa diupdate atau tidak 
        ]);
        // jika datanya sudah siap
        DB::beginTransaction();

        try {
            if($request->hasFile('icon')) {
                // apakah user benar mengirim sebuah gambar/icon

                $iconPath = $request->file('icon')->store('category_icon','public');
                $validate['icon'] = $iconPath;//melakukan validasi dari image yang dikirim 

            }

            $validate['slug'] = Str::slug($request->name); // membuat slug otomatis 
            // obat sakit = obat-sakit
            $category->update($validate);

            DB::commit();

            return redirect()->route('admin.categories.index');
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
    public function destroy(Category $category)
    {
        // dd($category); //melakukan debug 
        try {

            $category->delete(); // delete data cara1

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
