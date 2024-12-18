<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SliderRequest;
use App\Models\Slider;
use App\Models\SliderTranslation;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index(Request $request)
    {
        $sliders = Slider::orderByDesc('published')->paginate(15);
        return view('backend.sliders.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        return view('backend.sliders.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(SliderRequest $request)
    {
        $slider = new Slider();
        $slider->link = $request->link;
        $slider->published = $request->has('published')? 1 : 0;
        $slider->photo = $request->photo;
        $slider->save();
        $slider_translations = SliderTranslation::firstOrNew(['slider_id' => $slider->id, 'locale' => $request->lang]);
        $slider_translations->photo = $request->photo_translate;
        $slider_translations->save();
        flash('Slider created successfully')->success();
        return redirect()->route('sliders.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     */
    public function edit($id, Request $request)
    {
        $lang = $request->lang;
        $slider = Slider::find($id);
        return view('backend.sliders.edit', compact('slider', 'lang'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(SliderRequest $request, $id)
    {
        $slider = Slider::find($id);
        if ($request->lang == env('DEFAULT_LANGUAGE')) {
            $slider->link = $request->link;
            $slider->photo = $request->photo;
        }
        $slider->published = $request->has('published') ? 1 : 0;
        $slider->save();
        $slider_translations = SliderTranslation::firstOrNew(['slider_id' => $slider->id, 'locale' => $request->lang]);
        $slider_translations->photo = $request->photo_translate;
        $slider_translations->save();
        flash('Slider updated successfully')->success();
        return redirect()->route('sliders.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        Slider::find($id)->delete();
        flash('Slider deleted successfully')->success();
        return redirect()->route('sliders.index');
    }

    public function update_published(Request $request)
    {
        $slider = Slider::find($request->id);
        $slider->published = $request->status;
        $slider->save();
        flash('Featured status updated successfully')->success();
        return 1;
    }
}
