<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of Products.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $products = Product::available()->get();

        return view('products.index', compact('products'));
    }

    /**
     * Buy a product.
     *
     * @param Product $product
     * @return Product
     */
    public function buyProduct(Product $product)
    {
        return $product;
    }
}
