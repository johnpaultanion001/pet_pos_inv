<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->get();
        $products = Product::orderBy('expiration', 'asc')->get();
        return view('customer.home' , compact('products','categories'));
    }

    public function about()
    {
        return view('customer.about');
    }

    public function filter(Request $request){
        $filter = $request->get('filter');
        $value  = $request->get('value');

        if($filter == 'search'){
            $data = Product::where('name', 'LIKE', "%$value%")->latest()->get();
        }

        if($filter == 'category'){
            if($value == ''){
                $data = Product::orderBy('expiration', 'asc')->get();
            }else{
                $data = Product::where('category_id', $value)->orderBy('expiration', 'asc')->get();
            }
        }
        
        foreach($data as $item){
            $products[] = array(
                'id'           => $item->id,
                'name'         => $item->name,
                'category'     => $item->category->name,
                'image'        => $item->image,
            );
        }
        return response()->json([
            'products'  => $products,
        ]);
    }

    
}
