<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index(Request $request) {
        if($request->has('category')) {
            $products = Product::forCategory($request->get('category'))->get();
        }else {
            $products = Product::all();
        }

        return response()->json([
            'products' => $products,
        ]);
    }

}
