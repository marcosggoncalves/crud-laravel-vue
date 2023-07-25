<?php

namespace App\Repositories;

use App\Interfaces\ProductInterface;
use App\Models\Product;

class ProductRepository implements ProductInterface
{
    public function index()
    {
        return Product::orderBy('name')->paginate(15);
    }

    public function store(array $body)
    {
        return Product::create($body);
    }

    public function update(int $id, array $body)
    {
        $product = Product::findOrFail($id);

        $product->name = $body['name'];

        $product->category_id = $body['category_id'];

        return $product->save();
    }

    public function destroy(int $id)
    {
        return Product::destroy($id);
    }
}
