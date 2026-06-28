<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $period = $request->input('period', 'month'); // Default to month
        
        // Use a unique cache key per user and period
        $cacheKey = "dashboard_data_{$user->id}_{$period}_" . date('Y-m-d');

        // We cache the heavy dashboard statistics for 10 minutes.
        $dashboardData = \Illuminate\Support\Facades\Cache::remember($cacheKey, 600, function () use ($user, $period) {
            
            $baseQuery = $user->receipts()->where('status', 'saved');

            // Apply Period Filter
            if ($period === 'today') {
                $baseQuery->whereDate('receipt_date', Carbon::today());
            } elseif ($period === 'month') {
                $baseQuery->whereMonth('receipt_date', Carbon::now()->month)
                          ->whereYear('receipt_date', Carbon::now()->year);
            } elseif ($period === 'year') {
                $baseQuery->whereYear('receipt_date', Carbon::now()->year);
            }

            // 1. Calculate total spending
            $totalSpending = (clone $baseQuery)->sum('total');

            // 2. Calculate total number of receipts
            $totalReceipts = (clone $baseQuery)->count();

            // 3. Calculate average spending per receipt
            $avgSpending = $totalReceipts > 0 ? $totalSpending / $totalReceipts : 0;

            // 4. Build spending category data for donut chart
            $categoryStatsQuery = DB::table('receipt_items')
                ->join('receipts', 'receipt_items.receipt_id', '=', 'receipts.id')
                ->leftJoin('categories', 'receipt_items.category_id', '=', 'categories.id')
                ->where('receipts.user_id', $user->id)
                ->where('receipts.status', 'saved');

            if ($period === 'today') {
                $categoryStatsQuery->whereDate('receipts.receipt_date', Carbon::today());
            } elseif ($period === 'month') {
                $categoryStatsQuery->whereMonth('receipts.receipt_date', Carbon::now()->month)
                              ->whereYear('receipts.receipt_date', Carbon::now()->year);
            } elseif ($period === 'year') {
                $categoryStatsQuery->whereYear('receipts.receipt_date', Carbon::now()->year);
            }

            $categoryStats = $categoryStatsQuery->selectRaw('COALESCE(categories.name, "Lainnya") as name, SUM(receipt_items.quantity * receipt_items.price) as total')
                ->groupByRaw('COALESCE(categories.name, "Lainnya")')
                ->orderByDesc('total')
                ->get();

            $categoryLabels = $categoryStats->pluck('name')->toArray();
            $categoryData = $categoryStats->pluck('total')->map(fn($v) => (float)$v)->toArray();

            $topCategory = $categoryStats->first();
            $topCategoryName = $topCategory ? $topCategory->name : '-';

            return [
                'totalSpending' => $totalSpending,
                'totalReceipts' => $totalReceipts,
                'avgSpending' => $avgSpending,
                'categoryLabels' => $categoryLabels,
                'categoryData' => $categoryData,
                'topCategoryName' => $topCategoryName
            ];
        });

        // 5. Get 5 most recent receipts (not cached so new data shows up immediately)
        $recentReceipts = $user->receipts()
            ->latest('receipt_date')
            ->take(5)
            ->get();

        return view('dashboard', array_merge($dashboardData, [
            'recentReceipts' => $recentReceipts,
            'period' => $period
        ]));
    }
}
