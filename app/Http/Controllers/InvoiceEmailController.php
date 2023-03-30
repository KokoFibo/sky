<?php

namespace App\Http\Controllers;

use Mpdf\Mpdf;
use App\Models\Invoice;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class InvoiceEmailController extends Controller
{
   public function index ($number) {

    $invoices = Invoice::where('number', $number)->get();
    $invoice = Invoice::where('number', $number)->first();
    $customer = Customer::find($invoice->customer_id);
    // $mpdf->autoScriptToLang = true;
    // $mpdf-> autoLangToFont = true;
    // $mpdf = new \Mpdf\Mpdf();
    // ob_get_clean();
    // $html =  view ('pdf.invoicepdftemplate', compact(['invoices', 'invoice', 'customer']));
    // $html =  view ('invoicepdftemplate');

    // $mpdf->WriteHTML($html);
    // $mpdf->Output('invoice.pdf', \Mpdf\Output\Destination::DOWNLOAD);

    return view ('pdf.invoicepdf', compact(['invoices', 'invoice', 'customer']));
   }

   public function pdf ($number) {
    $invoices = Invoice::where('number', $number)->get();
    $invoice = Invoice::where('number', $number)->first();
    $customer = Customer::find($invoice->customer_id);
    $saveLocation = "public/storage/pdf/";
    $pdfFileName = "BlueSkyCreation_".invNumberFormat($number, $invoice->invoice_date).'.pdf';
    // $mpdf->autoScriptToLang = true;
    // $mpdf-> autoLangToFont = true;
    $mpdf = new \Mpdf\Mpdf();
    ob_get_clean();
    // $html =  view ('invoicepdftemplate');
    $data['email'] = 'testaja@testaja.com';
    $data['subject'] = 'ini adalah title atau judulnya';
    $data['body'] = 'ini adalah body atau isi dari emailnya';

    $html =  view ('pdf.invoicepdftemplate', compact(['invoices', 'invoice', 'customer']));
    $mpdf->WriteHTML($html);
    // $mpdf->Output($saveLocation . $pdfFileName, \Mpdf\Output\Destination::DOWNLOAD);
    Storage::put('public/storage/pdf/'.$pdfFileName, $mpdf->Output($saveLocation . $pdfFileName, \Mpdf\Output\Destination::DOWNLOAD));

   }

   public function emailinvoice ($number) {
    $invoices = Invoice::where('number', $number)->get();
    $invoice = Invoice::where('number', $number)->first();
    $customer = Customer::find($invoice->customer_id);
    $saveLocation = "public/storage/pdf/";
    $pdfFileName = "BlueSkyCreation_".invNumberFormat($number, $invoice->invoice_date).'.pdf';
    // $mpdf->autoScriptToLang = true;
    // $mpdf-> autoLangToFont = true;
    $mpdf = new \Mpdf\Mpdf();
    ob_get_clean();
    // $html =  view ('invoicepdftemplate');
    $data['email'] = 'testaja@testaja.com';
    $data['subject'] = 'ini adalah title atau judulnya';
    $data['body'] = 'ini adalah body atau isi dari emailnya';

    $html =  view ('pdf.invoicepdftemplate', compact(['invoices', 'invoice', 'customer']));
    $mpdf->WriteHTML($html);
    // $mpdf->Output($saveLocation . $pdfFileName, \Mpdf\Output\Destination::DOWNLOAD);
    $pdf =  $mpdf->Output("", "S");

    //  $mpdf->Output('', 'S');
    Mail::send('pdf.test', $data, function($message)use($data, $html){
        $message->to($data['email'])
            ->subject($data['subject'])
            ->attachData('$pdf', 'invoice.pdf');
    });
    dd('data send succesfully');
   }
}
