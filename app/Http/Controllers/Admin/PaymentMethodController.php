<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Cache;
use Illuminate\Http\Request;
use Str;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index(Request $request)
    {
        $sort_search =null;
        $paymentMethods = PaymentMethod::orderBy('name','desc');
        if ($request->has('search')) {
            $sort_search = $request->search;
            $paymentMethods = PaymentMethod::where('name', 'like', '%' . $sort_search . '%');
        }
        $paymentMethods = $paymentMethods->paginate(15);
        return view('backend.setup_configurations.payment_method.index', compact('paymentMethods', 'sort_search'));
    }


    /**
     * Show the form for creating a new resource.
     *
     */
    public function create(Request $request)
    {
        $lang = $request->lang;
        return view('backend.setup_configurations.payment_method.create', compact('lang'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        $payment_method = new PaymentMethod;
        // if ($request->lang == env("DEFAULT_LANGUAGE")) {
            $payment_method->name = $request->name;
        // }
        if ($request->slug != null) {
            $payment_method->slug = strtolower($request->slug);
        }
        else {
            $payment_method->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)).'-'.Str::random(5);
        }
        $payment_method->icon = $request->icon;
        $payment_method->fees = $request->fees;
        $payment_method->public_key = $request->public_key;
        $payment_method->secret_key = $request->secret_key;
        $payment_method->marchent_code = $request->marchent_code;
        $payment_method->status = $request->has('status')? Status::ACTIVE: Status::INACTIVE;
        $payment_method->description = $request->description;
        $payment_method->meta_title = $request->meta_title;
        $payment_method->meta_description = $request->meta_description;
        $payment_method->save();
        Cache::forget('payment_methods');
        flash('success', 'Payment Method added successfully!');
        return redirect()->route('payment_methods.index');
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
    public function edit(int $id, Request $request)
    {
        $lang = $request->lang;
        $method = PaymentMethod::findOrFail($id);
        return view('backend.setup_configurations.payment_method.edit', compact('method', 'lang'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(Request $request, $id)
    {
        $payment_method = PaymentMethod::findOrFail($id);
        if ($request->lang == env("DEFAULT_LANGUAGE")) {
            $payment_method->name = $request->name;
        }
        if ($request->slug != null) {
            $payment_method->slug = strtolower($request->slug);
        }
        else {
            $payment_method->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)).'-'.Str::random(5);
        }
        $payment_method->icon = $request->icon;
        $payment_method->fees = $request->fees;
        $payment_method->public_key = $request->public_key;
        $payment_method->secret_key = $request->secret_key;
        $payment_method->marchent_code = $request->marchent_code;
        $payment_method->status = $request->has('status')? Status::ACTIVE: Status::INACTIVE;
        $payment_method->description = $request->description;
        $payment_method->meta_title = $request->meta_title;
        $payment_method->meta_description = $request->meta_description;
        $payment_method->save();

        Cache::forget('payment_methods_status');
        flash('success', 'payment method updated successfully');
        return redirect()->route('payment_methods.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        $payment_method = PaymentMethod::findOrFail($id);
        $payment_method->delete();
        Cache::forget('payment_methods_status');
        return redirect()->back()->with('success', 'Payment Method Deleted Successfully');
    }


    public function update_status(Request $request)
    {
        $payment_method = PaymentMethod::find($request->id);
        $payment_method->status = $request->status;
        $payment_method->save();
        Cache::forget('payment_methods_status');
        return 1;
    }

}
