<?php

namespace App\Http\Controllers;

use App\Product;
use App\Http\Controllers\ApiController;

class ProductController extends ApiController
{

    public function index()
    {
        $products = Product::all();
        return $this->showAll($products);
    }

    public function show(Product $product)
    {
        return $this->showOne($product);
    }

}
