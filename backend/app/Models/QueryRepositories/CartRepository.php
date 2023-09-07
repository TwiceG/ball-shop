<?php

namespace App\Models\QueryRepositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CartRepository
{
    public function addToCart($userId, $productId, $quantity, $price)
    {
        return DB::table('carts')->insert([
            'user_id' => $userId,
            'product_id' => $productId,
            'price' => $price,
            'quantity' => $quantity,
        ]);
    }

    public function getCartItemsByUser($userId)
    {
        return DB::table('carts')
            ->join('products', 'carts.product_id', '=', 'products.id')
            ->where('carts.user_id', $userId)
            ->select('carts.id', 'products.name', 'products.price', 'carts.quantity')
            ->get();
    }
    public function getCartItem($productId, $userId)
    {
        return DB::table('carts')
            ->where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();
    }


    public function updateCartItem($cartId, $quantity, $price)
    {
        return DB::table('carts')
            ->where('id', $cartId)
            ->update([
                'quantity' => $quantity,
                'price' => $price,
            ]);
    }

    public function removeCartItem($cartId)
    {
        return DB::table('carts')->where('id', $cartId)->delete();
    }

}
