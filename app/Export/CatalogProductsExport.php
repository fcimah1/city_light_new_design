<?php
namespace App\Export;

use App\Models\Product;
use App\Models\Currency;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CatalogProductsExport implements FromCollection, WithMapping, WithHeadings
{
    public $cu;

    public function __construct()
    {
        $this->cu = Currency::findOrFail(get_setting('system_default_currency'))->code;
    }

    public function collection()
    {
        return Product::with('stocks', 'brand')->where('published' , 1)->get();
    }

    public function headings(): array
    {
        return [
            'id', //Required
            'title', //Required
            'description', //Required
            'availability', //Required
            'condition', //Required -> new
            'price', //Required
            'link', //Required
            'image_link', //Required
            'brand', //Required
            'google_product_category',
            'fb_product_category',
            'quantity_to_sell_on_facebook',
            'sale_price',
            'sale_price_effective_date',
            'item_group_id',
            'gender',
            'color',
            'size',
            'age_group',
            'material',
            'pattern',
            'shipping',
            'shipping_weight',
            'video[0].url',
            'video[0].tag[0]',
            'gtin',
            'style[0]',
        ];
    }

    /**
     * @param Product $product
     * @return array
     */
    public function map($product): array
    {
        $rows = [];
       foreach ($product->stocks as $stock) {

           $discount =  (home_base_price($product) != home_discounted_base_price($product))?home_discounted_base_price($product,true,false):'';
           $rows[] = [
                $stock->id,
                $product->name,
                $product->meta_description,
                ($stock->qty > 0) ? 'in stock' : 'out of stock',
                'new',
                $product->unit_price . ' ' . $this->cu,
                route('product', $product->slug),
                uploaded_asset($product->meta_img),
                optional($product->brand)->name,
                '',
                'Clothing & Accessories > Clothing',
                '',
                $discount . ' ' . $this->cu,
                '',
                '',
                'female',
                $stock->variant, // Assuming variant is the stock-specific detail like size or color
                '',
                'all ages',
                'leather',
                '',
                'shipping',
                'shipping_weight',
                $product->video_link,
                '',
                '',
                '',
            ];
        }

        return $rows;
    }
}
