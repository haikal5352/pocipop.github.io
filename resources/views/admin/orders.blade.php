<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Orders Management</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .btn-process {
            background-color: #4CAF50;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn-process:disabled {
            background-color: #cccccc;
            cursor: not-allowed;
        }
        .status-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 14px;
        }
        .status-pending {
            background-color: #ffd700;
        }
        .status-processing {
            background-color: #87ceeb;
        }
    </style>
</head>
<body>
    <div x-data="{
        processOrder(orderId) {
            if (!confirm('Are you sure you want to process this order?')) {
                return;
            }

            fetch(`/admin/orders/${orderId}/process`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Order status updated successfully');
                    window.location.reload();
                } else {
                    alert('Error updating order status');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error updating order status');
            });
        }
    }">
        <h1>Orders Management</h1>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Items</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td>#{{ $order->id }}</td>
                    <td>{{ $order->name }}</td>
                    <td>{{ $order->email }}</td>
                    <td>{{ $order->phone }}</td>
                    <td>
                        @foreach($order->items as $item)
                            {{ $item->product_name }} ({{ $item->quantity }}x)<br>
                        @endforeach
                    </td>
                    <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                    <td>
                        <span class="status-badge status-{{ $order->status }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td>
                        <button 
                            class="btn-process" 
                            @click="processOrder({{ $order->id }})"
                            :disabled="'{{ $order->status }}' !== 'pending'"
                        >
                            Process Order
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html> 