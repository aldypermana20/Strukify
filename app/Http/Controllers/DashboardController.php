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
            $itemsBaseQuery = DB::table('receipt_items')
                ->join('receipts', 'receipt_items.receipt_id', '=', 'receipts.id')
                ->join('categories', 'receipt_items.category_id', '=', 'categories.id')
                ->where('receipts.user_id', $user->id)
                ->where('receipts.status', 'saved');

            // Apply Period Filter
            if ($period === 'today') {
                $baseQuery->whereDate('receipt_date', Carbon::today());
                $itemsBaseQuery->whereDate('receipts.receipt_date', Carbon::today());
            } elseif ($period === 'month') {
                $baseQuery->whereMonth('receipt_date', Carbon::now()->month)
                          ->whereYear('receipt_date', Carbon::now()->year);
                $itemsBaseQuery->whereMonth('receipts.receipt_date', Carbon::now()->month)
                               ->whereYear('receipts.receipt_date', Carbon::now()->year);
            } elseif ($period === 'year') {
                $baseQuery->whereYear('receipt_date', Carbon::now()->year);
                $itemsBaseQuery->whereYear('receipts.receipt_date', Carbon::now()->year);
            }

            // 1. Calculate total spending
            $totalSpending = (clone $baseQuery)->sum('total');

            // 2. Calculate total number of receipts
            $totalReceipts = (clone $baseQuery)->count();

            // 3. Determine the top spending category
            $topCategoryQuery = (clone $itemsBaseQuery)
                ->select('categories.name', DB::raw('SUM(receipt_items.price * receipt_items.quantity) as total_amount'))
                ->groupBy('categories.name')
                ->orderByDesc('total_amount')
                ->first();

            $topCategory = $topCategoryQuery ? $topCategoryQuery->name : '-';

            // 4. Group expenses by category for a chart
            $categoryData = (clone $itemsBaseQuery)
                ->select('categories.name', 'categories.color', DB::raw('SUM(receipt_items.price * receipt_items.quantity) as total_amount'))
                ->groupBy('categories.id', 'categories.name', 'categories.color')
                ->orderByDesc('total_amount')
                ->get();

            // Prepare data for Chart.js
            $chartLabels = $categoryData->pluck('name')->toArray();
            $chartData = $categoryData->pluck('total_amount')->toArray();
            
            // Map Tailwind color names to Hex colors for Chart.js
            $colorMap = [
                'amber' => '#f59e0b',
                'blue' => '#3b82f6',
                'cyan' => '#06b6d4',
                'rose' => '#f43f5e',
                'emerald' => '#10b981',
                'indigo' => '#6366f1',
                'gray' => '#6b7280',
            ];
            
            $chartColors = $categoryData->map(function ($item) use ($colorMap) {
                return $colorMap[$item->color] ?? '#6b7280';
            })->toArray();

            return [
                'totalSpending' => $totalSpending,
                'totalReceipts' => $totalReceipts,
                'topCategory' => $topCategory,
                'chartLabels' => $chartLabels,
                'chartData' => $chartData,
                'chartColors' => $chartColors
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
