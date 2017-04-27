<?php

use Illuminate\Database\Seeder;

class ProductsVouchersTableSeeder extends Seeder
{
    /**
     * Constraints array generator for seed.
     *
     * @return array
     */
    private function productsVouchersConstraintGenerator()
    {
        $constraints = [];
        $productsQty = 3;
        $vouchersQty = 2;
        $productsId = DB::table('products')->take($productsQty)->pluck('id')->toArray();
        $vouchersId = DB::table('vouchers')->take($vouchersQty)->pluck('id')->toArray();

        for ($i = 0; $i < $productsQty; $i++) {
            for ($j = 0; $j < $vouchersQty; $j++) {
                $constraints [] = [
                    'product_id' => $productsId[$i],
                    'voucher_id' => $vouchersId[$j],
                ];
            }
        }

        return $constraints;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products_vouchers')->insert($this->productsVouchersConstraintGenerator());
    }
}
