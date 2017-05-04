<?php

namespace App;

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
}
