<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    {{-- <meta http-equiv="X-UA-Compatible" content="IE=edge"> --}}
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice PDF</title>

    {{-- google fonts poppins --}}
    {{-- <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,600;1,400;1,600&display=swap"
        rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            color: #3e3e3f;

        }

        /* @page {
            size: A4;
            margin: 2cm;
        } */

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            padding: 6px 10px;
        }

        thead tr {
            background-color: #D9EAF7;
            border: 1px solid #999;
        }

        .border-mid {
            border-left: 1px solid #999;
            border-right: 1px solid #999;
        }
    </style>
</head>

<body class="leading-relaxed p-10">
    <div class="w-full mx-auto">


        <div class="flex justify-between items-center ">
            <div>
                <span class="font-semibold ">Invoice No.</span>
                {{ invNumberFormat($invoice->number, $invoice->invoice_date) }}
            </div>
            <img src="https://sky.blueskycreation.id/images/logobsc.png" alt="logobsc" class="w-[150px] inline-block">
        </div>

        <h1 class="text-center text-2xl font-bold mt-4 mb-6">INVOICE</h1>
        <div class="flex justify-between">
            <div class="flex gap-5">
                <div class="font-semibold">
                    <h5>Name</h5>
                    <h5>Company</h5>
                    <h5>Contract No.</h5>
                    <h5>Address</h5>
                </div>
                <div>
                    <h5>{{ $customer->salutation }} {{ $customer->name }}</h5>
                    <h5>{{ $customer->company }}</h5>
                    <h5>{{ $contract_number }}</h5>
                    <h5>{{ $customer->address }}</h5>
                </div>
            </div>
            <div class="flex gap-5">
                <div class="font-semibold">
                    <h5>Invoice Date</h5>
                    <h5>Due Date</h5>
                    <h5>Payment to</h5>
                    <h5></h5>
                </div>
                <div>
                    <h5>{{ tanggal($invoice->invoice_date) }}</h5>
                    <h5>{{ tanggal($invoice->due_date) }}</h5>
                    <h5>Tiffany Mareta</h5>
                    <h5>BCA (Bank Central Asia)</h5>
                    <h5>6600 356 117</h5>
                </div>
            </div>
        </div>



        <div class="mt-5">
            <table class="w-full text-left border border-gray-400">
                <thead>
                    <tr class="bg-[#D9EAF7] border border-gray-400">
                        <th class="w-[55%] text-center px-3 py-2">Item Description</th>
                        <th class="w-[20%] text-center px-3 py-2">Qty</th>
                        <th class="w-[25%] text-center px-3 py-2">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $subtotal = 0;
                    @endphp
                    @foreach ($invoices as $i)
                        <tr class="border-x border-gray-400">
                            <td class="px-3 py-2 border-mid">{{ $i->package }}</td>
                            <td class="text-center border-mid">{{ $i->qty }}
                                {{ $i->qty > 1 ? 'Packages' : 'Package' }}</td>
                            <td class="text-right px-3 py-2 border-mid">IDR {{ number_format($i->qty * $i->price) }}
                            </td>
                            @php
                                $subtotal = $subtotal + $i->qty * $i->price;
                            @endphp
                        </tr>
                    @endforeach

                    <tr class="border-x border-gray-400 h-[300px]">
                        <td class="border-mid"></td>
                        <td class="border-mid"></td>
                        <td class="border-mid"></td>
                    </tr>

                    @if ($invoice->discount != 0)
                        <tr class="border border-gray-400">
                            <td class="px-3 py-2">Discount</td>
                            <td></td>
                            <td class="text-right px-3 py-2 border-l border-gray-400">IDR
                                {{ number_format($invoice->discount) }}</td>
                        </tr>
                    @endif

                    @if ($invoice->tax != 0)
                        <tr class="border border-gray-400">
                            <td class="px-3 py-2">Tax</td>
                            <td></td>
                            <td class="text-right px-3 py-2 border-l border-gray-400">{{ $invoice->tax }} %</td>
                        </tr>
                    @endif

                    <tr class="border border-gray-400 font-semibold">
                        <td class="px-3 py-2">Grand Total</td>
                        <td></td>
                        <td class="text-right px-3 py-2 border-l border-gray-400">
                            IDR {{ number_format(roundedTotal($subtotal, $invoice->discount, $invoice->tax)) }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="flex justify-between mt-5 items-end  ">
            <div class="w-2/3">
                <h5 class="font-semibold text-lg">Terms & Conditions</h5>
                <p class="w-2/3 my-3">
                    Kindly make the transfer before the due date
                    to continue the ongoing project. Proof of
                    payment could be sent via Whatsapp or email
                </p>
                <h5 class="italic font-semibold text-xl"><i>Thank you for your support!</i></h5>
            </div>
            <div>
                <img src="https://sky.blueskycreation.id/images/mich-signs.png" alt=""
                    class="inline-block w-[120px]">
                <h5 class="font-semibold">Michelle Velicia</h5>
                <h5>Blue Sky Creation</h5>
            </div>
        </div>



    </div>
</body>

</html>
