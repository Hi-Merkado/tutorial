<?php

namespace App\Http\Controllers;

use App\Seller;
use App\Http\Controllers\ApiController;

class SellerTransactionController extends ApiController
{

    public function index(Seller $seller)
    {
        $transactions = $seller->products()
                ->whereHas('transactions')
                ->with('transactions')
                ->get()
                ->pluck('transactions')
                ->collapse();

        return $this->showAll($transactions);
    }

}
