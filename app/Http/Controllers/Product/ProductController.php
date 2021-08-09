<?php

namespace App\Http\Controllers\Product;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\product\ProductCreateRequest;
use App\Http\Resources\ProductResource;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function index(){
        return response()->json([
            'products' => ProductResource::collection(Product::paginate())
        ], Response::HTTP_OK);
    }

    public function show($id){
        $product = Product::findOrFail($id);

        return response()->json([
            'product' => new ProductResource($product)
        ], Response::HTTP_OK);
    }

    public function store(ProductCreateRequest $request){
        $product = Product::create($request->only('title', 'description', 'image', 'price'));

        return response()->json([
            'message' => 'Product has been created successfully',
            'product' => new ProductResource($product) 
        ], Response::HTTP_CREATED);
    }

    public function update(Request $request, $id){
        $product = Product::findOrFail($id);
        $product->update($request->all());

        return response()->json([
            'message' => 'Product has been updated successfully',
            'product' => new ProductResource($product)
        ], Response::HTTP_ACCEPTED);
    }

    public function destroy($id){
        Product::destroy($id);

        return response()->json([
            'message' => 'Product has been deleted successfully'
        ], Response::HTTP_OK);
    }
}
