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
        // Filter by start_date and end_date if passed via query string
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $query = Auth::user()->receipts()->where('status', 'saved')->orderBy('receipt_date', 'desc');

        if ($startDate && $endDate) {
            $query->whereBetween('receipt_date', [$startDate, $endDate]);
        }

        $receipts = $query->get();
        $totalSpending = $receipts->sum('total');

        $data = [
            'user' => Auth::user(),
            'receipts' => $receipts,
            'totalSpending' => $totalSpending,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'date_generated' => now()->format('d M Y H:i:s')
        ];

        // Load the view and pass data
        $pdf = Pdf::loadView('receipts.export-pdf', $data);

        // Stream the PDF instead of downloading so it opens in the browser's PDF viewer (for printing)
        $filename = 'Laporan_Pengeluaran_Strukify_' . now()->format('Ymd_His') . '.pdf';
        return $pdf->stream($filename);
    }
}
