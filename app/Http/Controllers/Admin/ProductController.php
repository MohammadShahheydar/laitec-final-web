<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FileController;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Jobs\ForceDelete;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\ProductSlider;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    use FileController;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($title)
    {
        $id = Category::where('title', '=', $title)->first()->id;
        return view('back.product.create', compact('id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProductRequest $request)
    {

        $productSliders = $request->file('productSlider');
        $sizes = $request->input('size');
        $sizes = array_map('trim', $sizes);

        $imageName = $this->uploadFile($request->file('image'), 'images/product');

        $product = Product::create([
            'size' => json_encode($sizes),
            'title' => $request->input('title'),
            'price' => $request->input('price'),

            'description' => $request->input('description'),
            'category_id' => $request->input('category_id'),
            'image' => $imageName
        ]);

        foreach ($productSliders as $productSlider) {
            $imageName = $this->uploadFile($productSlider, 'images/productSlider/');

            Image::create([
                'image' => $imageName,
                'imageable_type' => Product::class,
                'imageable_id' => $product->id
            ]);
        }

        return redirect()->route('category.show', $product->category->title);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($title)
    {
        $product = Product::where('title', '=', $title)->first();
        $category = Category::all()->pluck('title', 'id');
        return view('back.product.edit', compact('product', 'category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $title)
    {
        $product = null;
        $image = $request->file('image');
        $productSliders = $request->file('productSlider');
        $deletedSlider = array_filter(explode('|.|', $request->input('deletedSlider')));

        $sizes = $request->input('size');
        $sizes = array_map('trim', $sizes);

        if (isset($image) && !empty($image)) {
            $product = Product::where('title', '=', $title)->first();
            $oldImage = $product->image;
            $this->deleteFile('/images/products/' . $oldImage);
            $newImage = $this->uploadFile($request->input('image'), '/images/products/');
            $product->update([
                'image' => $newImage,
                'size' => json_encode($sizes),
                'title' => $request->title,
                'price' => $request->input('price'),

                'category_id' => $request->category_id,
                'description' => $request->description,
            ]);
        } else {
            $product = Product::where('title', '=', $title)->first();
            $product->update([
                'size' => json_encode($sizes),
                'title' => $request->title,
                'price' => $request->input('price'),
                'category_id' => $request->category_id,
                'description' => $request->description,
            ]);
        }

        if ((isset($deletedSlider) && !empty($deletedSlider))) {
            $oldProductSlider = $product->productSliders;

            foreach ($oldProductSlider as $slider) {
                if (in_array($slider->image, $deletedSlider)) {
                    $oldSliderImage = $slider->image;
                    $this->deleteFile('images/productSlider/' . $oldSliderImage);
                    $slider->forceDelete();
                }
            }
        }

        if (isset($productSliders) && !empty($productSliders)) {
            foreach ($productSliders as $productSlider) {
                $imageName = $this->uploadFile($productSlider, 'images/productSlider/');
                Image::create([
                    'image' => $imageName,
                    'imageable_type' => Product::class,
                    'imageable_id' => $product->id
                ]);
            }
        }

        $categoryTitle = Category::findOrFail($request->category_id)->title;

        return redirect()->route('category.show', $categoryTitle);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($title)
    {
        $product = Product::where('title', '=', $title)->first();
        $oldImage = $product->image;
        $productSlider = $product->productSliders;
        $product->delete();
        $dispatchId = ForceDelete::dispatch($product, 'images/product/' . $oldImage)->delay(now()->addMinutes());

        return redirect()->route('category.show', $product->category->title);
    }
}
