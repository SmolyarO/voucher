<?php

namespace App\Http\Controllers;

use App\Product;
use App\Voucher;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProductController extends ApiController
{
    /**
     * Display a listing of Products.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $products = Product::available()->with('activeVouchers')->get();

        foreach ($products as $product) {
            $product['price'] = $this->priceCalculator($product);
            unset($product['activeVouchers']);
        }

        return $this->respond($products);
    }

    /**
     * Buy a product.
     *
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function buy(Product $product)
    {
        if ($product->available === 0) {
            return $this->respondNotFound('Product is not available.');
        }

        $product['price'] = $this->priceCalculator($product);
        $voucherIds = [];

        foreach ($product['activeVouchers'] as $voucher) {
            $voucherIds[] = $voucher->id;
        }

        Voucher::wherein('id', $voucherIds)->update(['active' => 0]);
        $product->available = 0;
        $product->save();

        return $this->respond('Product has been bought successfully.', [], 200);
    }

    /**
     * Create a product.
     *
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->data[0];
        if (!isset($data['name']) || empty($data['name']) || !isset($data['price']) || empty($data['price'])) {
            return $this->respondBadRequest('Please specify all required fields.');
        }

        return Product::create($request->data[0]);
    }

    public function bindVoucher(Request $request)
    {
        $data = $request->data[0];
        $product = Product::find($data['product_id']);
        $product->vouchers()->attach($data['voucher_id']);

        return $this->respond('Voucher has been successfully attached to a Product.', [], 200);
    }

    public function unbindVoucher(Request $request)
    {
        $data = $request->data[0];
        $product = Product::find($data['product_id']);
        $product->vouchers()->detach($data['voucher_id']);

        return $this->respond('Voucher has been successfully detached from a Product.', [], 200);
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
