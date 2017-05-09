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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $vouchers = [];
        foreach ($request->data as $data) {
            if (!isset($data['discount_tier_id']) || empty($data['discount_tier_id'])) {
                return $this->respondBadRequest('Please specify all required fields.');
            }
            $vouchers[] = Voucher::create($data);
        }

        return $this->respond($vouchers, [], 200);
    }
}
