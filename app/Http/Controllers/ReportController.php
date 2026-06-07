<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        
        return view('reports.index', compact('receipts', 'startDate', 'endDate', 'totalAmount', 'period'));
    }
}
