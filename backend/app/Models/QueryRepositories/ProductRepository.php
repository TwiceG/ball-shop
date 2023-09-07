<?php

namespace App\Models\QueryRepositories;

use Illuminate\Support\Facades\DB;


class ProductRepository
{
    public function createProduct($name, $description, $price, $image)
    {
        return DB::table('products')->insert([
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'image' => $image,
        ]);
    }

    public function getProductById($id)
    {
        return DB::table('products')->find($id);
    }

    public function getAllProducts()
    {
        return DB::table('products')->get();
    }

    public function updateProduct($id, $name, $description, $price, $image)
    {
        $dataToUpdate = [];

        if ($name !== null) {
            $dataToUpdate['name'] = $name;
        }

        if ($description !== null) {
            $dataToUpdate['description'] = $description;
        }

        if ($price !== null) {
            $dataToUpdate['price'] = $price;
        }

        if ($image !== null) {
            $dataToUpdate['image'] = $image;
        }

        return DB::table('products')
            ->where('id', $id)
            ->update($dataToUpdate);
    }


    public function deleteProduct($id)
    {
        return DB::table('products')->where('id', $id)->delete();
    }

}
