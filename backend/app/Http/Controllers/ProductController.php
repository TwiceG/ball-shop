<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QueryRepositories\ProductRepository;
use Symfony\Component\HttpFoundation\Response;


class ProductController extends Controller
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'image' => 'nullable|string',
        ]);

        $name = $request->input('name');
        $description = $request->input('description');
        $price = $request->input('price');
        $image = $request->input('image');

        $this->productRepository->createProduct($name, $description, $price, $image);

        return response()->json(['message' => 'Product created successfully'], Response::HTTP_CREATED);
    }

    public function show($id)
    {
        $product = $this->productRepository->getProductById($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($product, Response::HTTP_OK);
    }

    public function index()
    {
        $products = $this->productRepository->getAllProducts();
        return response()->json($products, Response::HTTP_OK);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'nullable|string',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric',
            'image' => 'nullable|string',
        ]);

        $name = $request->input('name');
        $description = $request->input('description');
        $price = $request->input('price');
        $image = $request->input('image');

        $product = $this->productRepository->updateProduct($id, $name, $description, $price, $image);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json(['message' => 'Product updated successfully'], Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $product = $this->productRepository->deleteProduct($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json(['message' => 'Product deleted successfully'], Response::HTTP_OK);
    }
}
