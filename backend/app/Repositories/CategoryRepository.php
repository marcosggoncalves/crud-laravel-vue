<?php

namespace App\Repositories;

use App\Interfaces\CategoryInterface;
use App\Models\Category;

class CategoryRepository implements CategoryInterface
{
    public function index()
    {
        return Category::all();
    }

    public function store(array $body)
    {
        return Category::create($body);
    }

    public function update(int $id, array $body)
    {
        $category = Category::findOrFail($id);

        $category->name = $body['name'];

        return $category->save();
    }

    public function destroy(int $id)
    {
        $category = Category::findOrFail($id);

        return $category->delete();
    }
}
