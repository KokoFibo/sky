<?php

namespace App\Http\Controllers;

use Mpdf\Mpdf;
use App\Models\Invoice;
use App\Models\Customer;
use App\Mail\InvoiceMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class InvoiceEmailController extends Controller
{
    public function index($number)
    {
        $invoices = Invoice::where('number', $number)->get();
        $invoice = Invoice::where('number', $number)->first();
        $customer = Customer::find($invoice->customer_id);

        return view('pdf.invoicepdf', compact(['invoices', 'invoice', 'customer']));
    }

    public function pdf($number)
    {
        $invoices = Invoice::where('number', $number)->get();
        $invoice = Invoice::where('number', $number)->first();
        $customer = Customer::find($invoice->customer_id);
        $saveLocation = 'public/storage/pdf/';
        $pdfFileName = 'BlueSkyCreation_' . invNumberFormat($number, $invoice->invoice_date) . '.pdf';

        $mpdf = new \Mpdf\Mpdf();
        ob_get_clean();
        $data['email'] = 'testaja@testaja.com';
        $data['subject'] = 'ini adalah title atau judulnya';
        $data['body'] = 'ini adalah body atau isi dari emailnya';

        $html = view('pdf.invoicepdftemplate', compact(['invoices', 'invoice', 'customer']));
        $mpdf->WriteHTML($html);

        $mpdf->Output($pdfFileName,\Mpdf\Output\Destination::DOWNLOAD);
        // $request->session()->flash('message', 'PDF Generated');
        // return back();
        return back()->with('message' , 'PDF Generated');
    }





    public function kirimemail ($number) {
        // Mail::to('kokonaci@gmail.com')->send(new InvoiceMail($number));
        Mail::send(new InvoiceMail($number));
    }




}

