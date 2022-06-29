<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FileController;
use App\Http\Requests\CreateBannerRequest;
use App\Models\Banner;
use App\Models\Product;
use Illuminate\Http\Request;
use Hekmatinasser\Verta\Verta;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class BannerController extends Controller
{
    use FileController;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banners = Banner::all();
        return view ('back.banner.index' , compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Cache::get('banner')) {
            return redirect()->route('banner.index');
        }
        $products = Product::with('category')->get(['image' , 'title' , 'category_id' , 'price' , 'description']);
        return view('back.banner.create' , compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateBannerRequest $request)
    {
        $deadline = Verta::parseFormat('Y/m/d H:i:s' , $request->input('persianDatapicker') , 'Asia/Tehran');
        $product = Product::where('title' , '=' , $request->input('product'))->first();
        $productId = $product->id;
        $imageName = $this->uploadFile($request->file('image') , 'images/banner/');
        Banner::create([
            'title' => $request->input('title'),
            'image' => $imageName ,
            'last_price' => $request->input('lastPrice'),
            'new_price' => $request->input('newPrice'),
            'product_id' => $productId,
            'discount_deadline' => $deadline,
            'publish' => 1
        ]);

        $product->update([
            'price' => $request->input('newPrice')
        ]);

        Cache::rememberForever('banner' , function () {
            return true;
        });

        return redirect()->route('panel');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($title)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($title)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $title)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($title)
    {
        $banner = Banner::where('title' , '=' , $title)->first();
        $this->deleteFile('images/banner/'.$banner->image);
        Cache::forget('banner');

        return redirect()->route('panel');
    }
}
