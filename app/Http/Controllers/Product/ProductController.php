<?php

namespace App\Http\Controllers\Product;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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

    public function store(Request $request){

    }

    public function update(Request $request, $id){

    }

    public function destroy($id){
        Product::destroy($id);

        return response()->json([
            'message' => 'Product has been deleted successfully'
        ], Response::HTTP_OK);
    }
}
