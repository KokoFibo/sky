<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Contract;
use App\Models\Customer;
use Illuminate\Http\Request;
use Spatie\Browsershot\Browsershot;

class ShowPdfController extends Controller
{
    public function showPdfTemplate($number)
    {
        $invoices = Invoice::where('number', $number)->get();
        $invoice = Invoice::where('number', $number)->first();
        $customer = Customer::find($invoice->customer_id);
        $contract = Contract::where('contract_number', $invoice->contract)->first();
        if ($contract != '') {
            $contract_number = contractNumberFormat($contract->contract_number, $contract->contract_date);
        } else {
            $contract_number = '-';
        }
        $saveLocation = 'public/storage/pdf/';
        $pdfFileName = 'BlueSkyCreation_' . invNumberFormat($number, $invoice->invoice_date) . '.pdf';


        $template =  view('pdf.invoicepdftemplate', compact(['invoices', 'invoice', 'customer', 'contract_number']))->render();
        $footerHtml = view('pdf.footer')->render();

        // $pdf = Browsershot::html($template)
        //     ->showBackground()
        //     ->noSandbox()
        //     ->showBrowserHeaderAndFooter()
        //     ->footerHtml($footerHtml)
        //     ->format('A4')
        //     ->pdf(); // hasil binary

        // Kirim langsung ke browser untuk di-download
        // return response($pdf)
        //     ->header('Content-Type', 'application/pdf')
        //     ->header('Content-Disposition', 'attachment; filename="' . $pdfFileName . '"');

        // return view('pdf.invoicepdftemplate', compact(['invoices', 'invoice', 'customer', 'contract_number']));
        return view('pdf.footer');
    }
}
