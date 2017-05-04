<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiscountTier extends Model
{
    /**
     * Fillable properties of the model.
     *
     * @var array
     */
    protected $fillable = ['amount'];

    /**
     * Vouchers with according discount tier.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function vouchers()
    {
        return $this->hasMany('App\Voucher');
    }
}
