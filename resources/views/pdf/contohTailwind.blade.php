<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Quotation - {{ $customer->name ?? 'Customer' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Ordered list */
        .ql-editor ol li[data-list="ordered"] {
            list-style-type: decimal !important;
            margin-left: 1.5rem;
        }

        /* Unordered list */
        .ql-editor ol li[data-list="bullet"] {
            list-style-type: disc !important;
            margin-left: 1.5rem;
        }
    </style>
</head>

{{-- <body class="font-sans text-gray-800 bg-white p-8"> --}}

<body class=" text-gray-800 bg-white p-8 w-[21cm]">
    <!-- Header -->
    <header class="flex justify-between items-center border-b pb-4 mb-8">
        <div class="flex items-center gap-4">
            {{-- <img src="{{ asset('images/Blue Sky Creations.png') }}" alt="Logo" class="h-16"> --}}
            <div>
                <h1 class="text-2xl font-bold uppercase text-blue-800">Blue Sky Creation</h1>
                <p class="text-sm text-gray-600">Creative Digital Agency</p>
            </div>
        </div>
        <div class="text-right">
            <p class="text-sm">Jl. Contoh No. 12, Jakarta</p>
            <p class="text-sm">hello@blueskycreation.id</p>
            <p class="text-sm">087 780 620 632</p>
        </div>
    </header>

    <!-- Quotation Info -->
    <section class="mb-8">
        <div class="flex justify-between items-start">
            <div>
                <h2 class="text-lg font-semibold mb-1">To:</h2>
                <p class="font-medium">{{ $customer->name ?? '-' }}</p>
                <p class="text-sm">{{ $customer->company ?? '-' }}</p>
                <p class="text-sm">{{ $customer->email ?? '-' }}</p>
            </div>
            <div class="text-right">
                <h2 class="text-lg font-semibold mb-1 text-blue-800">Quotation</h2>
                <p><span class="font-medium">Number:</span>
                    {{ quoNumberFormat($quotation->number ?? 0, $quotation->quotation_date ?? now()) }}</p>
                <p><span class="font-medium">Date:</span>
                    {{ \Carbon\Carbon::parse($quotation->quotation_date)->format('d M Y') }}</p>
                <p><span class="font-medium">Valid Until:</span>
                    {{ \Carbon\Carbon::parse($quotation->valid_until)->format('d M Y') }}</p>
            </div>
        </div>
    </section>

    <!-- Table -->
    <section class="mb-8">
        <table class="w-full border border-gray-300 border-collapse text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border border-gray-300 px-3 py-2 text-left">No</th>
                    <th class="border border-gray-300 px-3 py-2 text-left">Description</th>
                    <th class="border border-gray-300 px-3 py-2 text-right">Qty</th>
                    <th class="border border-gray-300 px-3 py-2 text-right">Unit Price</th>
                    <th class="border border-gray-300 px-3 py-2 text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($quotations as $index => $item)
                    <tr class="odd:bg-white even:bg-gray-50">
                        <td class="border border-gray-300 px-3 py-2">{{ $index + 1 }}</td>
                        <td class="border border-gray-300 px-3 py-2 ql-editor">{!! $item->description !!}</td>
                        <td class="border border-gray-300 px-3 py-2 text-right">{{ $item->qty }}</td>
                        <td class="border border-gray-300 px-3 py-2 text-right">
                            {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td class="border border-gray-300 px-3 py-2 text-right">
                            {{ number_format($item->total, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="bg-gray-100 font-semibold">
                    <td colspan="4" class="border border-gray-300 px-3 py-2 text-right">Subtotal</td>
                    <td class="border border-gray-300 px-3 py-2 text-right">
                        {{ number_format($quotation->subtotal, 0, ',', '.') }}</td>
                </tr>
                @if ($quotation->discount > 0)
                    <tr class="bg-gray-50">
                        <td colspan="4" class="border border-gray-300 px-3 py-2 text-right">Discount</td>
                        <td class="border border-gray-300 px-3 py-2 text-right">
                            -{{ number_format($quotation->discount, 0, ',', '.') }}</td>
                    </tr>
                @endif
                <tr class="bg-blue-50 font-bold text-blue-900">
                    <td colspan="4" class="border border-gray-300 px-3 py-2 text-right">Grand Total</td>
                    <td class="border border-gray-300 px-3 py-2 text-right">
                        {{ number_format($quotation->grand_total, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
    </section>

    <!-- Notes -->
    <section class="mb-12">
        <h3 class="font-semibold mb-1">Notes:</h3>
        <p class="text-sm text-gray-700 leading-relaxed">
            {{ $quotation->notes ?? 'Thank you for considering our services.' }}</p>
    </section>

    <!-- Footer -->
    <footer class="border-t pt-4 text-sm text-gray-600 flex justify-between">
        <p>&copy; {{ date('Y') }} Blue Sky Creation</p>
        <div class="flex items-center gap-4">
            <span class="flex items-center gap-1"><img src="https://sky.blueskycreation.id/web.png" class="h-3">
                blueskycreation.id</span>
            <span class="flex items-center gap-1"><img src="https://sky.blueskycreation.id/whatsapp.png" class="h-3">
                087 780 620 632</span>
            <span class="flex items-center gap-1"><img src="https://sky.blueskycreation.id/email.png" class="h-3">
                hello@blueskycreation.id</span>
        </div>
    </footer>
</body>

</html>
