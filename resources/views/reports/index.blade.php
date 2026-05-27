@extends('layouts.app')
@section('title', 'Reports')
@section('heading', 'Reports & Analytics')

@section('content')

<div class="grid md:grid-cols-2 gap-4 mb-4">

    {{-- Top Customers --}}
    <div class="panel p-5">
        <h3 class="text-sm font-semibold text-slate-800 mb-4 flex items-center gap-2">
            <svg class="w-4 h-4 text-[#047481]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
            Top Customers
        </h3>
        <table class="data-table">
            <thead><tr><th>Customer</th><th>Orders</th><th>Spent</th></tr></thead>
            <tbody>
            @forelse($topCustomers as $row)
                <tr>
                    <td class="font-medium text-slate-900">{{ $row->name }}</td>
                    <td>{{ $row->total_orders }}</td>
                    <td class="font-medium">${{ number_format($row->total_spent, 2) }}</td>
                </tr>
            @empty
                <tr><td colspan="3" class="text-center py-6 text-slate-400">No data</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{-- Best Selling Products --}}
    <div class="panel p-5">
        <h3 class="text-sm font-semibold text-slate-800 mb-4 flex items-center gap-2">
            <svg class="w-4 h-4 text-[#047481]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 7H4a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>
            Best Selling Products
        </h3>
        <table class="data-table">
            <thead><tr><th>Product</th><th>Units</th><th>Revenue</th></tr></thead>
            <tbody>
            @forelse($bestProducts as $row)
                <tr>
                    <td class="font-medium text-slate-900">{{ $row->name }}</td>
                    <td>{{ $row->units_sold }}</td>
                    <td class="font-medium">${{ number_format($row->revenue, 2) }}</td>
                </tr>
            @empty
                <tr><td colspan="3" class="text-center py-6 text-slate-400">No data</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

</div>

<div class="grid md:grid-cols-2 gap-4">

    {{-- Low Stock --}}
    <div class="panel p-5">
        <h3 class="text-sm font-semibold text-slate-800 mb-4 flex items-center gap-2">
            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            Low Stock Alerts
        </h3>
        @forelse($lowStock as $product)
            <div class="flex items-center justify-between py-2.5 border-b border-slate-100 last:border-0">
                <span class="text-sm font-medium text-slate-800">{{ $product->name }}</span>
                <div class="flex items-center gap-2 shrink-0 ml-3">
                    <span class="badge badge-danger">{{ $product->current_stock }} left</span>
                    <span class="text-xs text-slate-400">/ {{ $product->reorder_level }} min</span>
                </div>
            </div>
        @empty
            <p class="text-sm text-slate-400 py-4 text-center">All stock levels are healthy.</p>
        @endforelse
    </div>

    {{-- Monthly Sales Trend --}}
    <div class="panel p-5">
        <h3 class="text-sm font-semibold text-slate-800 mb-4 flex items-center gap-2">
            <svg class="w-4 h-4 text-[#047481]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 20V10"/><path d="M12 20V4"/><path d="M6 20v-6"/></svg>
            Monthly Sales Trend
        </h3>
        <canvas id="monthlyChart" class="max-h-56"></canvas>
    </div>

</div>

@endsection

@push('scripts')
<script>
    new Chart(document.getElementById('monthlyChart'), {
        type: 'bar',
        data: {
            labels: @json($monthlySales->pluck('month_start')),
            datasets: [{
                label: 'Gross Sales',
                data: @json($monthlySales->pluck('gross_sales')),
                backgroundColor: 'rgba(6,148,162,0.75)',
                borderRadius: 4,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { display: false }, ticks: { font: { size: 11 } } },
                y: { grid: { color: '#f1f5f9' }, ticks: { font: { size: 11 } } }
            }
        }
    });
</script>
@endpush
