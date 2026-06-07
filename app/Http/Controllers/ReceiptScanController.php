<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Exception;

class ReceiptScanController extends Controller
{
    /**
     * Show the upload form for scanning.
     */
    public function index()
    {
        return view('receipts.scan');
    }

    /**
     * Process the uploaded image, send to AI service, and return review view.
     */
    public function scan(Request $request)
    {
        // Implementasi Keamanan Fase 4: Validasi ekstensi dan mimes yang lebih ketat
        $request->validate([
            'receipt_image' => 'required|image|mimes:jpeg,png,jpg|max:10240', // Max 10MB, strictly JPG/PNG
        ]);

        $file = $request->file('receipt_image');
        
        try {
            // 1. Store image locally
            $path = $file->store('receipts', 'public');
            if (!$path) {
                throw new Exception('Gagal menyimpan file ke dalam folder storage. Pastikan permission folder /public/receipts sudah diatur dengan benar.');
            }

            // 2. Create initial processing record
            $receipt = \App\Models\Receipt::create([
                'user_id' => auth()->id(),
                'store_name' => 'Memproses AI...',
                'receipt_date' => now(),
                'total' => 0,
                'image_path' => $path,
                'status' => 'processing'
            ]);

            // 3. Dispatch background job
            \App\Jobs\ProcessReceiptScan::dispatch($receipt);

            // 4. Redirect to index view with message
            return redirect()->route('receipts.index')->with('success', 'Struk sedang diproses oleh AI. Silakan refresh halaman ini dalam beberapa saat.');

        } catch (Exception $e) {
            return back()->withErrors(['error' => 'Gagal memproses struk: ' . $e->getMessage()]);
        }
    }
}
