<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    /**
     * Fillable properties of the model.
     *
     * @var array
     */
    protected $fillable = [
        'discount_tier_id',
        'start_date',
        'end_date',
        'active'
    ];

    /**
     * Discount tier of voucher.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function discountTier()
    {
        return $this->belongsTo('App\DiscountTier');
    }

    /**
     * Products associated with voucher.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany('App\Product', 'products_vouchers');
    }

    /**
     * Wrapper to get only active vouchers from DB.
     *
     * @param $query
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
