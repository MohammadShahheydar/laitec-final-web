<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index () {
        $product = Product::all();
        return view ('front.shop' , compact('product'));
    }

    public function show($title) {
        $product = Product::where('title' , '=' , $title)->first();
        return view('front.showProduct' , compact('product'));
    }
}
