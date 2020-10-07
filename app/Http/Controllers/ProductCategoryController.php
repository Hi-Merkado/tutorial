<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class ProductCategoryController extends ApiController
{

    public function index(Product $product)
    {
        $categories = $product->categories;
        return $this->showAll($categories);
    }

    public function update(Product $product, Category $category){
        $product->categories()->syncWithoutDetaching([$category->id]);
        return $this->showAll($product->categories);
    }

    public function destroy(Product $product,Category $category){
        if(!$product->categories()->find($category->id)){
            return $this->errorResponse('The specified category is not a category of this product',404);
        } else {
            $product->categories()->detach($category->id);    
        }
        return $this->showAll($product->categories);
    }

}
