<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show ($title) {
        $product = Product::where('title' , '=' , $title);
        return view ('front.showProduct' , compact('product'));
    }
}
