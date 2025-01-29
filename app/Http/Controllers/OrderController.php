<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        // Log request untuk debugging
        Log::info('Order request received:', $request->all());

        try {
            DB::beginTransaction();
            
            // Create order
            $order = Order::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'total_amount' => $request->total,
                'status' => 'pending'
            ]);

            Log::info('Order created:', $order->toArray());

            // Create order items
            foreach ($request->items as $item) {
                $orderItem = OrderItem::create([
                    'order_id' => $order->id,
                    'product_name' => $item['name'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['subtotal']
                ]);
                Log::info('Order item created:', $orderItem->toArray());
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Order berhasil dibuat',
                'order' => $order->id
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Order error:', ['message' => $e->getMessage()]);
            return response()->json([
                'success' => false, 
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function process(Order $order)
    {
        try {
            $order->update(['status' => 'processing']);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
} 