<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(): View
    {
        $topCustomers = DB::table('sales_orders as so')
            ->join('customers as c', 'c.id', '=', 'so.customer_id')
            ->selectRaw('c.name, COUNT(so.id) as total_orders, SUM(so.total_amount) as total_spent')
            ->where('so.status', 'completed')
            ->groupBy('c.id', 'c.name')
            ->havingRaw('SUM(so.total_amount) > 1000')
            ->orderByDesc('total_spent')
            ->limit(10)
            ->get();

        $bestProducts = DB::table('sales_order_items as soi')
            ->join('products as p', 'p.id', '=', 'soi.product_id')
            ->selectRaw('p.name, SUM(soi.quantity) as units_sold, SUM(soi.line_total) as revenue')
            ->groupBy('p.id', 'p.name')
            ->orderByDesc('units_sold')
            ->limit(10)
            ->get();

        $lowStock = Product::whereColumn('current_stock', '<=', 'reorder_level')
            ->orderBy('current_stock')
            ->limit(15)
            ->get();

        $monthlySales = DB::table('monthly_sales_summary')
            ->selectRaw("TO_CHAR(month_start, 'Mon YYYY') as month_start, gross_sales")
            ->orderBy('month_start')
            ->limit(12)
            ->get();

        return view('reports.index', compact('topCustomers', 'bestProducts', 'lowStock', 'monthlySales'));
    }
}
