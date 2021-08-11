<?php

namespace App\Http\Controllers\Product;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\ProductResource;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\product\ProductCreateRequest;

class ProductController extends Controller
{
    public function index(){
        Gate::authorize('view', 'products');

        return response()->json([
            'products' => ProductResource::collection(Product::paginate())
        ], Response::HTTP_OK);
    }

    public function show($id){
        Gate::authorize('view', 'products');

        $product = Product::findOrFail($id);

        return response()->json([
            'product' => new ProductResource($product)
        ], Response::HTTP_OK);
    }

    public function store(ProductCreateRequest $request){
        Gate::authorize('edit', 'products');

        $product = Product::create($request->only('title', 'description', 'image', 'price'));

        return response()->json([
            'message' => 'Product has been created successfully',
            'product' => new ProductResource($product) 
        ], Response::HTTP_CREATED);
    }

    public function update(Request $request, $id){
        Gate::authorize('edit', 'products');

        $product = Product::findOrFail($id);
        $product->update($request->all());

        return response()->json([
            'message' => 'Product has been updated successfully',
            'product' => new ProductResource($product)
        ], Response::HTTP_ACCEPTED);
    }

    public function destroy($id){
        Gate::authorize('edit', 'products');
        
        Product::destroy($id);

        return response()->json([
            'message' => 'Product has been deleted successfully'
        ], Response::HTTP_OK);
    }
}
