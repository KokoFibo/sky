<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Quotation - Contoh Sederhana</title>
    <style>
        /* Reset ringan */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html,
        body {
            height: 100%;
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
            color: #1f2937;
            background: #f8fafc;
            padding: 24px;
        }

        /* Kontainer pusat */
        .card {
            max-width: 900px;
            margin: 0 auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(15, 23, 42, 0.06);
            overflow: hidden;
            padding: 28px;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 20px;
            margin-bottom: 22px;
        }

        .company {
            display: flex;
            gap: 16px;
            align-items: center;
        }

        .logo {
            width: 68px;
            height: 68px;
            border-radius: 8px;
            background: linear-gradient(135deg, #2563eb, #7c3aed);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 20px;
            flex-shrink: 0;
        }

        .company-info h1 {
            font-size: 18px;
            letter-spacing: 0.2px;
        }

        .company-info p {
            font-size: 13px;
            color: #475569;
            margin-top: 4px;
            line-height: 1.4;
        }

        .meta {
            text-align: right;
            min-width: 200px;
        }

        .meta .title {
            font-weight: 700;
            font-size: 14px;
            color: #0f172a;
        }

        .meta .small {
            font-size: 13px;
            color: #475569;
            margin-top: 6px;
        }

        /* Recipient & info */
        .section {
            display: flex;
            gap: 24px;
            margin-bottom: 18px;
            flex-wrap: wrap;
        }

        .box {
            flex: 1;
            min-width: 220px;
            background: #f1f5f9;
            padding: 14px;
            border-radius: 8px;
        }

        .box h3 {
            font-size: 13px;
            margin-bottom: 8px;
            color: #0f172a;
        }

        .box p {
            font-size: 13px;
            color: #374151;
            line-height: 1.4;
        }

        /* Tabel item */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }

        thead th {
            text-align: left;
            font-size: 13px;
            padding: 12px 8px;
            background: #f8fafc;
            color: #0f172a;
            border-bottom: 1px solid #e6eef8;
        }

        tbody td {
            padding: 12px 8px;
            vertical-align: top;
            font-size: 13px;
            color: #334155;
            border-bottom: 1px dashed #eef2f7;
        }

        .text-right {
            text-align: right;
        }

        .qty {
            width: 80px;
            text-align: center;
        }

        /* Ringkasan biaya */
        .summary {
            display: flex;
            justify-content: flex-end;
            margin-top: 12px;
        }

        .summary .inner {
            width: 320px;
            background: #fff;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #eef2f7;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 6px 0;
            font-size: 13px;
            color: #374151;
        }

        .summary-row.total {
            font-weight: 700;
            font-size: 16px;
            color: #0f172a;
            border-top: 1px solid #eef2f7;
            margin-top: 6px;
            padding-top: 10px;
        }

        /* Catatan & tanda tangan */
        .notes {
            margin-top: 18px;
            display: flex;
            gap: 24px;
            flex-wrap: wrap;
        }

        .notes .left {
            flex: 1;
            min-width: 220px;
            font-size: 13px;
            color: #475569;
        }

        .notes .right {
            width: 240px;
            text-align: center;
            font-size: 13px;
        }

        .signature {
            height: 56px;
            margin-top: 6px;
            border-bottom: 1px dashed rgba(15, 23, 42, 0.08);
        }

        /* Footer kecil */
        footer {
            margin-top: 20px;
            font-size: 12px;
            color: #64748b;
            text-align: center;
        }

        /* Responsive */
        @media (max-width: 640px) {
            header {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }

            .meta {
                text-align: left;
                width: 100%;
            }

            .summary {
                justify-content: center;
            }

            .summary .inner {
                width: 100%;
            }
        }

        /* Print */
        @media print {
            body {
                background: #fff;
                padding: 0;
            }

            .card {
                box-shadow: none;
                border-radius: 0;
                margin: 0;
            }

            footer {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="card">
        <header>
            <div class="company">
                <div class="logo">BSC</div>
                <div class="company-info">
                    <h1>Blue Sky Creation</h1>
                    <p>Jl. Contoh No. 12, Jakarta<br />Phone: +62 812-3456-7890 • email@contoh.id</p>
                </div>
            </div>

            <div class="meta">
                <div class="title">Quotation</div>
                <div class="small">No: QTN-2025-001<br />Tanggal: 8 November 2025<br />Berlaku sampai: 22 November 2025
                </div>
            </div>
        </header>

        <div class="section">
            <div class="box">
                <h3>Kepada</h3>
                <p>
                    Nama Klien: {{ $customer->company }}<br />
                    Attn: Bapak/Ibu Contoh<br />
                    Alamat: Jl. Pelayanan No. 9, Jakarta
                </p>
            </div>

            <div class="box">
                <h3>Informasi Pembayaran</h3>
                <p>
                    Bank: BCA<br />
                    A/N: Blue Sky Creation<br />
                    No. Rek: 123-456-7890
                </p>
            </div>
        </div>

        <table aria-label="Rincian Quotation">
            <thead>
                <tr>
                    <th style="width: 8%;">#</th>
                    <th>Deskripsi</th>
                    <th class="qty">Qty</th>
                    <th class="text-right">Harga Satuan</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Website Company Profile (5 halaman, responsive)</td>
                    <td class="qty">1</td>
                    <td class="text-right">Rp 8.500.000</td>
                    <td class="text-right">Rp 8.500.000</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Integrasi Form & Email</td>
                    <td class="qty">1</td>
                    <td class="text-right">Rp 1.500.000</td>
                    <td class="text-right">Rp 1.500.000</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Hosting & Domain (.id) - 1 tahun</td>
                    <td class="qty">1</td>
                    <td class="text-right">Rp 600.000</td>
                    <td class="text-right">Rp 600.000</td>
                </tr>
            </tbody>
        </table>

        <div class="summary" role="status" aria-live="polite">
            <div class="inner">
                <div class="summary-row"><span>Sub-total</span><span>Rp 10.600.000</span></div>
                <div class="summary-row"><span>PPN 11%</span><span>Rp 1.166.000</span></div>
                <div class="summary-row total"><span>Total</span><span>Rp 11.766.000</span></div>
            </div>
        </div>

        <div class="notes">
            <div class="left">
                <strong>Catatan:</strong>
                <p style="margin-top:8px;">
                    1. Harga belum termasuk biaya tambahan diluar scope.<br />
                    2. Pengerjaan dimulai setelah down payment 50% diterima.<br />
                    3. Estimasi waktu pengerjaan 2-3 minggu setelah konfirmasi.
                </p>
            </div>

            <div class="right">
                <div>Disetujui oleh,</div>
                <div class="signature" aria-hidden="true"></div>
                <div style="margin-top:8px;">(Nama & Jabatan)</div>
            </div>
        </div>

        <footer>
            Quotation ini adalah penawaran. Untuk konfirmasi pesanan silakan hubungi kami: +62 812-3456-7890 •
            email@contoh.id
        </footer>
    </div>
</body>

</html>
