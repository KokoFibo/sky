<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quotation - Blue Sky Creation</title>

    <!-- Google Fonts - Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'poppins': ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        'accent': '#D9EAF7',
                    },
                    margin: {
                        'print': '2cm',
                    }
                }
            }
        }
    </script>

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


    <style type="text/tailwindcss">
        @page {
            size: A4 portrait;
            margin: 2cm;
        }

        body {
            font-family: 'Poppins', sans-serif;
        }

        @media print {
            .print-break-before {
                break-before: page;
            }

            .print-break-inside-avoid {
                break-inside: avoid;
            }
        }
    </style>
</head>

<body class="bg-white text-black p-5">
    <!-- HEADER -->
    <div class="flex items-start justify-between mb-8">
        <div class="flex items-center gap-5">
            <div>
                {{-- <img src="{{ asset('images/logobsc.png ') }}" alt="Blue Sky Creation Logo" class="h-16"> --}}
            </div>
            <div class="text-right">
                <h1 class="text-3xl font-bold uppercase">Blue Sky Creation</h1>
            </div>
        </div>
        <div>
            <h5>087812341234</h5>
            <h5>hello@blueskycreation.id</h5>
            <h5>www.blueskycreation.id</h5>
        </div>
    </div>

    <div class="flex  items-center mb-3 mt-3 ">
        <div class="bg-yellow-500 text-gray-800 rounded-lg w-1/3">
            <div class="w-full p-3 text-left">
                <p class="font-bold">Prepared for:</p>
                <p>{{ $customer->salutation }} {{ $customer->name }}</p>
                <p>{{ $customer->title }}</p>
                <p>{{ $customer->company }}</p>
                <p>{{ $customer->email }}</p>
            </div>
        </div>
        <div class="font-extrabold text-7xl text-blue-800 w-2/3 text-center">
            <h1>QUOTATION</h1>
        </div>
    </div>

    <!-- CLIENT INFO -->
    <div class="flex gap-5 mb-3 mt-3">
        <div class="bg-blue-200 text-gray-800 rounded-lg w-1/3 p-3 text-left">
            <p class="font-bold">Quote Number:</p>
            <p>{{ $quotation->number }}</p>
        </div>
        <div class="bg-blue-200 text-gray-800 rounded-lg w-1/3 p-3 text-left">
            <p class="font-bold">Quote Date:</p>
            <p>{{ formatDate($quotation->quotation_date) }}</p>
        </div>
        <div class="bg-blue-200 text-gray-800 rounded-lg w-1/3 p-3 text-left">
            <p class="font-bold">Valid Until:</p>
            <p>{{ formatDate(addDays($quotation->quotation_date, 30)) }}</p>
        </div>
    </div>



    <!-- QUOTATION TABLE -->
    <div class="mb-8">
        <table class="w-full">
            <thead>
                <tr class="bg-accent">
                    <th class="p-3 text-left font-bold">No</th>
                    <th class="p-3 text-left font-bold">Description</th>
                    <th class="p-3 text-left font-bold">Quantity</th>
                    <th class="p-3 text-left font-bold">Unit Price</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $subtotal = 0;

                @endphp
                @foreach ($quotations as $key => $q)
                    <tr class="border-b border-gray-200">
                        <td class="p-3">{{ $key + 1 }}</td>
                        <td class="p-3 ql-editor">{!! $q->description !!}</td>
                        <td class="p-3">{{ $q->qty }}</td>
                        <td class="p-3">{{ number_format($q->price) }}</td>
                    </tr>
                    @php
                        $subtotal += $q->price;
                    @endphp
                @endforeach

            </tbody>
        </table>

        <div class="mt-6 flex justify-end">
            <div class="w-1/3">
                <div class="flex justify-between py-2">
                    <span>Subtotal:</span>
                    <span>{{ number_format($subtotal) }}</span>
                </div>
                @php
                    $tax = 0;
                @endphp
                @if ($q->tax == '')
                    <div class="flex justify-between py-2">
                        <span>Tax (optional):</span>
                        <span>[Tax Amount]</span>
                    </div>
                @else
                    @php
                        $tax = ($q->tax * $subtotal) / 100;
                    @endphp
                    <div class="flex justify-between py-2">
                        <span>Tax ({{ $q->tax }}):</span>
                        <span>{{ number_format($tax) }}</span>
                    </div>
                @endif

                <div class="border-t border-gray-400 pt-2 mt-2">
                    <div class="flex justify-between py-2 font-bold text-lg">
                        <span>Grand Total:</span>
                        <span>{{ number_format($subtotal + $tax) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <div class="mt-auto">
        <div class="border-t border-accent pt-4">
            <p class="text-center text-sm text-gray-600">
                Blue Sky Creation | Contact: +62-xxx-xxxx | Email: hello@blueskycreation.id
            </p>
            <p class="text-center text-sm text-gray-600">
                Instagram: @blueskycreation | Website: https://blueskycreation.id
            </p>
        </div>
    </div>

    <!-- WORK PROCESS PAGE -->
    <div class="print-break-before">
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-center mb-6">WORK PROCESS</h2>
            <h3 class="text-xl font-bold text-center mb-6">SOCIAL MEDIA PACKAGE</h3>

            <div class="grid grid-cols-2 gap-6 mb-8">
                <div class="p-4 bg-accent bg-opacity-30 rounded">
                    <p class="font-semibold">Step 1 : Contract</p>
                    <p class="text-sm">Where the client has determined the desired package and signed the contract</p>
                </div>
                <div class="p-4 bg-accent bg-opacity-30 rounded">
                    <p class="font-semibold">Step 4 : Design and Development</p>
                    <p class="text-sm">Our team will create the plan, strategies, designs, and copy write of the
                        project</p>
                </div>
                <div class="p-4 bg-accent bg-opacity-30 rounded">
                    <p class="font-semibold">Step 2 : Advance Payment</p>
                    <p class="text-sm">Due to the nature of the services, we need full advance payment to start the
                        project</p>
                </div>
                <div class="p-4 bg-accent bg-opacity-30 rounded">
                    <p class="font-semibold">Step 5 : Execution</p>
                    <p class="text-sm">Where the plan is put into action by our team for your brand's social media
                        account</p>
                </div>
                <div class="p-4 bg-accent bg-opacity-30 rounded">
                    <p class="font-semibold">Step 3 : Visual Concept</p>
                    <p class="text-sm">Setting up the visual concept of your brand's social media as a guideline for
                        the project</p>
                </div>
                <div class="p-4 bg-accent bg-opacity-30 rounded">
                    <p class="font-semibold">Step 6 : Report</p>
                    <p class="text-sm">The report & evaluation of the project will be released at the end of every
                        month</p>
                </div>
            </div>

            <h3 class="text-xl font-bold text-center mb-6">WORK PROCESS - PER PROJECT</h3>

            <div class="grid grid-cols-2 gap-6 mb-8">
                <div class="p-4 bg-accent bg-opacity-30 rounded">
                    <p class="font-semibold">Step 1 : Initiation</p>
                    <p class="text-sm">Where client defines and interpret the details of the request</p>
                </div>
                <div class="p-4 bg-accent bg-opacity-30 rounded">
                    <p class="font-semibold">Step 4 : Brief</p>
                    <p class="text-sm">A description of key elements and detailed requirements of the project</p>
                </div>
                <div class="p-4 bg-accent bg-opacity-30 rounded">
                    <p class="font-semibold">Step 2 : Quotation</p>
                    <p class="text-sm">Our team will send you the estimation of your requested project</p>
                </div>
                <div class="p-4 bg-accent bg-opacity-30 rounded">
                    <p class="font-semibold">Step 5 : Execution</p>
                    <p class="text-sm">Where the brief and the plan are put into action by our Team</p>
                </div>
                <div class="p-4 bg-accent bg-opacity-30 rounded">
                    <p class="font-semibold">Step 3 : Advance Payment</p>
                    <p class="text-sm">Due to the nature of the services, we need full advance payment to start the
                        project</p>
                </div>
                <div class="p-4 bg-accent bg-opacity-30 rounded">
                    <p class="font-semibold">Step 6 : Completion</p>
                    <p class="text-sm">Where we release the final deliverables of the project to the client</p>
                </div>
            </div>

            <h3 class="text-xl font-bold text-center mb-6">TERMS AND CONDITIONS</h3>

            <div class="space-y-4">
                <div class="p-4 bg-accent bg-opacity-30 rounded print-break-inside-avoid">
                    <p class="font-semibold">Revisions</p>
                    <p class="text-sm">The services include 1x major revision and 2x minor revisions. No photo/video
                        shoot revisions</p>
                </div>
                <div class="p-4 bg-accent bg-opacity-30 rounded print-break-inside-avoid">
                    <p class="font-semibold">Monthly Services</p>
                    <p class="text-sm">The services of our social media packages are provided per month & cannot be
                        accumulated.</p>
                </div>
                <div class="p-4 bg-accent bg-opacity-30 rounded print-break-inside-avoid">
                    <p class="font-semibold">Contract Period</p>
                    <p class="text-sm">Our social media packages comes with a minimum of 3 months contract.</p>
                </div>
            </div>
        </div>

        <!-- FOOTER -->
        <div class="mt-auto">
            <div class="border-t border-accent pt-4">
                <p class="text-center text-sm text-gray-600">
                    Blue Sky Creation | Contact: +62-xxx-xxxx | Email: hello@blueskycreation.id
                </p>
                <p class="text-center text-sm text-gray-600">
                    Instagram: @blueskycreation | Website: https://blueskycreation.id
                </p>
            </div>
        </div>
    </div>
</body>


</html>
