<?php

namespace App\Http\Controllers;

use App\Api\Transformers\ProductTransformer;
use App\Product;
use App\Voucher;
use Illuminate\Http\Request;

class ProductController extends ApiController
{
    /**
     * Transformer for the products
     *
     * @var ProductTransformer
     */
    private $transformer;

    /**
     * ProductController constructor.
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $products = Product::available()->with('activeVouchers')->get();

        foreach ($products as $product) {
            $product['price'] = $product->priceCalculator($product);
        }

        return $this->respond($this->transformer->transformCollection($products));
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

        $product['price'] = $product->priceCalculator($product);
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $products = [];

        foreach ($request->data as $data) {
            if (!isset($data['name']) || empty($data['name']) || !isset($data['price']) || empty($data['price'])) {
                return $this->respondBadRequest('Please specify all required fields.');
            }

            $products[] = Product::create($data);
        }

        return $this->respond($products, [], 200);
    }

    /**
     * Attach voucher to a product.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function bindVoucher(Request $request)
    {
        foreach ($request->data as $data) {
            $product = Product::available()->find($data['product_id']);
            $voucher = Voucher::active()->find($data['voucher_id']);

            if (empty($product)) {
                return $this->respondNotFound('There is no such product');
            }
            if (empty($voucher)) {
                return $this->respondNotFound('There is no such voucher');
            }
            if (empty($product->vouchers()->find($data['voucher_id']))) {
                $product->vouchers()->attach($data['voucher_id']);
            }
        }

        return $this->respond('Vouchers have been successfully attached to a Product.', [], 200);
    }

    /**
     * Detach voucher from a product.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function unbindVoucher(Request $request)
    {
        foreach ($request->data as $data) {
            $product = Product::available()->find($data['product_id']);
            $voucher = Voucher::find($data['voucher_id']);

            if (empty($product)) {
                return $this->respondNotFound('There is no such product');
            }
            if (empty($voucher)) {
                return $this->respondNotFound('There is no such voucher');
            }

            if (!empty($product->vouchers()->find($data['voucher_id']))) {
                $product->vouchers()->detach($data['voucher_id']);
            }
        }

        return $this->respond('Vouchers has been successfully detached from a Product.', [], 200);
    }
}
