<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocialMedia;
use Illuminate\Http\Request;

class SocialMediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $allSocialMedia = SocialMedia::paginate(15);
        return view('backend.setup_configurations.social_media.index', compact('allSocialMedia'));
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        return view('backend.setup_configurations.social_media.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        $socialMedia = new SocialMedia();
        $socialMedia->name       = $request->name;
        $socialMedia->icon       = $request->icon;
        $socialMedia->link       = $request->link;
        $socialMedia->is_active  = $request->has('status') ? 1 : 0;
        $socialMedia->header_tag = $request->header_tag;
        $socialMedia->footer_tag = $request->footer_tag;
        $socialMedia->save();
        flash('success', 'Social Media Created Successfully');
        return redirect()->route('social_media.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     */
    public function edit($id,Request $request)
    {
        $lang = $request->lang;
        $socialMedia = SocialMedia::findOrFail($id);
        return view('backend.setup_configurations.social_media.edit', compact('socialMedia', 'lang'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(Request $request, $id)
    {
        $socialMedia = SocialMedia::findOrFail($id);
        $socialMedia->name       = $request->name;
        $socialMedia->icon       = $request->icon;
        $socialMedia->link       = $request->link;
        $socialMedia->is_active  = $request->has('status') ? 1 : 0;
        $socialMedia->header_tag = $request->header_tag;
        $socialMedia->footer_tag = $request->footer_tag;
        $socialMedia->save();
        flash('success', 'Social Media Updated Successfully');
        return redirect()->route('social_media.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        $socialMedia = SocialMedia::findOrFail($id);
        $socialMedia->delete();
        flash('success', 'Social Media Deleted Successfully');
        return redirect()->route('social-media.index');
    }

    public function socialMediaStatusUpdate(Request $request)
    {
        $socialMedia = SocialMedia::findOrFail($request->id);
        $socialMedia->is_active = $request->status;
        $socialMedia->save();
        return 1;
    }
}
