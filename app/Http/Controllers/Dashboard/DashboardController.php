<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function insight(){
        $orders = Order::query()
                ->join('order_items', 'orders.id', '=', 'order_items.order_id')
                ->selectRaw('DATE_FORMAT(orders.created_at, "%Y-%m-%d") as date, sum(order_items.quantity * order_items.price) as gross')
                ->groupBy('date')
                ->get();

        return $orders;
    }
}