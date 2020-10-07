<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Buyers
Route::resource('buyers', 'BuyerController', ['only' => ['index', 'show']]);
Route::resource('buyers.transactions', 'BuyerTransactionController', ['only' => ['index']]);
Route::resource('buyers.products', 'BuyerProductController', ['only' => ['index']]);
Route::resource('buyers.sellers', 'BuyerSellerController', ['only' => ['index']]);
Route::resource('buyers.categories', 'BuyerCategoryController', ['only' => ['index']]);

// Sellers
Route::resource('sellers', 'SellerController', ['only' => ['index', 'show']]);
Route::resource('sellers.buyers', 'SellerCategoryController', ['only' => ['index']]);
Route::resource('sellers.categories', 'SellerCategoryController', ['only' => ['index']]);
Route::resource('sellers.products', 'SellerProductController', ['except' => ['create', 'show', 'edit']]);
Route::resource('sellers.transactions', 'SellerTransactionController', ['only' => ['index']]);


// Categories
Route::resource('categories', 'CategoryController', ['except' => ['create', 'edit']]);
Route::resource('categories.products', 'CategoryProductController', ['only' => ['index']]);
Route::resource('categories.sellers', 'CategorySellerController', ['only' => ['index']]);
Route::resource('categories.transactions', 'CategoryTransactionController', ['only' => ['index']]);
Route::resource('categories.buyers', 'CategoryBuyerController', ['only' => ['index']]);

// Products
Route::resource('products', 'ProductController', ['only' => ['index', 'show']]);
Route::resource('products.buyers', 'ProductBuyerController', ['only' => ['index']]);
Route::resource('products.categories', 'ProductCategoryController', ['except' => ['create', 'show', 'edit']]);
Route::resource('products.transactions', 'ProductTransactionController', ['only' => ['index']]);
Route::resource('products.buyers.transactions', 'ProductBuyerTransactionController', ['only' => ['store']]);

// Transactions
Route::resource('transactions', 'TransactionController', ['only' => ['index', 'show']]);
Route::resource('transactions.categories', 'TransactionCategoryController', ['only' => ['index']]);
Route::resource('transactions.sellers', 'TransactionSellerController', ['only' => ['index']]);

// Users
Route::resource('users', 'UserController', ['except' => ['create', 'edit']]);
Route::name('verify')->get('users/verify/{token}', 'UserController@verify');
Route::name('resend')->get('users/{user}/resend', 'UserController@resend');