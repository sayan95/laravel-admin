<?php

namespace App\Http\Controllers\Order;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    public function index(){
        $orders = Order::with('items')->paginate();

        return response()->json([
            'orders' => OrderResource::collection($orders)
        ], Response::HTTP_OK);
    }

    public function show($id){
        $order = Order::with('items')->findOrFail($id);

        return response()->json([
            'order' => new OrderResource($order)
        ], Response::HTTP_OK);
    }
}
