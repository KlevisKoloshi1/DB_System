@extends('layouts.app')
@section('title', 'Reports')
@section('heading', 'Reports & Analytics')
@section('content')
<div class="grid md:grid-cols-2 gap-4">
    <div class="bg-white rounded shadow p-4">
        <h3 class="font-semibold mb-2">Top Customers</h3>
        <table class="w-full text-sm"><thead><tr><th class="text-left">Customer</th><th>Orders</th><th>Spent</th></tr></thead><tbody>
            @foreach($topCustomers as $row)<tr class="border-t"><td class="py-2">{{ $row->name }}</td><td>{{ $row->total_orders }}</td><td>${{ number_format($row->total_spent, 2) }}</td></tr>@endforeach
        </tbody></table>
    </div>
    <div class="bg-white rounded shadow p-4">
        <h3 class="font-semibold mb-2">Best Selling Products</h3>
        <table class="w-full text-sm"><thead><tr><th class="text-left">Product</th><th>Units</th><th>Revenue</th></tr></thead><tbody>
            @foreach($bestProducts as $row)<tr class="border-t"><td class="py-2">{{ $row->name }}</td><td>{{ $row->units_sold }}</td><td>${{ number_format($row->revenue, 2) }}</td></tr>@endforeach
        </tbody></table>
    </div>
</div>
<div class="grid md:grid-cols-2 gap-4 mt-4">
    <div class="bg-white rounded shadow p-4">
        <h3 class="font-semibold mb-2">Low Stock</h3>
        <ul class="text-sm space-y-2">
            @foreach($lowStock as $product)
                <li class="border-b pb-2">{{ $product->name }} (Stock: {{ $product->current_stock }} / Reorder: {{ $product->reorder_level }})</li>
            @endforeach
        </ul>
    </div>
    <div class="bg-white rounded shadow p-4">
        <h3 class="font-semibold mb-2">Monthly Sales Trend</h3>
        <canvas id="monthlyChart"></canvas>
    </div>
</div>
@endsection

@push('scripts')
<script>
    new Chart(document.getElementById('monthlyChart'), {
        type: 'bar',
        data: {
            labels: @json($monthlySales->pluck('month_start')),
            datasets: [{ label: 'Gross Sales', data: @json($monthlySales->pluck('gross_sales')), backgroundColor: '#1d4ed8' }]
        }
    });
</script>
@endpush
