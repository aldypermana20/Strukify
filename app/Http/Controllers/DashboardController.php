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

            // 4. Build spending trend data for line chart
            $trendLabels = [];
            $trendData = [];

            if ($period === 'today') {
                // Show last 7 days
                for ($i = 6; $i >= 0; $i--) {
                    $date = Carbon::today()->subDays($i);
                    $trendLabels[] = $date->format('d M');
                    $trendData[] = (float) $user->receipts()
                        ->where('status', 'saved')
                        ->whereDate('receipt_date', $date)
                        ->sum('total');
                }
            } elseif ($period === 'month') {
                // Show each day of this month up to today
                $start = Carbon::now()->startOfMonth();
                $end = Carbon::now();
                for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
                    $trendLabels[] = $date->format('d');
                    $trendData[] = (float) $user->receipts()
                        ->where('status', 'saved')
                        ->whereDate('receipt_date', $date)
                        ->sum('total');
                }
            } elseif ($period === 'year') {
                // Show each month of this year
                for ($m = 1; $m <= 12; $m++) {
                    $trendLabels[] = Carbon::create(null, $m, 1)->format('M');
                    $trendData[] = (float) $user->receipts()
                        ->where('status', 'saved')
                        ->whereMonth('receipt_date', $m)
                        ->whereYear('receipt_date', Carbon::now()->year)
                        ->sum('total');
                }
            }

            return [
                'totalSpending' => $totalSpending,
                'totalReceipts' => $totalReceipts,
                'avgSpending' => $avgSpending,
                'trendLabels' => $trendLabels,
                'trendData' => $trendData
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
