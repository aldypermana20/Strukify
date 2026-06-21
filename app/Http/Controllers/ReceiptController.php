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
    public function index(Request $request)
    {
        $query = Auth::user()->receipts()->latest();

        // Search by store name
        if ($request->filled('search')) {
            $query->where('store_name', 'like', '%' . $request->search . '%');
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('receipt_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('receipt_date', '<=', $request->date_to);
        }

        $receipts = $query->paginate(10)->withQueryString();
        return view('receipts.index', compact('receipts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('receipts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'store_name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'receipt_date' => 'required|date',
            'total' => 'required|numeric|min:0',
            'receipt_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $imagePath = null;
        if ($request->hasFile('receipt_image')) {
            $imagePath = $request->file('receipt_image')->store('receipts', 'public');
        }

        Auth::user()->receipts()->create([
            'store_name' => $validated['store_name'],
            'address' => $validated['address'] ?? null,
            'receipt_date' => $validated['receipt_date'],
            'total' => $validated['total'],
            'image_path' => $imagePath,
            'status' => 'saved', // Manual creation means it's saved
        ]);

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
        return view('receipts.edit', compact('receipt'));
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
            'address' => 'nullable|string',
            'receipt_date' => 'required|date',
            'total' => 'required|numeric|min:0',
        ]);

        $receipt->update([
            'store_name' => $validated['store_name'],
            'address' => $validated['address'] ?? null,
            'receipt_date' => $validated['receipt_date'],
            'total' => $validated['total'],
            'status' => 'saved',
        ]);

        return redirect()->route('receipts.show', $receipt)->with('success', 'Struk berhasil diperbarui.');
    }

    /**
     * Confirm and save the receipt from review state.
     */
    public function confirm(Receipt $receipt)
    {
        if ($receipt->user_id !== Auth::id()) {
            abort(403);
        }

        $receipt->update(['status' => 'saved']);

        return redirect()->route('receipts.index')->with('success', 'Struk berhasil disimpan.');
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
