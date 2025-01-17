@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-bold mb-6">Database Operations</h2>
        
        <div class="grid grid-cols-2 gap-4 mb-8">
            <!-- Common Queries -->
            <div class="p-4 border rounded">
                <h3 class="font-bold mb-4">Product Analytics</h3>
                <form action="{{ route('admin.database.query') }}" method="POST" class="space-y-2">
                    @csrf
                    <button type="submit" name="query" value="SELECT products.name, COUNT(order_items.id) as times_ordered 
                        FROM products 
                        LEFT JOIN order_items ON products.id = order_items.product_id 
                        GROUP BY products.id 
                        ORDER BY times_ordered DESC 
                        LIMIT 10" 
                        class="w-full text-left px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded">
                        Top 10 Selling Products
                    </button>

                    <button type="submit" name="query" value="SELECT categories.name, COUNT(products.id) as product_count 
                        FROM categories 
                        LEFT JOIN products ON categories.id = products.category_id 
                        GROUP BY categories.id" 
                        class="w-full text-left px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded">
                        Products per Category
                    </button>
                </form>
            </div>

            <div class="p-4 border rounded">
                <h3 class="font-bold mb-4">Order Analytics</h3>
                <form action="{{ route('admin.database.query') }}" method="POST" class="space-y-2">
                    @csrf
                    <button type="submit" name="query" value="SELECT DATE(created_at) as date, COUNT(*) as order_count, 
                        SUM(total_amount) as daily_revenue 
                        FROM orders 
                        GROUP BY DATE(created_at) 
                        ORDER BY date DESC 
                        LIMIT 7" 
                        class="w-full text-left px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded">
                        Last 7 Days Sales
                    </button>

                    <button type="submit" name="query" value="SELECT users.name, COUNT(orders.id) as order_count 
                        FROM users 
                        JOIN orders ON users.id = orders.user_id 
                        GROUP BY users.id 
                        ORDER BY order_count DESC 
                        LIMIT 5" 
                        class="w-full text-left px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded">
                        Top 5 Customers
                    </button>
                </form>
            </div>
        </div>

        <!-- Results Display -->
        @if(session('results'))
            <div class="overflow-x-auto mt-8">
                <table class="min-w-full bg-white border">
                    <thead>
                        <tr>
                            @foreach((array)session('results')[0] as $key => $value)
                                <th class="px-6 py-3 border-b bg-gray-50">{{ $key }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(session('results') as $row)
                            <tr>
                                @foreach((array)$row as $value)
                                    <td class="px-6 py-4 border-b">{{ $value }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
