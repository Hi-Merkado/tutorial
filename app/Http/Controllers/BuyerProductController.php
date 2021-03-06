<?php

namespace App\Http\Controllers;

use App\Buyer;
use App\Http\Controllers\ApiController;

class BuyerProductController extends ApiController
{
    public function index(Buyer $buyer)
    {
        $products = $buyer->transactions()->with('product')
                    ->get()
                    ->pluck('product');
        return $this->showAll($products);
    }
}
