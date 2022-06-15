<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index () {
        $title = '';
        $categories = Category::get('title')->all();
        $products = Product::all();
        return view ('front.shop' , compact('products' , 'categories' , 'title'));
    }

    public function show($title) {
        $product = Product::where('title' , '=' , $title)->first();
        return view('front.showProduct' , compact('product'));
    }

    public function showCategory($title) {
        $categories = Category::get('title')->all();
        $products = Category::where('title' , '=' , $title)->first()->products;
        return view('front.shop' , compact('categories','products' , 'title'));
    }
}
