<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\SalesOrder;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $stats = [
            'products' => Product::count(),
            'customers' => Customer::count(),
            'suppliers' => Supplier::count(),
            'sales' => SalesOrder::where('status', 'completed')->sum('total_amount'),
        ];

        $monthlySales = DB::table('monthly_sales_summary')
            ->selectRaw('to_char(month_start, \'YYYY-MM\') as month, gross_sales')
            ->limit(6)
            ->get();

        $recentOrders = SalesOrder::with('customer')
            ->latest()
            ->limit(8)
            ->get();

        return view('dashboard', compact('stats', 'monthlySales', 'recentOrders'));
    }
}
