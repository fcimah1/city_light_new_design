<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Models\ShippngCompany;
use App\Models\ShippngCompanyTranslation;
use Illuminate\Http\Request;
use Str;

class ShippingCompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index(Request $request)
    {
        $sort_search = null;
        $shipmentsCompanies = ShippngCompany::orderBy('status', 'desc');
        if ($request->has('search')) {
            $sort_search = $request->search;
            $shipmentsCompanies = ShippngCompany::where('name', 'like', '%' . $sort_search . '%');
        }
        $shipmentsCompanies = $shipmentsCompanies->paginate(15);
        return view('backend.setup_configurations.shipping_companies.index', compact('shipmentsCompanies', 'sort_search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        //
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
        $company = ShippngCompany::findOrFail($id);
        return view('backend.setup_configurations.shipping_companies.edit', compact('company', 'lang'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(Request $request, $id)
    {
        $company = ShippngCompany::findOrFail($id);
        if ($request->lang == env('DEFAULT_LANGUAGE')) {
            $company->name = $request->name;
            $company->logo = $request->logo;
        }
        if ($request->slug != null) {
            $company->slug = strtolower($request->slug);
        } else {
            $company->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)) . '-' . Str::random(5);
        }
        $company->website = $request->has('website') ? $request->website : ' ';
        $company->email = $request->email;
        $company->phone = $request->phone;
        $company->featured = $request->has('featured') ? 1 : 0;
        $company->status = $request->has('status') ? Status::ACTIVE : Status::INACTIVE;
        $company->description = $request->description;
        $company->meta_title = $request->meta_title;
        $company->meta_description = $request->meta_description;
        $company->save();

        $company_translations = ShippngCompanyTranslation::firstOrNew(['shippng_company_id' => $company->id, 'locale' => $request->lang]);
        $company_translations->name = $request->name;
        $company_translations->slug = strtolower($request->slug);
        $company_translations->logo = $request->logo;

        $company_translations->save();
        flash('success', 'Shipping Company Updated Successfully');
        return redirect()->route('shipping_companies.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        //
    }

    //change status
    public function update_status(Request $request)
    {
        $ads = ShippngCompany::findOrFail($request->id);
        $ads->status = $request->status;
        $ads->save();
        return 1;
    }

    //change featured
    public function update_featured(Request $request)
    {
        $ads = ShippngCompany::findOrFail($request->id);
        $ads->featured = $request->featured;
        $ads->save();
        return 1;
    }

}