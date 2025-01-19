<?php


namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Search;
use App\Models\Product;
use App\Models\Category;
use App\Models\FlashDeal;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Shop;
use App\Models\Attribute;
use App\Models\AttributeCategory;
use App\Models\Seller;
use App\Utility\CategoryUtility;

class SearchController extends Controller
{
    private  $design;
    public function __construct()
    {
        $this->design = 'frontend';
    }


    public function index(Request $request, $category_id = null, $brand_id = null)
    {
// dd($request->all());
        $pagination = isset($request->pagination)?$request->pagination:12;
        $query = $request->keyword;
        $brand_slug = $request->brand;
        $sort_by = $request->sort_by;
        $filter_by = $request->filter_by;
        $min_price = null;
        $max_price = null;
        if(isset($request->min_price)){

            $number1 = $this->remove_dollar_sign_and_get_number($request->min_price);
            $number2 = $this->remove_dollar_sign_and_get_number($request->max_price);

            $min_price = $number1;
            $max_price = $number2;
        }


        $seller_id = $request->seller_id;
//        $attributes = Attribute::all();
//        $selected_attribute_values = array();
//        $colors = Color::all();
//        $selected_color = null;

        $conditions = ['published' => 1];

        if($brand_id != null){
            $conditions = array_merge($conditions, ['brand_id' => $brand_id]);
        }elseif ($request->brand != null) {
            $brand_id = (Brand::where('slug', $request->brand)->first() != null) ? Brand::where('slug', $request->brand)->first()->id : null;
            $conditions = array_merge($conditions, ['brand_id' => $brand_id]);
        }

        if($seller_id != null){
            $conditions = array_merge($conditions, ['user_id' => Seller::findOrFail($seller_id)->user->id]);
        }

        $products = Product::where($conditions);

        if($category_id != null){
            $category_ids = CategoryUtility::children_ids($category_id);
            $category_ids[] = $category_id;

            $products->whereIn('category_id', $category_ids);

//            $attribute_ids = AttributeCategory::whereIn('category_id', $category_ids)->pluck('attribute_id')->toArray();
//            $attributes = Attribute::whereIn('id', $attribute_ids)->get();
        }


        if($min_price != null && $max_price != null){
            $products->where('unit_price', '>=', $min_price)->where('unit_price', '<=', $max_price);
        }

        if($brand_slug != null){
            // $searchController = new SearchController;
            // $searchController->store($request);
            Brand::where(function ($q) use ($query){
                foreach (explode(' ', trim($query)) as $word) {
                    $q->where('name', 'like', '%'.$word.'%')->
                    orWhere('slug', 'like', '%'.$word.'%')
                        ->orWhereHas('brand_translations', function($q) use ($word){
                        $q->where('name', 'like', '%'.$word.'%');
                    });
                }
            });
        }


        if($query != null){
            $searchController = new SearchController;
            $searchController->store($request);

            $products->where(function ($q) use ($query){
                foreach (explode(' ', trim($query)) as $word) {
                    $q->where('name', 'like', '%'.$word.'%')->
                    orWhere('tags', 'like', '%'.$word.'%')
                        ->orWhereHas('product_translations', function($q) use ($word){
                        $q->where('name', 'like', '%'.$word.'%');
                    });
                }
            });
        }

        switch ($sort_by) {
            case 'newest':
                $products->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $products->orderBy('created_at', 'asc');
                break;
            case 'price-asc':
                $products->orderBy('unit_price', 'asc');
                break;
            case 'price-desc':
                $products->orderBy('unit_price', 'desc');
                break;
            case 'best-seller':
                $products->where('best', 1);
                break;
            case 'best-review':
                $products->orderBy('rating', 'desc');
                break;
            default:
                $products->orderBy('id', 'desc');
                break;
        }
        switch ($filter_by) {
            case 'new-arrival':
                $products->where('featured',1);
                break;
            case 'best-seller':
                $products->where('best', 1);
                break;
            case 'hot-offer':
                $products->where('todays_deal', 1);
                break;
        }

//        if($request->has('color')){
//            $str = '"'.$request->color.'"';
//            $products->where('colors', 'like', '%'.$str.'%');
//            $selected_color = $request->color;
//        }
//
//        if($request->has('selected_attribute_values')){
//            $selected_attribute_values = $request->selected_attribute_values;
//            foreach ($selected_attribute_values as $key => $value) {
//                $str = '"'.$value.'"';
//                $products->where('choice_options', 'like', '%'.$str.'%');
//            }
//        }

        $products = filter_products($products)->with('taxes')->paginate($pagination)->appends(request()->query());
//         $categories = Category::withCount([
//             'products',
//
//               'products as products_count'=>function($query){
//                   $query->where('published', 1);
//               }
//               ])->get('name','slug');
         $brands = Brand::get();
        return view($this->design .'.shop', compact(
//            'categories',
            'brands',
            'products',
            'query',
            'category_id',
            'brand_id',
            'sort_by',
            'seller_id',
            'min_price',
            'pagination',
            'max_price'));
    }

    function remove_dollar_sign_and_get_number($string) {
        // Remove the dollar sign using str_replace
        $cleaned_string = str_replace('$', '', $string);

        // Convert the string to an integer using intval
        $number = intval($cleaned_string);

        return $number;
    }

    public function listing(Request $request)
    {
        return $this->index($request);
    }

    public function listingByCategory(Request $request, $category_slug)
    {
        $category = Category::where('slug', $category_slug)->first();
        if ($category != null) {
            return $this->index($request, $category->id, null);
        }
        abort(404);
    }

    public function listingByBrand(Request $request, $brand_slug)
    {
        $brand = Brand::where('slug', $brand_slug)->first();
        if ($brand != null) {
            return $this->index($request, null, $brand->id);
        }
        abort(404);
    }

    //Suggestional Search
    public function ajax_search(Request $request)
    {
        $keywords = array();
        $query = $request->search;
//        $products = Product::where('published', 1)->where('tags', 'like', '%'.$query.'%')->get();
//        foreach ($products as $key => $product) {
//            foreach (explode(',',$product->tags) as $key => $tag) {
//                if(stripos($tag, $query) !== false){
//                    if(sizeof($keywords) > 5){
//                        break;
//                    }
//                    else{
//                        if(!in_array(strtolower($tag), $keywords)){
//                            array_push($keywords, strtolower($tag));
//                        }
//                    }
//                }
//            }
//        }

        $products = filter_products(Product::query());

        $products = $products->where('published', 1)
                        ->where(function ($q) use ($query){
                            foreach (explode(' ', trim($query)) as $word) {
                                $q->where('name', 'like', '%'.$word.'%');
                            }
                        })
                    ->get();

        $categories = Category::where('name', 'like', '%'.$query.'%')->get()->take(3);

//        $shops = Shop::whereIn('user_id', verified_sellers_id())->where('name', 'like', '%'.$query.'%')->get()->take(3);

        if(sizeof($keywords)>0 || sizeof($categories)>0 || sizeof($products)>0 ){
            return view($this->design .'.partials.search_content', compact('products', 'categories', 'keywords'));
        }
        return '0';
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $search = Search::where('query', $request->keyword)->first();
        if($search != null){
            $search->count = $search->count + 1;
            $search->save();
        }
        else{
            $search = new Search;
            $search->query = $request->keyword;
            $search->save();
        }
    }
}
