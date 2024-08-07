<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Products;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index() {
        
        return view('front.index',[
            'products' => Products::filter(request(['search']))->with('category')->orderBy('id','DESC')->take(6)->get(), // mengambil 6 data terakhir ,
            'categories' => Category::all()
        ]);
    }
    

    public function details (Products $products) {
        return view('front.detail',[
            'product' => $products
        ]);
    }

    public function search(Request $request) {

        $keyword = $request->input('keyword');
        $products = Products::where('name','LIKE','%' . $keyword .'%')->get();

        return view('front.search',[
            'keyword' => $keyword,
            'products' => $products
        ]);

    }

    public function category(Category $category) {

        $products = Products::where('category_id',$category->id)->get();

        return view('front.category',[
            'keyword' => $category->name,
            'products' => $products
        ]);


    }
}
