<?php

namespace App\Jobs;

use App\Models\Receipt;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class ProcessReceiptScan implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $receipt;
    public $timeout = 120; // Allow 2 minutes for processing

    /**
     * Create a new job instance.
     */
    public function __construct(Receipt $receipt)
    {
        $this->receipt = $receipt;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $imagePath = storage_path('app/public/' . $this->receipt->image_path);
            
            if (!file_exists($imagePath)) {
                throw new Exception('Image file not found: ' . $imagePath);
            }

            // Send to FastAPI Service
            $response = Http::timeout(60)
                ->attach('image', file_get_contents($imagePath), basename($imagePath))
                ->post('http://127.0.0.1:8001/api/scan');

            if (!$response->successful()) {
                throw new Exception('AI Service Error: ' . $response->body());
            }

            $aiData = $response->json();

            // Update receipt with AI extracted data
            $this->receipt->update([
                'store_name' => $aiData['store_name'] ?? 'Unknown Store',
                'receipt_date' => !empty($aiData['receipt_date']) ? $aiData['receipt_date'] : now(),
                'total' => $aiData['total'] ?? 0,
                'status' => 'review_needed' // Needs review by user
            ]);

            // Save items if any exist
            if (isset($aiData['items']) && is_array($aiData['items'])) {
                foreach ($aiData['items'] as $item) {
                    $this->receipt->items()->create([
                        'item_name' => $item['item_name'] ?? 'Unknown Item',
                        'price' => $item['price'] ?? 0,
                        'quantity' => $item['quantity'] ?? 1,
                        'category_id' => $item['category_id'] ?? 7 // 7 is Lainnya as fallback
                    ]);
                }
            }

        } catch (Exception $e) {
            Log::error('Receipt scan failed: ' . $e->getMessage());
            $this->receipt->update([
                'status' => 'failed'
            ]);
        }
    }
}
