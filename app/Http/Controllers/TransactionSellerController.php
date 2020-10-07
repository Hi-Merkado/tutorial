<?php

namespace App\Http\Controllers;

use App\Transaction;
use App\Http\Controllers\ApiController;

class TransactionSellerController extends ApiController
{

    public function index(Transaction $transaction)
    {
        $seller = $transaction->product->seller;
        return $this->showOne($seller);
    }
}
