<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Quotation - Blue Sky Creation</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet" />

    <style>
        :root {
            --primary: #0d3b66;
            --secondary: #f4d35e;
            --light: #fafafa;
            --accent: #d9eaf7;
            --text: #222;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light);
            color: var(--text);
            padding: 40px;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 40px;
            border-bottom: 3px solid var(--accent);
            padding-bottom: 10px;
        }

        .logo h1 {
            font-size: 28px;
            color: var(--primary);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .contact-info {
            text-align: right;
            font-size: 14px;
            color: #555;
            line-height: 1.5;
        }

        .customer-section {
            display: flex;
            align-items: center;
            margin-bottom: 40px;
        }

        .customer-card {
            background-color: var(--secondary);
            color: #333;
            border-radius: 8px;
            padding: 15px 20px;
            width: 40%;
        }

        .customer-card p {
            margin: 3px 0;
            font-size: 14px;
        }

        .quotation-title {
            flex-grow: 1;
            text-align: center;
        }

        .quotation-title h2 {
            font-size: 48px;
            font-weight: 700;
            color: var(--primary);
            letter-spacing: 3px;
        }

        .quote-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .quote-box {
            background: var(--accent);
            padding: 10px 15px;
            border-radius: 8px;
            width: 30%;
        }

        .quote-box p {
            font-size: 13px;
            margin: 2px 0;
        }

        .quote-box .label {
            font-weight: 600;
            color: var(--primary);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }

        table thead {
            background: var(--accent);
        }

        table th,
        table td {
            text-align: left;
            padding: 10px;
            border-bottom: 1px solid #ddd;
            font-size: 14px;
            vertical-align: top;
        }

        table th {
            font-weight: 600;
            color: var(--primary);
        }

        .summary {
            width: 35%;
            margin-left: auto;
            font-size: 14px;
        }

        .summary div {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
        }

        .summary .total {
            border-top: 2px solid var(--primary);
            font-weight: 700;
            margin-top: 10px;
            padding-top: 10px;
            font-size: 16px;
            color: var(--primary);
        }

        footer {
            border-top: 3px solid var(--accent);
            padding-top: 15px;
            text-align: center;
            font-size: 13px;
            color: #555;
            margin-top: 50px;
            line-height: 1.6;
        }

        .page-break {
            page-break-before: always;
        }

        .work-process {
            margin-top: 50px;
        }

        .work-process h3 {
            text-align: center;
            color: var(--primary);
            font-size: 22px;
            margin-bottom: 25px;
            font-weight: 700;
        }

        .steps {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .step {
            background: var(--accent);
            padding: 15px;
            border-radius: 8px;
        }

        .step p {
            font-size: 13px;
            margin: 4px 0;
        }

        .step .title {
            font-weight: 600;
            color: var(--primary);
        }

        @media print {
            body {
                padding: 20mm;
            }

            .page-break {
                break-before: page;
            }
        }
    </style>
</head>

<body>
    <header>
        <div class="logo">
            <h1>Blue Sky Creation</h1>
        </div>
        <div class="contact-info">
            <p>0878-1234-1234</p>
            <p>hello@blueskycreation.id</p>
            <p>www.blueskycreation.id</p>
        </div>
    </header>

    <section class="customer-section">
        <div class="customer-card">
            <p><strong>Prepared for:</strong></p>
            <p>{{ $customer->salutation }} {{ $customer->name }}</p>
            <p>{{ $customer->title }}</p>
            <p>{{ $customer->company }}</p>
            <p>{{ $customer->email }}</p>
        </div>
        <div class="quotation-title">
            <h2>QUOTATION</h2>
        </div>
    </section>

    <section class="quote-info">
        <div class="quote-box">
            <p class="label">Quote Number</p>
            <p>{{ $quotation->number }}</p>
        </div>
        <div class="quote-box">
            <p class="label">Quote Date</p>
            <p>{{ formatDate($quotation->quotation_date) }}</p>
        </div>
        <div class="quote-box">
            <p class="label">Valid Until</p>
            <p>{{ formatDate(addDays($quotation->quotation_date, 30)) }}</p>
        </div>
    </section>

    <section>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                </tr>
            </thead>
            <tbody>
                @php $subtotal = 0; @endphp
                @foreach ($quotations as $key => $q)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{!! $q->description !!}</td>
                        <td>{{ $q->qty }}</td>
                        <td>{{ number_format($q->price) }}</td>
                    </tr>
                    @php $subtotal += $q->price; @endphp
                @endforeach
            </tbody>
        </table>

        <div class="summary">
            <div><span>Subtotal:</span><span>{{ number_format($subtotal) }}</span></div>
            @php $tax = $q->tax ? ($q->tax * $subtotal) / 100 : 0; @endphp
            <div><span>Tax ({{ $q->tax ?? 'N/A' }}%):</span><span>{{ number_format($tax) }}</span></div>
            <div class="total"><span>Grand Total:</span><span>{{ number_format($subtotal + $tax) }}</span></div>
        </div>
    </section>

    <footer>
        Blue Sky Creation | Contact: +62-878-1234-1234 | Email: hello@blueskycreation.id<br />
        Instagram: @blueskycreation | Website: https://blueskycreation.id
    </footer>

    <div class="page-break"></div>

    <section class="work-process">
        <h3>WORK PROCESS</h3>
        <div class="steps">
            <div class="step">
                <p class="title">Step 1 : Contract</p>
                <p>Client chooses package and signs the agreement.</p>
            </div>
            <div class="step">
                <p class="title">Step 2 : Advance Payment</p>
                <p>Full payment is required before the project begins.</p>
            </div>
            <div class="step">
                <p class="title">Step 3 : Design & Strategy</p>
                <p>Our team prepares creative plans and drafts.</p>
            </div>
            <div class="step">
                <p class="title">Step 4 : Execution</p>
                <p>Implementation across all social media platforms.</p>
            </div>
            <div class="step">
                <p class="title">Step 5 : Review</p>
                <p>We provide monthly reports and evaluations.</p>
            </div>
            <div class="step">
                <p class="title">Step 6 : Completion</p>
                <p>Final results delivered and project closure.</p>
            </div>
        </div>
    </section>

    <footer>
        Blue Sky Creation | hello@blueskycreation.id | www.blueskycreation.id
    </footer>
</body>

</html>
