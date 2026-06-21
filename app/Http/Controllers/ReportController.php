<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Default to this month
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));
        $period = $request->input('period', 'custom');

        if ($period === 'today') {
            $startDate = Carbon::now()->format('Y-m-d');
            $endDate = Carbon::now()->format('Y-m-d');
        } elseif ($period === 'month') {
            $startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
            $endDate = Carbon::now()->endOfMonth()->format('Y-m-d');
        } elseif ($period === 'year') {
            $startDate = Carbon::now()->startOfYear()->format('Y-m-d');
            $endDate = Carbon::now()->endOfYear()->format('Y-m-d');
        }

        $receipts = $user->receipts()
            ->where('status', 'saved')
            ->whereBetween('receipt_date', [$startDate, $endDate])
            ->latest('receipt_date')
            ->get();

        $totalAmount = $receipts->sum('total');
        
        // Average per transaction
        $avgPerTransaction = $receipts->count() > 0 ? $totalAmount / $receipts->count() : 0;

        // Previous period comparison
        $daysDiff = Carbon::parse($startDate)->diffInDays(Carbon::parse($endDate)) + 1;
        $prevStartDate = Carbon::parse($startDate)->subDays($daysDiff)->format('Y-m-d');
        $prevEndDate = Carbon::parse($startDate)->subDay()->format('Y-m-d');
        
        $prevTotal = $user->receipts()
            ->where('status', 'saved')
            ->whereBetween('receipt_date', [$prevStartDate, $prevEndDate])
            ->sum('total');

        $percentChange = $prevTotal > 0 ? round((($totalAmount - $prevTotal) / $prevTotal) * 100, 1) : null;

        // Daily trend data
        $trendLabels = [];
        $trendData = [];
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);

        if ($start->diffInDays($end) <= 31) {
            // Show daily
            for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
                $trendLabels[] = $date->format('d M');
                $trendData[] = (float) $user->receipts()
                    ->where('status', 'saved')
                    ->whereDate('receipt_date', $date)
                    ->sum('total');
            }
        } else {
            // Show monthly
            for ($date = $start->copy()->startOfMonth(); $date->lte($end); $date->addMonth()) {
                $trendLabels[] = $date->format('M Y');
                $trendData[] = (float) $user->receipts()
                    ->where('status', 'saved')
                    ->whereMonth('receipt_date', $date->month)
                    ->whereYear('receipt_date', $date->year)
                    ->sum('total');
            }
        }
        
        return view('reports.index', compact(
            'receipts', 'startDate', 'endDate', 'totalAmount', 'period',
            'avgPerTransaction', 'percentChange', 'prevTotal',
            'trendLabels', 'trendData'
        ));
    }
}
