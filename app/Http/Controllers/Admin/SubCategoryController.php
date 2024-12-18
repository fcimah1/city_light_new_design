<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubCategoryRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\SubCategoryTranslation;
use Illuminate\Http\Request;
use Str;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index(Request $request)
    {
        $sort_search =null;
        $subCategories = SubCategory::orderBy('featured','desc');
        if ($request->search != null) {
            $subCategories = $subCategories->where('name', 'like', '%'.$request->search.'%')
            ->orderBy('featured','desc');
            $sort_search = $request->search;
        }
        $subCategories = $subCategories->paginate(15);
        return view('backend.product.sub_category.index', compact('subCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        $categories = Category::all();
        return view('backend.product.sub_category.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(SubCategoryRequest $request)
    {
        $subCategory = new SubCategory;
        $subCategory->name = $request->name;
        $subCategory->category_id = $request->category_id;
        $subCategory->banner = $request->banner;
        $subCategory->icon = $request->icon;
        if ($request->commision_rate != null) {
            $subCategory->commision_rate = $request->commision_rate;
        }
        $subCategory->featured = $request->has("featured") ? 1 : 0;
        $subCategory->meta_title = $request->meta_title;
        $subCategory->meta_description = $request->meta_description;
        if ($request->slug != null) {
            $subCategory->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->slug));
        }
        else {
            $subCategory->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)).'-'.Str::random(5);
        }
        $subCategory->save();

        $subCategory_translation = SubCategoryTranslation::firstOrNew(['locale' => env('DEFAULT_LANGUAGE'), 'sub_category_id' => $subCategory->id]);
        $subCategory_translation->name = $request->name;
        $subCategory_translation->save();

        flash(translate('Sub Category has been inserted successfully'))->success();
        return redirect()->route('subcategories.index');
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
        $categories = Category::all();
        $subCategory = SubCategory::findOrFail($id);
        return view('backend.product.sub_category.edit', compact('subCategory', 'categories', 'lang'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(SubCategoryRequest $request, $id)
    {
        $subCategory = SubCategory::findOrFail($id);
        if($request->lang == env("DEFAULT_LANGUAGE")){
            $subCategory->name = $request->name;
        }
        $subCategory->category_id = $request->category_id;
        $subCategory->banner = $request->banner;
        $subCategory->icon = $request->icon;
        if ($request->commision_rate != null) {
            $subCategory->commision_rate = $request->commision_rate;
        }
        $subCategory->featured = $request->has("featured") ? 1 : 0;
        $subCategory->meta_title = $request->meta_title;
        $subCategory->meta_description = $request->meta_description;
        if ($request->slug != null) {
            $subCategory->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->slug));
        }
        else {
            $subCategory->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)).'-'.Str::random(5);
        }

        $subCategory->save();

        $subCategory_translation = SubCategoryTranslation::firstOrNew(['locale' => $request->lang, 'sub_category_id' => $subCategory->id]);
        $subCategory_translation->name = $request->name;
        $subCategory_translation->save();

        flash(translate('Sub Category has been updated successfully'))->success();
        return redirect()->route('subcategories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        $subCategory = SubCategory::findOrFail($id);
                // Category Translations Delete
        foreach ($subCategory->sub_Categories as $key => $category_translation) {
            $category_translation->delete();
        }
        
        foreach (Product::where('category_id', $subCategory->id)->get() as $product) {
            $product->category_id = null;
            $product->save();
        }
        $subCategory->delete();
        flash(translate('Sub Category has been deleted successfully'))->success();
        return redirect()->route('subcategories.index');
    }

    public function update_featured(Request $request)
    {
        $subCategory = SubCategory::findOrFail($request->id);
        $subCategory->featured = $request->status;
        $subCategory->save();
        return 1;
    }
}
