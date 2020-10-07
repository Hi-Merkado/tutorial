<?php

namespace App\Http\Controllers;

use App\Transaction;
use App\Http\Controllers\ApiController;

class TransactionCategoryController extends ApiController
{

    public function index(Transaction $transaction)
    {
        $categories = $transaction->product->categories;
        return $this->showAll($categories);
    }

}
