@extends('layouts.app')

@section('title', 'Dashboard')
@section('heading', 'Dashboard')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg p-4 shadow"><p class="text-sm text-slate-500">Products</p><p class="text-2xl font-bold">{{ $stats['products'] }}</p></div>
        <div class="bg-white rounded-lg p-4 shadow"><p class="text-sm text-slate-500">Customers</p><p class="text-2xl font-bold">{{ $stats['customers'] }}</p></div>
        <div class="bg-white rounded-lg p-4 shadow"><p class="text-sm text-slate-500">Suppliers</p><p class="text-2xl font-bold">{{ $stats['suppliers'] }}</p></div>
        <div class="bg-white rounded-lg p-4 shadow"><p class="text-sm text-slate-500">Completed Sales</p><p class="text-2xl font-bold">${{ number_format($stats['sales'], 2) }}</p></div>
    </div>

    <div class="bg-white p-4 rounded-lg shadow mb-6">
        <h2 class="font-semibold mb-3">Monthly Sales</h2>
        <canvas id="salesChart"></canvas>
    </div>

    <div class="bg-white p-4 rounded-lg shadow">
        <h2 class="font-semibold mb-3">Recent Orders</h2>
        <table class="w-full text-sm">
            <thead><tr class="text-left border-b"><th class="py-2">Order</th><th>Customer</th><th>Total</th><th>Status</th></tr></thead>
            <tbody>
            @foreach($recentOrders as $order)
                <tr class="border-b"><td class="py-2">{{ $order->order_number }}</td><td>{{ $order->customer->name }}</td><td>${{ number_format($order->total_amount, 2) }}</td><td>{{ $order->status }}</td></tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

@push('scripts')
<script>
    new Chart(document.getElementById('salesChart'), {
        type: 'line',
        data: {
            labels: @json($monthlySales->pluck('month')),
            datasets: [{ label: 'Gross Sales', data: @json($monthlySales->pluck('gross_sales')), borderColor: '#0f172a' }]
        }
    });
</script>
@endpush
