<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Quotation - {{ $customer->company ?? 'Customer' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }



        /* Quill list compatibility */
        .ql-editor ol li[data-list="ordered"] {
            list-style-type: decimal !important;
            margin-left: 1.5rem;
            lin
        }

        .ql-editor ol li[data-list="bullet"] {
            list-style-type: disc !important;
            margin-left: 1.5rem;

        }

        .ql-editor ul li,
        .ql-editor ol li {
            list-style-position: outside;
            margin-left: 1.5rem;
            margin-bottom: 5px;
            /* jarak antar list */
            line-height: 1.6;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 p-6 w-[21cm] h-[29cm]">
    <div class="max-w-4xl mx-auto bg-white shadow-2xl rounded-2xl p-8 border border-slate-100">

        <!-- Header -->
        <header class="flex justify-between items-start flex-wrap gap-6 mb-8 border-b border-slate-200 pb-5">
            <div class="">
                <div class="flex items-center gap-4">
                    <img src="https://sky.blueskycreation.id/images/logobsc.png" alt="Blue Sky Creation Logo"
                        class="h-10">


                    <h1 class="text-xl font-semibold text-slate-900">Blue Sky Creation</h1>

                </div>
                {{-- <p class="text-sm text-slate-600 leading-snug mt-2">
                    Jl. Contoh No. 12, Jakarta<br>
                    Phone: +62 812-3456-7890 <br>
                    hello@blueskycreation.id
                </p> --}}
            </div>

            <div class="text-right">
                <h2 class="text-lg font-semibold text-slate-800">Quotation</h2>
                <p class="text-sm text-slate-600 mt-2">
                    No: {{ quoNumberFormat($quotation->number ?? 0, $quotation->quotation_date ?? now()) }}<br>
                    Date: {{ \Carbon\Carbon::parse($quotation->quotation_date)->format('d M Y') }}<br>
                    Valid until: {{ \Carbon\Carbon::parse($quotation->valid_until)->format('d M Y') }}
                </p>
            </div>
        </header>

        <!-- Client & Payment Info -->
        <div class="flex flex-wrap gap-5 mb-8">
            <div class="flex-1 min-w-[220px] bg-slate-100 rounded-xl p-4">
                <h3 class="text-sm font-semibold mb-2 text-slate-800 uppercase">Client Details</h3>
                <p class="text-sm leading-relaxed text-slate-700">
                    <span class="font-medium">Company:</span> {{ $customer->company ?? '-' }}<br>
                    <span class="font-medium">Attn:</span> {{ $customer->name ?? 'Sir/Madam' }}<br>
                    <span class="font-medium">Email:</span> {{ $customer->email ?? '-' }}
                </p>
            </div>
            <div class="flex-1 min-w-[220px] bg-slate-100 rounded-xl p-4">
                <h3 class="text-sm font-semibold mb-2 text-slate-800 uppercase">Payment Information</h3>
                <p class="text-sm leading-relaxed text-slate-700">
                    <span class="font-medium">Bank:</span> BCA<br>
                    <span class="font-medium">Account Name:</span> Blue Sky Creation<br>
                    <span class="font-medium">Account No:</span> 123-456-7890
                </p>
            </div>
        </div>

        <!-- Table Items -->
        <div class="overflow-hidden rounded-xl border border-slate-200">
            <table class="w-full border-collapse text-sm">
                <thead class="bg-slate-100">
                    <tr class="border-b border-slate-200">
                        <th class="text-left py-3 px-4 w-10">#</th>
                        <th class="text-left py-3 px-4">Description</th>
                        <th class="text-center py-3 px-4 w-20">Qty</th>
                        <th class="text-right py-3 px-4">Unit Price</th>
                        <th class="text-right py-3 px-4">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $subtotal = 0;
                        $total = 0;
                    @endphp
                    @foreach ($quotations as $index => $item)
                        <tr class="border-b border-dashed border-slate-200 hover:bg-slate-50">
                            <td class="py-3 px-4">{{ $index + 1 }}</td>
                            <td class="py-3 px-4 ql-editor">{!! $item->description !!}</td>
                            <td class="py-3 px-4 text-center">{{ $item->qty }}</td>
                            <td class="py-3 px-4 text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            @php
                                $total = $item->qty * $item->price;
                                $subtotal += $total;
                            @endphp
                            <td class="py-3 px-4 text-right">Rp {{ number_format($total, 0, ',', '.') }}</td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Summary -->
        <div class="flex justify-end mt-6">
            <div class="w-80 border border-slate-200 rounded-xl p-5 bg-slate-50">
                <div class="flex justify-between text-sm text-slate-700 py-1">
                    <span>Subtotal</span><span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                </div>
                @if ($quotation->tax > 0)
                    <div class="flex justify-between text-sm text-slate-700 py-1">
                        <span>Tax {{ $quotation->tax }}%</span><span>Rp
                            {{ number_format(($quotation->tax * $subtotal) / 100, 0, ',', '.') }}</span>
                    </div>
                @endif
                <div class="flex justify-between font-semibold text-slate-900 border-t mt-3 pt-3 text-base">
                    <span>Total</span><span>Rp
                        {{ number_format($subtotal + ($quotation->tax * $subtotal) / 100, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Notes & Signature -->
        <div class="flex flex-wrap gap-6 mt-10">
            <div class="flex-1 min-w-[220px] text-sm text-slate-700 leading-relaxed">
                <p class="font-semibold mb-2">Notes:</p>
                <ul class="list-disc list-inside space-y-1 ">
                    <li class="text-xs">Prices exclude any additional out-of-scope charges.</li>
                    <li class="text-xs">Work will commence after receiving a 50% down payment.</li>
                    <li class="text-xs">Estimated project duration: 2–3 weeks.</li>
                </ul>
            </div>
            <div class="w-60 text-center text-sm">
                <p>Approved by,</p>
                <div class="h-14 mt-3 border-b border-dashed border-slate-300"></div>
                <p class="mt-2">(Name & Position)</p>
            </div>
        </div>

        <!-- Footer -->
        <footer class="text-center text-xs text-slate-500 mt-10 border-t border-slate-200 pt-4">
            This quotation is a proposal only. To confirm your order, please contact us at
            <span class="font-medium text-slate-600">+62 877 8062 0632</span> or
            <span class="font-medium text-slate-600">hello@blueskycreation.id</span>
        </footer>
    </div>
</body>

</html>
