<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class VouchersTableSeeder extends Seeder
{
    /**
     * Vouchers array generator for seed.
     *
     * @return array
     */
    private function vouchersGenerator()
    {
        $vouchers = [];
        $discountTiers = DB::table('discount_tiers')->pluck('id')->toArray();
        foreach ($discountTiers as $tierId) {
            $vouchers [] = [
                'discount_tier_id' => $tierId,
                'start_date'       => Carbon::today(),
                'end_date'         => Carbon::today()->addMonth(),
                'created_at'       => Carbon::now(),
                'updated_at'       => Carbon::now()
            ];
        }

        return $vouchers;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('vouchers')->insert($this->vouchersGenerator());
    }
}
