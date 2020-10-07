<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Controllers\ApiController;

class CategoryTransactionController extends ApiController
{

    public function index(Category $category)
    {
        $transactions = $category->products()
                    ->whereHas('transactions')
                    ->with('transactions')
                    ->get()
                    ->pluck('transactions')
                    ->collapse();

        return $this->showAll($transactions);
    }

}
