<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Struk Pembelian - {{ $receipt->store_name }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 14px;
            color: #333;
            line-height: 1.6;
            max-width: 450px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px dashed #ccc;
            padding-bottom: 15px;
        }
        .header h1 {
            margin: 0;
            color: #333;
            font-size: 20px;
            letter-spacing: 1px;
        }
        .header p {
            margin: 5px 0 0 0;
            color: #666;
            font-size: 11px;
        }
        .info-section {
            margin-bottom: 25px;
        }
        .info-row {
            margin-bottom: 12px;
            border-bottom: 1px dashed #eee;
            padding-bottom: 8px;
        }
        .info-label {
            font-size: 11px;
            color: #777;
            text-transform: uppercase;
            margin-bottom: 2px;
            font-weight: bold;
        }
        .info-value {
            font-size: 14px;
            color: #111;
        }
        .total-box {
            background-color: #f9f9f9;
            border: 1px solid #eee;
            border-radius: 6px;
            padding: 15px;
            text-align: center;
            margin-bottom: 25px;
        }
        .total-label {
            font-size: 12px;
            color: #555;
            text-transform: uppercase;
            font-weight: bold;
            letter-spacing: 0.5px;
        }
        .total-amount {
            font-size: 24px;
            font-weight: bold;
            color: #10b981;
            margin-top: 5px;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #999;
            border-top: 2px dashed #ccc;
            padding-top: 15px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>ARSIP STRUK BELANJA</h1>
        <p>Dicetak melalui aplikasi Strukify</p>
    </div>

    <div class="info-section">
        <div class="info-row">
            <div class="info-label">Nama Toko / Perusahaan</div>
            <div class="info-value" style="font-weight: bold; font-size: 16px;">{{ $receipt->store_name ?: 'Toko Tidak Diketahui' }}</div>
        </div>
        
        <div class="info-row">
            <div class="info-label">Alamat Toko</div>
            <div class="info-value">{{ $receipt->address ?: 'Tidak ada alamat' }}</div>
        </div>

        <div class="info-row">
            <div class="info-label">Tanggal Transaksi</div>
            <div class="info-value">{{ $receipt->receipt_date->format('d F Y') }}</div>
        </div>

        <div class="info-row">
            <div class="info-label">Arsip Pengguna</div>
            <div class="info-value">{{ $user->name }} ({{ $user->email }})</div>
        </div>
    </div>

    <div class="total-box">
        <div class="total-label">Total Belanja</div>
        <div class="total-amount">Rp {{ number_format($receipt->total, 0, ',', '.') }}</div>
    </div>

    <div class="footer">
        Terima kasih telah menggunakan Strukify!<br>
        Dicetak pada: {{ $date_generated }}
    </div>

</body>
</html>
