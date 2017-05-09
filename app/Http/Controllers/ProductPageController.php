<?php

namespace App\Http\Controllers;

use App\Product;
use App\Voucher;
use Carbon\Carbon;

class ProductPageController extends Controller
{
    /**
     * Display a listing of Products.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $products = Product::available()->with('activeVouchers')->get();
        foreach ($products as $product) {
            $product['price'] = $this->priceCalculator($product);
            unset($product['activeVouchers']);
        }

        return view('products.index', compact('products'));
    }

    /**
     * Buy a product.
     *
     * @param Product $product
     * @return Product
     */
    public function buy(Product $product)
    {
        $product['price'] = $this->priceCalculator($product);
        $voucherIds = [];

        foreach ($product['activeVouchers'] as $voucher) {
            $voucherIds[] = $voucher->id;
        }

        Voucher::wherein('id', $voucherIds)->update(['active' => 0]);
        $product->available = 0;
        $product->save();

        return redirect(route('getAllProducts'));
    }

    /**
     * Calculates price for product according to bind vouchers.
     *
     * @param $product
     * @return float
     */
    private function priceCalculator($product)
    {
        $discount = 0;
        $price = $product['price'];

        foreach ($product['activeVouchers'] as $voucher) {
            if ($voucher['start_date'] <= Carbon::now() && $voucher['end_date'] >= Carbon::now()) {
                $discount += $voucher->discountTier()->value('amount');
            }
        }

        $discount = $discount <= 0.6 ? $discount : 0.6;

        return round($price - $price * $discount, 2);
    }
}
