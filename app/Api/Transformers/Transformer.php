<?php

namespace App\Api\Transformers;

abstract class Transformer
{
    /**
     * Transformer for a collection
     *
     * @param $items
     * @return array
     */
    public function transformCollection($items)
    {
        $data = [];
        foreach ($items as $item) {
            $data[] = $this->transform($item);
        }

        return $data;
    }

    /**
     * Transform method for one item
     *
     * @param $item
     * @return mixed
     */
    abstract public function transform($item);

}
