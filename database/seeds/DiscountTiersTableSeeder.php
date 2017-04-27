<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DiscountTiersTableSeeder extends Seeder
{
    /**
     * Voucher discount amounts.
     *
     * @var array
     */
    private $voucherAmounts = [
        0.1,
        0.15,
        0.2,
        0.25
    ];

    /**
     * Discount tiers array generator for seed.
     *
     * @return array
     */
    private function discountTiersGenerator()
    {
        $amounts = [];
        foreach ($this->voucherAmounts as $amount) {
            $amounts [] = [
                'amount'     => $amount,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
        }

        return $amounts;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('discount_tiers')->insert($this->discountTiersGenerator());
    }
}
