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
    public function index($number)
    {
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

        return view('pdf.invoicepdf', compact(['invoices', 'invoice', 'customer']));
    }

    public function pdf(Request $request, $number)
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

        // Storage::put('public/storage/pdf/' . $pdfFileName, $mpdf->Output($saveLocation . $pdfFileName, \Mpdf\Output\Destination::DOWNLOAD));
    }

    public function emailinvoice($number)
    {
        $invoices = Invoice::where('number', $number)->get();
        $invoice = Invoice::where('number', $number)->first();
        if ($invoice->status == 'Emaileda') {
            echo 'This Invoice has already Emailed';
        } else {
            $customer = Customer::find($invoice->customer_id);
            $pdfFileName = 'BlueSkyCreation_' . invNumberFormat($number, $invoice->invoice_date) . '.pdf';
            $mpdf = new \Mpdf\Mpdf();
            ob_get_clean();
            $cs_email = $customer->email;
            $cs_company = $customer->title . ' ' . $customer->company;
            $data['toEmail'] = $customer->email;
            $data['company'] = $customer->title . ' ' . $customer->company;
            $data['fromEmail'] = 'hello@blueskycreation.id';
            $data['fromCompany'] = 'Blue Sky Creation';
            $data['subject'] = 'Blue Sky Creation Invoice No. ' . invNumberFormat($number, $invoice->invoice_date);
            $cc = ['cc1@cc1.com', 'cc2@cc2.com'];
            // $data['cc'] = 'cc@cc.com';
            $data['bcc'] = 'bcc@bcc.com';
            $data['body'] = 'ini adalah body atau isi dari emailnya';

            $html = view('pdf.invoicepdftemplate', compact(['invoices', 'invoice', 'customer']));
            $mpdf->WriteHTML($html);
            $pdf = $mpdf->Output('', 'S');

            $is_sent = Mail::send('pdf.invoiceEmailTemplate', $data, function ($message) use ($data, $pdf, $pdfFileName, $cc) {
                $message
                    ->to($data['toEmail'], $data['company'])
                    ->from($data['fromEmail'], $data['fromCompany'])
                    ->cc($cc)
                    ->bcc($data['bcc'])
                    ->subject($data['subject'])
                    ->attachData($pdf, $pdfFileName);
            });

            // foreach ($invoices as $d) {
            //     $d->status = 'Emailed';
            //     $d->save();
            // }
            return back()->with('message', 'Invoice Emailed');
        }
    }
}
