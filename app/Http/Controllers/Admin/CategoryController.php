<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCategoryRequest;
use App\Jobs\ForceDelete;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::withTrashed()->get();
        foreach ($categories as $category) {
            $category->setAttribute('count', $category->products()->count());
        }
        return view('back.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCategoryRequest $request)
    {
        Category::create([
            'title' => $request->input('title')
        ]);

        return redirect()->route('category.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($title)
    {
//      Category::where("title" , $title)->first()->products()->withTrashed() <- withTrashed nemishe
        $categoryId = Category::where('title', '=', $title)->first()->id;
        $products = Product::withTrashed()->where('category_id', '=', $categoryId)->get();
        return view('back.category.show', compact('products', 'title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($title)
    {
        //
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
        $data = $request->validate([
            'title' => 'required|max:40|string'
        ]);
        Category::where('title', '=', $title)->first()->update([
            'title' => $data['title']
        ]);
        return redirect()->route('category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($title)
    {
        $category = Category::where('title', '=', $title)->first();
        $category->delete();
        ForceDelete::dispatch($category)->delay(now()->addMinutes(20));
        return redirect()->route('category.index');
    }

    public function restore($title)
    {
        Category::withTrashed()->where('title', '=', $title)->first()->restore();
        return redirect()->route('category.index');
    }

    public function forceDelete($title)
    {
        Category::withTrashed()->where('title', '=', $title)->first()->forceDelete();
        return redirect()->route('category.index');
    }
}
