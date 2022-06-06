<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $slider = Slider::all();
        $categories = Category::all();
        $banner = Banner::first();
        $categoryTitles = $categories->pluck('title');
        $productsId = array();

        foreach ($categories as $category) {
            $productsId [] = $category->products()->orderBy('created_at' , 'desc')->take(2)->pluck('id');
        }

        for ($i = 0 ; $i < count($productsId) ; $i++) {
            $productsId[$i] = $productsId[$i]->toArray();
        }

        $productsId = call_user_func_array('array_merge' , $productsId);
        $products = Product::findMany($productsId);

        return view('front.index' , compact('slider' , 'categoryTitles' , 'products' , 'banner'));
    }
}
