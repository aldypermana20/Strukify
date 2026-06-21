<?php

namespace App\Http\Controllers;

use App\Models\Receipt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportController extends Controller
{
    /**
     * Export receipts to PDF for the authenticated user.
     */
    public function exportPdf(Request $request)
    {
        $query = Auth::user()->receipts()->orderBy('receipt_date', 'desc');

        // Allow both old start_date/end_date and new date_from/date_to parameters
        $dateFrom = $request->query('date_from', $request->query('start_date'));
        $dateTo = $request->query('date_to', $request->query('end_date'));

        // Search by store name
        if ($request->filled('search')) {
            $query->where('store_name', 'like', '%' . $request->search . '%');
        }

        // Filter by status (default to 'saved' if not explicitly provided, to prevent printing processing/failed receipts unless specifically asked)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            $query->where('status', 'saved');
        }

        // Filter by date range
        if ($dateFrom) {
            $query->whereDate('receipt_date', '>=', $dateFrom);
        }
        if ($dateTo) {
            $query->whereDate('receipt_date', '<=', $dateTo);
        }

        $receipts = $query->get();
        $totalSpending = $receipts->sum('total');

        $data = [
            'user' => Auth::user(),
            'receipts' => $receipts,
            'totalSpending' => $totalSpending,
            'startDate' => $dateFrom,
            'endDate' => $dateTo,
            'date_generated' => now()->format('d M Y H:i:s')
        ];

        // Load the view and pass data
        $pdf = Pdf::loadView('receipts.export-pdf', $data);

        // Stream the PDF instead of downloading so it opens in the browser's PDF viewer (for printing)
        $filename = 'Laporan_Pengeluaran_Strukify_' . now()->format('Ymd_His') . '.pdf';
        return $pdf->stream($filename);
    }

    /**
     * Export a single receipt to PDF for the authenticated user.
     */
    public function exportSinglePdf(Receipt $receipt)
    {
        if ($receipt->user_id !== Auth::id()) {
            abort(403);
        }

        // No relationship loading needed for items and categories anymore

        $data = [
            'user' => Auth::user(),
            'receipt' => $receipt,
            'date_generated' => now()->format('d M Y H:i:s')
        ];

        // Load the view and pass data
        $pdf = Pdf::loadView('receipts.export-single-pdf', $data);

        // Stream the PDF
        $filename = 'Struk_' . \Str::slug($receipt->store_name ?: 'Unknown') . '_' . $receipt->receipt_date->format('Ymd') . '.pdf';
        return $pdf->stream($filename);
    }
}
