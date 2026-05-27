@extends('layouts.app')

@section('title', 'Dashboard')
@section('heading', 'Dashboard')

@section('content')

{{-- Stat cards --}}
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">

    <div class="stat-card flex items-center gap-4">
        <div class="w-11 h-11 rounded-xl bg-[#cffafe] flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-[#047481]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 7H4a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>
        </div>
        <div>
            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Products</p>
            <p class="text-2xl font-bold text-slate-900 mt-0.5">{{ $stats['products'] }}</p>
        </div>
    </div>

    <div class="stat-card flex items-center gap-4">
        <div class="w-11 h-11 rounded-xl bg-[#dbeafe] flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        </div>
        <div>
            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Customers</p>
            <p class="text-2xl font-bold text-slate-900 mt-0.5">{{ $stats['customers'] }}</p>
        </div>
    </div>

    <div class="stat-card flex items-center gap-4">
        <div class="w-11 h-11 rounded-xl bg-[#fef3c7] flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 3h15v13H1z"/><path d="M16 8h4l3 3v5h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
        </div>
        <div>
            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Suppliers</p>
            <p class="text-2xl font-bold text-slate-900 mt-0.5">{{ $stats['suppliers'] }}</p>
        </div>
    </div>

    <div class="stat-card flex items-center gap-4">
        <div class="w-11 h-11 rounded-xl bg-[#d1fae5] flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
        </div>
        <div>
            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Completed Sales</p>
            <p class="text-2xl font-bold text-slate-900 mt-0.5">${{ number_format($stats['sales'], 2) }}</p>
        </div>
    </div>

</div>

{{-- Chart + Recent Orders --}}
<div class="grid grid-cols-1 xl:grid-cols-3 gap-4">

    {{-- Sales chart --}}
    <div class="panel p-5 xl:col-span-2">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-sm font-semibold text-slate-800">Monthly Sales</h2>
            <span class="badge badge-info">This year</span>
        </div>
        <canvas id="salesChart" class="max-h-64"></canvas>
    </div>

    {{-- Recent orders --}}
    <div class="panel p-5">
        <h2 class="text-sm font-semibold text-slate-800 mb-4">Recent Orders</h2>
        <div class="space-y-3">
            @forelse($recentOrders as $order)
                <div class="flex items-center justify-between py-2 border-b border-slate-100 last:border-0">
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-slate-800 truncate">{{ $order->order_number }}</p>
                        <p class="text-xs text-slate-400 truncate">{{ $order->customer->name }}</p>
                    </div>
                    <div class="text-right shrink-0 ml-3">
                        <p class="text-sm font-semibold text-slate-900">${{ number_format($order->total_amount, 2) }}</p>
                        @php
                            $statusClass = match($order->status) {
                                'completed' => 'badge-success',
                                'pending'   => 'badge-warning',
                                'cancelled' => 'badge-danger',
                                default     => 'badge-neutral',
                            };
                        @endphp
                        <span class="badge {{ $statusClass }} mt-1">{{ ucfirst($order->status) }}</span>
                    </div>
                </div>
            @empty
                <p class="text-sm text-slate-400 py-4 text-center">No recent orders</p>
            @endforelse
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
    new Chart(document.getElementById('salesChart'), {
        type: 'line',
        data: {
            labels: @json($monthlySales->pluck('month')),
            datasets: [{
                label: 'Gross Sales',
                data: @json($monthlySales->pluck('gross_sales')),
                borderColor: '#047481',
                backgroundColor: 'rgba(6,148,162,0.08)',
                borderWidth: 2,
                pointBackgroundColor: '#047481',
                pointRadius: 3,
                fill: true,
                tension: 0.4,
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
