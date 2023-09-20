<?php

namespace App\Models\QueryRepositories;

use App\Models\Cart;

class CartRepository
{
    public function addToCart($userId, $productId, $quantity, $price)
    {
        return Cart::create([
            'user_id' => $userId,
            'product_id' => $productId,
            'price' => $price,
            'quantity' => $quantity,
        ]);
    }

    public function getCartItemsByUser($userId)
    {
        return Cart::where('user_id', $userId)
            ->join('products', 'carts.product_id', '=', 'products.id')
            ->select('carts.id', 'products.name', 'products.price', 'carts.quantity')
            ->get();
    }

    public function getCartItem($productId, $userId)
    {
        return Cart::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();
    }

    public function updateCartItem($cartId, $quantity, $price)
    {
        $cart = Cart::find($cartId);

        if ($cart) {
            $cart->quantity = $quantity;
            $cart->price = $price;
            $cart->save();
            return $cart;
        }

        return null;
    }

    public function removeCartItem($cartId)
    {
        $cart = Cart::find($cartId);

        if ($cart) {
            $cart->delete();
            return true;
        }

        return false;
    }
}
