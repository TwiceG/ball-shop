<?php

namespace App\Models\QueryRepositories;

use App\Models\Product;

class ProductRepository
{
    public function createProduct($name, $description, $price, $image)
    {
        return Product::create([
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'image' => $image,
        ]);
    }

    public function getProductById($id)
    {
        return Product::find($id);
    }

    public function getAllProducts()
    {
        return Product::all();
    }

    public function updateProduct($id, $name, $description, $price, $image)
    {
        $product = Product::find($id);

        if ($product) {
            if ($name !== null) {
                $product->name = $name;
            }

            if ($description !== null) {
                $product->description = $description;
            }

            if ($price !== null) {
                $product->price = $price;
            }

            if ($image !== null) {
                $product->image = $image;
            }

            $product->save();
            return $product;
        }

        return null;
    }

    public function deleteProduct($id)
    {
        $product = Product::find($id);

        if ($product) {
            $product->delete();
            return true;
        }

        return false;
    }
}
