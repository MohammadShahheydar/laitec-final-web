<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $slider = Slider::all();
        return view('front.index' , compact('slider'));
    }
}
