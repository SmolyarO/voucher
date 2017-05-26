<?php

namespace App\Http\Controllers;

use App\Api\Transformers\ProductTransformer;
use App\Product;
use App\Voucher;

class ProductPageController extends Controller
{
    /**
     * Transformer for the products
     *
     * @var ProductTransformer
     */
    private $transformer;

    /**
     * ProductPageController constructor.
     *
     * @param ProductTransformer $transformer
     */
    public function __construct(ProductTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    /**
     * Display a listing of Products.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $products = Product::available()->with('activeVouchers')->get();
        foreach ($products as $product) {
            $product['price'] = $product->priceCalculator($product);
        }
        $products = $this->transformer->transformCollection($products);

        return view('products.index', compact('products'));
    }

    /**
     * Buy a product.
     *
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function buy(Product $product)
    {
        $product['price'] = $product->priceCalculator($product);
        $voucherIds = [];

        foreach ($product['activeVouchers'] as $voucher) {
            $voucherIds[] = $voucher->id;
        }

        Voucher::wherein('id', $voucherIds)->update(['active' => 0]);
        $product->available = 0;
        $product->save();

        return redirect(route('getAllProducts'));
    }
}
