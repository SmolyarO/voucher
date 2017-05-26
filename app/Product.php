<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * Fillable properties of the model.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'price',
        'available'
    ];

    /**
     * Vouchers associated with product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function vouchers()
    {
        return $this->belongsToMany('App\Voucher', 'products_vouchers');
    }

    /**
     * Wrapper to get only available products from DB.
     *
     * @param $query
     * @return mixed
     */
    public function scopeAvailable($query)
    {
        return $query->where('available', 1);
    }

    /**
     * Wrapper to get only active vouchers.
     *
     * @return mixed
     */
    public function activeVouchers()
    {
        return $this->vouchers()->active();
    }

    /**
     * Calculates price for product according to bind vouchers.
     *
     * @param $product
     * @return float
     */
    public function priceCalculator(Product $product)
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
