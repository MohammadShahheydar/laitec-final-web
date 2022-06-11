<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FileController;
use App\Http\Requests\CreateSliderRequest;
use App\Jobs\ForceDelete;
use App\Models\Image;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SliderController extends Controller
{

    use FileController;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sliders = Slider::with('image')->get();
        return view('back.slider.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back.slider.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateSliderRequest $request)
    {

        $imageName = $this->uploadFile($request->file('image'), 'images/slider');

        $slider = Slider::create([
            'alt' => $request->input('alt'),
        ]);

        Image::create([
            'image' => $imageName,
            'imageable_type' => Slider::class,
            'imageable_id' => $slider->id
        ]);

        return redirect()->route('slider.index');
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
    public function edit($id)
    {
        $slider = Slider::findOrFail($id);
        return view ('back.slider.edit' , compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if($request->file('image')) {
            $slider = Slider::findOrFail($id);
            $slider->update([
                'alt' => $request->input('alt'),
            ]);

            $this->deleteFile('images/slider/'.$slider->image->image);
            $imageName = $this->uploadFile($request->file('image'), 'images/slider/');

            $slider->image()->update([
                'image' => $imageName
            ]);

        } else {
            Slider::findOrFail($id)->update([
                'alt' => $request->input('alt')
            ]);
        }

        return redirect()->route('slider.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $slider = Slider::findOrFail($id);
        $slider->delete();
        ForceDelete::dispatch($slider, 'images/slider/' . $slider->image->image, $slider->image)->delay(now()->addMonth());
        return redirect()->route('slider.index');
    }

    public function restore() {

    }

    public function ajaxIndex(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'index' => 'required|integer',
            'previous' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }


        if ($request->index === 0) {
            Slider::findOrFail($id)->update([
                'index' => null
            ]);
            return response()->json('indexes change successfully', 201);
        } else if ($request->input('previous') === 0) {
            Slider::findOrFail($id)->update([
                'index' => $request->input('index')
            ]);
        } else {
            $prevId = Slider::where('index', '=', $request->input('index'))->get(['id']);
            Slider::where('index', '=', $request->input('index'))->first()->update([
                'index' => null
            ]);


            Slider::findOrFail($id)->update([
                'index' => $request->input('index')
            ]);

            Slider::findOrFail($prevId)->first()->update([
                'index' => $request->input('previous')
            ]);

            return response()->json('indexes change successfully', 201);
        }
    }
}
