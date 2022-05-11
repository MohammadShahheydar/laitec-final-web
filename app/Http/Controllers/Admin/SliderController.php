<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FileController;
use App\Http\Requests\CreateSliderRequest;
use App\Models\Slider;
use Illuminate\Http\Request;
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
        $sliders = Slider::all();
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

        Slider::create([
            'image' => $imageName,
            'alt' => $request->input('alt'),
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
        dd('test');
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
        dd('test');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $file = Slider::findOrFail($id);
        $this->deleteFile('images/slider/' . $file->image);
        $file->delete();
        return redirect()->route('slider.index');
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
