<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdsRequest;
use App\Models\Ads;
use App\Models\AdsTranslation;
use Cache;
use Illuminate\Http\Request;

class AdsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index(Request $request)
    {
        $sort_search =null;
        $ads = Ads::orderByDesc('featured');
        if($request->has('search')) {
            $sort_search = $request->search;
            $ads = Ads::where('name', 'like', '%' . $sort_search . '%')
                        ->orderBy('id', 'desc');
        }
        $ads = $ads->paginate(15);
        return view('backend.ads.index', compact('ads', 'sort_search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        $activeStatus = Status::ACTIVE;
        $inactiveStatus = Status::INACTIVE;
        return view('backend.ads.create')->with(['activeStatus' => $activeStatus, 'inactiveStatus' => $inactiveStatus]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(AdsRequest $request)
    {
        dd($request->all());
        $ads = new Ads();
        $ads->name = $request->name;
        $ads->banner = $request->banner;
        $ads->link = $request->link;
        $ads->status = $request->status;
        $ads->featured = $request->featured;
        $ads->start_date = $request->start_date;
        $ads->end_date = $request->end_date;
        $ads->meta_title = $request->meta_title;
        $ads->meta_description = $request->meta_description;
        $ads->save();
        $ads_translations = AdsTranslation::firstOrNew(['ads_id' => $ads->id, 'locale' => env('DEFAULT_LANGUAGE') ]);
        $ads_translations->name = $request->name;
        $ads_translations->image = $request->english_banner;
        $ads_translations->save();
        flash(__('front.ads has been inserted successfully'))->success();
        return redirect()->route('ads.index');
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
    public function edit(Request $request , int $id)
    {
        $lang = $request->lang;
        $ad = Ads::findOrFail($id);
        return view('backend.ads.edit', compact('ad', 'lang'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(AdsRequest $request, $id)
    {
        $ads = Ads::findOrFail($id);
        if($request->lang == env('DEFAULT_LANGUAGE')) {
            $ads->name = $request->name;
            $ads->banner = $request->banner;
            $ads->save();
        }
        $ads->link = $request->link;
        $ads->status = $request->status;
        $ads->featured = $request->has('featured')? 1 : 0;
        $ads->start_date = $request->start_date;
        $ads->end_date = $request->end_date;
        $ads->save();
        $ads_translations = AdsTranslation::firstOrNew(['ads_id' => $ads->id, 'lang' => $request->lang]);
        $ads_translations->name = $request->name;
        $ads_translations->image = $request->english_banner;
        $ads_translations->save();
        flash(__('front.ads has been updated successfully'))->success();
        return redirect()->route('ads.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        $ads = Ads::findOrFail($id);
        $ads->delete();
        flash(__('front.ads has been deleted successfully'))->success();
        return redirect()->route('ads.index');
    }

    //change status
    public function changeStatus(Request $request)
    {
        $ads = Ads::findOrFail($request->id);
        $ads->status = $request->status;
        $ads->save();
        Cache::forget('featured_ads');
        return 1;
    }

    //change featured
    public function changeFeatured(Request $request)
    {
        $ads = Ads::findOrFail($request->id);
        $ads->featured = $request->featured;
        $ads->save();
        Cache::forget('featured_ads');
        return 1;
    }
}
