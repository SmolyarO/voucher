<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Predefined product names.
     *
     * @var array
     */
    private $productNames = [
        'Small product',
        'Medium product',
        'Large product',
        '4-th product',
        '5-th product',
        '6-th product',
        'Good product',
        'Better product',
        'The best product'
    ];

    /**
     * Products array generator for seed.
     *
     * @return array
     */
    private function productsGenerator()
    {
        $products = [];
        foreach ($this->productNames as $name) {
            $products [] = [
                'name'       => $name,
                'price'      => $this->randomFloat(0, 300),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
        }

        return $products;
    }

    /**
     * Random float generator for product price.
     *
     * @param int $min
     * @param int $max
     * @return int
     */
    private function randomFloat($min = 0, $max = 1)
    {
        return $min + mt_rand() / mt_getrandmax() * ($max - $min);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert($this->productsGenerator());
    }
}
