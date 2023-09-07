<?php

namespace App\Http\Controllers;

use App\Models\QueryRepositories\CartRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CartController extends Controller
{
    protected $cartRepository;

    public function __construct(CartRepository $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    public function updateCartItem($cartItem, $quantity, $price)
    {
        $newQuantity = $cartItem->quantity + $quantity;
        $newPrice = $cartItem->price + $price;
        $this->cartRepository->updateCartItem($cartItem->id, $newQuantity, $newPrice);
    }

    public function updateCartItems(Request $request)
    {
        $products = $request->input('products');

        foreach ($products as $product) {
            if ($product['quantity'] == 0) {
                $this->cartRepository->removeCartItem($product['id']);
            } else {
                $result = $this->cartRepository->updateCartItem($product['id'], $product['quantity'], $product['price']);
            }
        }
        if($result) {
            return response()->json(['message' => 'Shopping cart updated'], Response::HTTP_OK);
        }else{
            return response()->json(['message' => 'OOps, something went wrong'], Response::HTTP_NOT_MODIFIED);
        }
    }
    public function addToCart(Request $request)
    {
        $userId = session('userId');;
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');
        $price = $request->input('price');

        // Check if the product already exists in the cart for the user
        $existingCartItem = $this->cartRepository->getCartItem($productId, $userId);

        if ($existingCartItem) {
            $this->updateCartItem($existingCartItem, $quantity, $price);
        } else {
            $this->cartRepository->addToCart($userId, $productId, $quantity, $price);
        }

        return response()->json(['message' => 'Product added to cart'], Response::HTTP_OK);
    }



    public function getCartItems(Request $request)
    {
        $userId = $request->session()->get('userId');
        if($userId) {
            $cartItems = $this->cartRepository->getCartItemsByUser($userId);

            return response()->json(['cartItems' => $cartItems], Response::HTTP_OK);
        }

        return response()->json(['message' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
    }


    public function removeCartItem($cartId)
    {
        $this->cartRepository->removeCartItem($cartId);

        return response()->json(['message' => 'Cart item removed'], Response::HTTP_OK);
    }
}

