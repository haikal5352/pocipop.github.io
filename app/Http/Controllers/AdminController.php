<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function orders()
    {
        $orders = Order::with('items')->orderBy('created_at', 'desc')->get();
        return view('admin.orders', compact('orders'));
    }

    public function processOrder($id)
    {
        $order = Order::findOrFail($id);
        $order->status = 'processing';
        $order->save();

        return response()->json([
            'success' => true,
            'message' => 'Order status updated to processing'
        ]);
    }
} 