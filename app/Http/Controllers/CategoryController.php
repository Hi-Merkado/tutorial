<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Controllers\ApiController;

class CategoryController extends ApiController
{

    public function index()
    {
        $categories = Category::all();
        return $this->showAll($categories);
    }


    public function store()
    {
        $rules = [
            'name' => 'required',
            'description' => 'required'
        ];

        $this->validate(request(), $rules);

        $category = Category::create(request()->all());
        return $this->showOne($category, 201);
    }

    public function show(Category $category)
    {
        return $this->showOne($category);
    }

    public function update(Category $category)
    {
        $category->fill(
            request()->only([
                'name','description'
            ])
        );
        if( $category->isClean() ){
            return $this->errorResponse('You need to specify a different value to update', 422);
        }
        $category->save();
        return $this->showOne($category);
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return $this->showOne($category);
    }
}
