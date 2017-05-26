<?php

namespace App\Api\Transformers;

class ProductTransformer extends Transformer
{

    /**
     * Transform method for one item
     *
     * @param $item
     * @return mixed
     */
    public function transform($item)
    {
        return [
            "id"        => $item->id,
            "name"      => $item->name,
            "price"     => $item->price,
            "available" => $item->available
        ];
    }
}