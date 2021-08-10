<?php

namespace App\Http\Controllers\Order;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;

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

    public function export(){
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=orders.csv",
            "Pragma" => "no-cache",
            "Cache-control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function(){
            $orders = Order::all();
            $file = fopen('php://output', 'w');

            // Header row
            fputcsv($file, ['ID', 'Name', 'Email', 'Product Title', 'Price', 'Quantity']);

            // Body
            foreach($orders as $order){
                fputcsv($file, [$order->id, $order->name, $order->email, '', '', '']);

                foreach($order->items as $item){
                    fputcsv($file, ['', '', '' , $item->product_title, $item->price, $item->quantity]);
                }
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
