<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ApiController;
use App\Product;
use App\Transaction;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductBuyerTransactionController extends ApiController
{
    public function store(Product $product, User $buyer)
    {

        $rules = [
            'quantity' => 'required|integer|min:1'
        ];

        $this->validate(request(),$rules);

        if( $buyer->id == $product->seller->id ){
            return $this->errorResponse('The buyer must be different from the seller', 409);
        }

        if(!$buyer->isVerified()){
            return $this->errorResponse('The buyer must be a verified user', 409);
        }

        if(!$product->seller->isVerified()){
            return $this->errorResponse('The seller must be a verified user', 409);
        }

        if(!$product->isAvailable()){
            return $this->errorResponse('The product must be available', 409);
        }

        if($product->quantity < request()->quantity ){
            return $this->errorResponse('The product does not have enough units for this transaction', 409);
        }

        return DB::transaction(function() use ($product, $buyer){
            $product->quantity -= request()->quantity;
            $product->save();

            $transaction = Transaction::create([
                'quantity' => request()->quantity,
                'buyer_id' => $buyer->id,
                'product_id' => $product->id
            ]);

            return $this->showOne($transaction, 201);
        });

    }

}
