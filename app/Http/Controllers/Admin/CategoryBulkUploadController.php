<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;


use App\Models\brandsImport;
use App\Models\CategoriesImport;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\SubSubCategory;
use App\Models\Brand;
use App\Models\User;
use Auth;
use App\Models\ProductsImport;
use App\Models\ProductsExport;
use PDF;
use Excel;
use Illuminate\Support\Str;

class CategoryBulkUploadController extends Controller
{
    public function index()
    {

        if (Auth::user()->user_type == 'seller') {
            return view('frontend.user.seller.product_bulk_upload.index');
        }
        elseif (Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'staff') {
            return view('backend.product.category_bulk_upload.index');
        }
    }

    public function export(){
        return Excel::download(new ProductsExport, 'products.xlsx');
    }

    public function pdf_download_category()
    {
        $categories = Category::all();

        return PDF::loadView('backend.downloads.category',[
            'categories' => $categories,
        ], [], [])->download('category.pdf');
    }

    public function pdf_download_brand()
    {
        $brands = Brand::all();

        return PDF::loadView('backend.downloads.brand',[
            'brands' => $brands,
        ], [], [])->download('brands.pdf');
    }

    public function pdf_download_seller()
    {
        $users = User::where('user_type','seller')->get();

        return PDF::loadView('backend.downloads.user',[
            'users' => $users,
        ], [], [])->download('user.pdf');

    }

    public function bulk_upload(Request $request)
    {


        if($request->hasFile('bulk_file')){

            $import = new CategoriesImport();
            Excel::import($import, request()->file('bulk_file'));

            if(addon_is_activated('seller_subscription')){
                $seller = Auth::user()->seller;
                $seller->remaining_uploads -= $import->getRowCount();
                $seller->save();
            }

        }
//        dd('Row count: ' . $import->getRowCount());

        return back();
    }
    public function bulk_brand_upload(Request $request)
    {


        if($request->hasFile('bulk_file')){

            $import = new brandsImport();
            Excel::import($import, request()->file('bulk_file'));

            if(addon_is_activated('seller_subscription')){
                $seller = Auth::user()->seller;
                $seller->remaining_uploads -= $import->getRowCount();
                $seller->save();
            }

        }
//        dd('Row count: ' . $import->getRowCount());

        return back();
    }

}
