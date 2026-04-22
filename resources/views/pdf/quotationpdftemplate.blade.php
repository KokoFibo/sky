<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Quotation PDF</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .page-break {
            page-break-after: always;
        }

        footer {
            position: fixed;
            bottom: -40px;
            left: 0;
            right: 0;
            text-align: center;
            line-height: 35px;
        }

        .ql-editor ol li[data-list="ordered"] {
            list-style-type: decimal !important;
        }

        .ql-editor ol li[data-list="bullet"] {
            list-style-type: disc !important;
        }

        .ql-editor ul li,
        .ql-editor ol li {
            list-style-position: outside;
            margin-left: 1.5rem;
            margin-bottom: 6px;
            line-height: 1.6;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        table th,
        table td {
            /* border: 1px solid #999; */
            vertical-align: top;
        }

        hr {
            border: none;
            border-top: 1px solid #999;
            margin: 4px 0;
        }

        .section-title {
            background-color: #D9EAF7;
            text-align: center;
            padding: 8px;
            letter-spacing: 4px;
            font-weight: 700;
            font-size: 16px;
        }

        .sub-title {
            display: block;
            font-weight: 400;
            font-size: 14px;
            letter-spacing: normal;
        }
    </style>
</head>

<body class="text-gray-800 bg-white p-8 w-[21cm] mx-auto">

    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-5xl font-bold">QUOTATION</h1>
            <h3 class="text-sm font-medium tracking-wide">DETAILED OF PROVIDED SERVICES</h3>
        </div>
        <img src="https://sky.blueskycreation.id/images/logobsc.png" alt="Blue Sky Creation Logo" class="w-44">
    </div>

    <!-- Created Info -->
    <div class="grid grid-cols-2 gap-4 text-[15px] font-semibold">
        <div>Created for</div>
        <div>Created on</div>
        <div class="col-span-2 border-b border-gray-400 my-1"></div>
    </div>

    <div class="grid grid-cols-2 gap-4 text-[15px] mt-2">
        <div>
            <div class="flex">
                <span class="font-semibold w-24">Name</span>
                <span>{{ $customer->salutation }} {{ $customer->name }}</span>
            </div>
            <div class="flex">
                <span class="font-semibold w-24">Company</span>
                <span>{{ $customer->company }}</span>
            </div>
        </div>
        <div>
            <div class="flex">
                <span class="font-semibold w-24">Date</span>
                <span>{{ tanggal_with_hari($quotation->quotation_date) }}</span>
            </div>
            <div class="flex">
                <span class="font-semibold w-24">Number</span>
                <span>{{ quoNumberFormat($quotation->number, $quotation->quotation_date) }}</span>
            </div>
        </div>
    </div>

    <!-- PROVIDED SERVICES -->
    <table class="mt-8 text-[14px] border border-gray-400">
        <thead>
            <tr>
                <th colspan="3"
                    class="bg-[#D9EAF7] text-center py-3 text-[15px] tracking-[3px] font-semibold text-gray-800 ">
                    PROVIDED SERVICES
                </th>
            </tr>
            <tr class="bg-gray-50 text-gray-700">
                <th class="text-left py-2 px-4 w-[55%] font-semibold border border-gray-400">Item Description</th>
                <th class="text-center py-2 px-4 w-[20%] font-semibold border border-gray-400">Quantity</th>
                <th class="text-right py-2 px-4 w-[25%] font-semibold border border-gray-400">Total</th>
            </tr>
        </thead>
        <tbody>
            @php
                $grandTotal = 0;
                $total = 0;
                $tax = 0;
                $discount = 0;
            @endphp

            @foreach ($quotations as $q)
                <tr>
                    <td class="py-2 px-4 align-top border border-gray-400">
                        <div class="font-semibold text-gray-800">{{ $q->package }}</div>
                        <div class="text-gray-600 text-[13px] mt-1 ql-editor">{!! $q->description !!}</div>
                    </td>
                    <td class="text-center py-2 px-4 align-top border border-gray-400">1 Package</td>
                    <td class="text-right py-2 px-4 align-top border border-gray-400">IDR {{ number_format($q->price) }}
                    </td>
                </tr>
                @php
                    $total += $q->price;
                    $discount = $q->discount;
                    $tax = $q->tax;
                @endphp
            @endforeach

            @if ($tax != 0 || $discount != 0)
                <tr>
                    <td colspan="2" class="py-2 px-4 font-bold">Total</td>
                    <td class="py-2 px-4 text-right font-bold">IDR {{ number_format($total) }}</td>
                </tr>
            @endif

            @if ($discount != 0)
                <tr>
                    <td colspan="2" class="py-2 px-4 font-bold">Discount</td>
                    <td class="py-2 px-4 text-right font-bold">IDR {{ number_format($discount) }}</td>
                </tr>
            @endif

            @if ($tax != 0)
                <tr>
                    <td colspan="2" class="py-2 px-4 font-bold">Tax</td>
                    <td class="py-2 px-4 text-right font-bold">{{ $tax }} %</td>
                </tr>
            @endif

            @php
                $grandTotal = (($total - $discount) / (100 - $tax)) * 100;
            @endphp
            <tr class="font-bold bg-gray-50">
                <td colspan="2" class="py-2 px-4">Grand Total</td>
                <td class="py-2 px-4 text-right">IDR {{ number_format(roundedThousand($grandTotal)) }}</td>
            </tr>
        </tbody>
    </table>

    <div class="page-break"></div>
    <br>
    <br>
    <!-- WORK PROCESS: SOCIAL MEDIA PACKAGE -->
    <table class="w-full text-[13.5px] border border-gray-400 leading-tight">
        <tr>
            <td colspan="2" class="border border-gray-400 bg-[#D9EAF7] text-center leading-6 py-1">
                <span class="tracking-[5px] font-bold text-[17px]">WORK PROCESS</span><br>
                <span class="font-light text-[15px]">SOCIAL MEDIA PACKAGE</span>
            </td>
        </tr>
        <tr>
            <td class="py-2 px-2"><b>Step 1 :</b> Contract</td>
            <td class="py-2 px-2"><b>Step 4 :</b> Design and Development</td>
        </tr>
        <tr>
            <td class="px-2 py-[2px]">Where the client has determined the desired</td>
            <td class="px-2 py-[2px]">Our team will create the plan, strategies,</td>
        </tr>
        <tr>
            <td class="px-2 py-[2px]">package and signed the contract</td>
            <td class="px-2 py-[2px]">designs, and copy write of the project</td>
        </tr>
        <tr>
            <td class="px-2 py-[2px]">
                <hr>
            </td>
            <td class="px-2 py-[2px]">
                <hr>
            </td>
        </tr>
        <tr>
            <td class="px-2 py-[2px]"><b>Step 2 :</b> Advance Payment</td>
            <td class="px-2 py-[2px]"><b>Step 5 :</b> Execution</td>
        </tr>
        <tr>
            <td class="px-2 py-[2px]">Due to the nature of the services, we need</td>
            <td class="px-2 py-[2px]">Where the plan is put into action by our team</td>
        </tr>
        <tr>
            <td class="px-2 py-[2px]">full advance payment to start the project</td>
            <td class="px-2 py-[2px]">for your brand’s social media account</td>
        </tr>
        <tr>
            <td class="px-2 py-[2px]">
                <hr>
            </td>
            <td class="px-2 py-[2px]">
                <hr>
            </td>
        </tr>
        <tr>
            <td class="px-2 py-[2px]"><b>Step 3 :</b> Visual Concept</td>
            <td class="px-2 py-[2px]"><b>Step 6 :</b> Report</td>
        </tr>
        <tr>
            <td class="px-2 py-[2px]">Setting up the visual concept of your brand’s</td>
            <td class="px-2 py-[2px]">The report & evaluation of the project will be</td>
        </tr>
        <tr>
            <td class="px-2 py-[5px]">social media as a guideline for the project</td>
            <td class="px-2 py-[5px]">released at the end of every month</td>
        </tr>
    </table>

    <br>

    <!-- WORK PROCESS: PER PROJECT -->
    <table class="w-full text-[13.5px] border border-gray-400 leading-tight">
        <tr>
            <td colspan="2" class=" border-b border-gray-400 bg-[#D9EAF7] text-center leading-6 py-1">
                <span class="tracking-[5px] font-bold text-[17px]">WORK PROCESS</span><br>
                <span class="font-light text-[15px]">PER PROJECT</span>
            </td>
        </tr>
        <tr>
            <td class="py-2 px-2"><b>Step 1 :</b> Initiation</td>
            <td class="py-2 px-2"><b>Step 4 :</b> Brief</td>
        </tr>
        <tr>
            <td class="px-2 py-[2px]">Where client defines and interpret the</td>
            <td class="px-2 py-[2px]">A description of key elements and detailed</td>
        </tr>
        <tr>
            <td class="px-2 py-[2px]">details of the request</td>
            <td class="px-2 py-[2px]">requirements of the project</td>
        </tr>
        <tr>
            <td class="px-2 py-[2px]">
                <hr>
            </td>
            <td class="px-2 py-[2px]">
                <hr>
            </td>
        </tr>
        <tr>
            <td class="px-2 py-[2px]"><b>Step 2 :</b> Quotation</td>
            <td class="px-2 py-[2px]"><b>Step 5 :</b> Execution</td>
        </tr>
        <tr>
            <td class="px-2 py-[2px]">Our team will send you the estimation</td>
            <td class="px-2 py-[2px]">Where the brief and the plan are put</td>
        </tr>
        <tr>
            <td class="px-2 py-[2px]">of your requested project</td>
            <td class="px-2 py-[2px]">into action by our Team</td>
        </tr>
        <tr>
            <td class="px-2 py-[2px]">
                <hr>
            </td>
            <td class="px-2 py-[2px]">
                <hr>
            </td>
        </tr>
        <tr>
            <td class="px-2 py-[2px]"><b>Step 3 :</b> Advance Payment</td>
            <td class="px-2 py-[2px]"><b>Step 6 :</b> Completion</td>
        </tr>
        <tr>
            <td class="px-2 py-[2px]">Due to the nature of the services, we need</td>
            <td class="px-2 py-[2px]">Where we release the final deliverables</td>
        </tr>
        <tr>
            <td class="px-2 py-[5px]">full advance payment to start the project</td>
            <td class="px-2 py-[5px]">of the project to the client</td>
        </tr>
    </table>

    <br>

    <!-- TERMS AND CONDITIONS -->
    <table class="w-full text-[13.5px] border border-gray-400 leading-tight">
        <tr>
            <td colspan="2" class=" border border-gray-400 bg-[#D9EAF7] text-center leading-[3.2] py-1">
                <span class="tracking-[5px] font-bold text-[17px]">TERMS AND CONDITIONS</span>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="py-2 px-2"><b>Revisions</b></td>
        </tr>
        <tr>
            <td colspan="2" class="px-2">The services include 1x major revision and 2x
                minor revisions. No photo/video shoot revisions
            </td>
        </tr>
        <tr>
            <td colspan="2" class="px-2 py-[2px]">
                <hr>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="py-1 px-2"><b>Monthly Services</b></td>
        </tr>
        <tr>
            <td colspan="2" class="px-2">The services of our social media packages are
                provided per month & cannot be accumulated.
            </td>
        </tr>
        <tr>
            <td colspan="2" class="px-2 py-[2px]">
                <hr>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="py-1 px-2"><b>Contract Period</b></td>
        </tr>
        <tr>
            <td colspan="2" class="px-2 pb-2">Our social media packages come with a minimum
                of 3 months contract.
            </td>
        </tr>
    </table>


</body>

</html>
