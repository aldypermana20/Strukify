<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Receipt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $receipts = Auth::user()->receipts()->latest()->paginate(10);
        return view('receipts.index', compact('receipts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('receipts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'store_name' => 'required|string|max:255',
            'receipt_date' => 'required|date',
            'total' => 'required|numeric|min:0',
            'items' => 'required|array|min:1',
            'items.*.item_name' => 'required|string|max:255',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.category_id' => 'required|exists:categories,id',
        ]);

        $receipt = Auth::user()->receipts()->create([
            'store_name' => $validated['store_name'],
            'receipt_date' => $validated['receipt_date'],
            'total' => $validated['total'],
            'status' => 'saved', // Manual creation means it's saved
        ]);

        foreach ($validated['items'] as $item) {
            $receipt->items()->create($item);
        }

        return redirect()->route('receipts.index')->with('success', 'Struk berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Receipt $receipt)
    {
        if ($receipt->user_id !== Auth::id()) {
            abort(403);
        }
        $receipt->load('items.category');
        return view('receipts.show', compact('receipt'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Receipt $receipt)
    {
        if ($receipt->user_id !== Auth::id()) {
            abort(403);
        }
        $receipt->load('items');
        $categories = Category::all();
        return view('receipts.edit', compact('receipt', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Receipt $receipt)
    {
        if ($receipt->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'store_name' => 'required|string|max:255',
            'receipt_date' => 'required|date',
            'total' => 'required|numeric|min:0',
            'items' => 'required|array|min:1',
            'items.*.id' => 'nullable|exists:receipt_items,id',
            'items.*.item_name' => 'required|string|max:255',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.category_id' => 'required|exists:categories,id',
        ]);

        $receipt->update([
            'store_name' => $validated['store_name'],
            'receipt_date' => $validated['receipt_date'],
            'total' => $validated['total'],
            'status' => 'saved',
        ]);

        $existingItemIds = $receipt->items->pluck('id')->toArray();
        $updatedItemIds = [];

        foreach ($validated['items'] as $itemData) {
            if (isset($itemData['id'])) {
                // Update existing item
                $item = $receipt->items()->find($itemData['id']);
                if ($item) {
                    $item->update($itemData);
                    $updatedItemIds[] = $item->id;
                }
            } else {
                // Create new item
                $newItem = $receipt->items()->create($itemData);
                $updatedItemIds[] = $newItem->id;
            }
        }

        // Delete removed items
        $itemsToDelete = array_diff($existingItemIds, $updatedItemIds);
        if (!empty($itemsToDelete)) {
            $receipt->items()->whereIn('id', $itemsToDelete)->delete();
        }

        return redirect()->route('receipts.show', $receipt)->with('success', 'Struk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Receipt $receipt)
    {
        if ($receipt->user_id !== Auth::id()) {
            abort(403);
        }
        $receipt->delete();
        return redirect()->route('receipts.index')->with('success', 'Struk berhasil dihapus.');
    }
}
