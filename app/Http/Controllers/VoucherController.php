<?php

namespace App\Http\Controllers;

use App\Voucher;
use Illuminate\Http\Request;

class VoucherController extends ApiController
{
    /**
     * Create a voucher and bind it to discount tier.
     *
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->data[0];
        if (!isset($data['discount_tier_id']) || empty($data['discount_tier_id'])) {
            return $this->respondBadRequest('Please specify all required fields.');
        }

        return Voucher::create($data);
    }
}
