<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pengeluaran - Strukify</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.5;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #06b6d4;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            color: #06b6d4;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0 0 0;
            color: #666;
        }
        .info-section {
            margin-bottom: 20px;
        }
        .info-table {
            width: 100%;
        }
        .info-table td {
            padding: 3px 0;
        }
        .info-label {
            font-weight: bold;
            width: 150px;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .data-table th {
            background-color: #f3f4f6;
            color: #374151;
            font-weight: bold;
            text-align: left;
            padding: 10px;
            border-bottom: 2px solid #d1d5db;
        }
        .data-table td {
            padding: 10px;
            border-bottom: 1px solid #e5e7eb;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .total-row {
            font-weight: bold;
            background-color: #f9fafb;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 10px;
            color: #9ca3af;
            border-top: 1px solid #e5e7eb;
            padding-top: 10px;
        }
        .status-badge {
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: bold;
        }
        .status-saved { background-color: #d1fae5; color: #065f46; }
        .status-pending { background-color: #fef3c7; color: #92400e; }
        .status-review { background-color: #dbeafe; color: #1e40af; }
    </style>
</head>
<body>

    <div class="header">
        <h1>Strukify</h1>
        <p>Laporan Pengeluaran Cerdas</p>
    </div>

    <div class="info-section">
        <table class="info-table">
            <tr>
                <td class="info-label">Nama Pengguna:</td>
                <td>{{ $user->name }}</td>
                <td class="info-label">Tanggal Cetak:</td>
                <td>{{ $date_generated }}</td>
            </tr>
            <tr>
                <td class="info-label">Email:</td>
                <td>{{ $user->email }}</td>
                <td class="info-label">Periode Laporan:</td>
                <td>
                    @if(isset($startDate) && isset($endDate))
                        {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}
                    @else
                        Semua Waktu
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Toko / Merchant</th>
                <th>Status</th>
                <th class="text-right">Total (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($receipts as $index => $receipt)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $receipt->receipt_date->format('d/m/Y') }}</td>
                <td>{{ $receipt->store_name ?: 'Tidak Diketahui' }}</td>
                <td>
                    @if($receipt->status === 'saved')
                        <span class="status-badge status-saved">Disimpan</span>
                    @elseif(in_array($receipt->status, ['processing', 'pending']))
                        <span class="status-badge status-pending">Pending</span>
                    @elseif(in_array($receipt->status, ['review_needed', 'review']))
                        <span class="status-badge status-review">Perlu Review</span>
                    @else
                        <span>{{ ucfirst($receipt->status) }}</span>
                    @endif
                </td>
                <td class="text-right">{{ number_format($receipt->total, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Belum ada data pengeluaran.</td>
            </tr>
            @endforelse
            <tr class="total-row">
                <td colspan="4" class="text-right">TOTAL PENGELUARAN</td>
                <td class="text-right">Rp {{ number_format($totalSpending, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        Dokumen ini dihasilkan secara otomatis oleh sistem Strukify.<br>
        &copy; {{ date('Y') }} Strukify App.
    </div>

</body>
</html>
