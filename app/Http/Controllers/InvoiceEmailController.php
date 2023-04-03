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



    public function emailinvoice($number)
    {
        $invoices = Invoice::where('number', $number)->get();
        $invoice = Invoice::where('number', $number)->first();
        if ($invoice->status != 'Draft') {
            echo 'This Invoice has already Emailed';
        } else {
            $customer = Customer::find($invoice->customer_id);
            $pdfFileName = 'BlueSkyCreation_' . invNumberFormat($number, $invoice->invoice_date) . '.pdf';
            $mpdf = new \Mpdf\Mpdf();
            ob_get_clean();
            $cs_email = $customer->email;
            $cs_company = $customer->title . ' ' . $customer->company;
            // $data['toEmail'] = $customer->email;
            $data['toEmail'] = 'kokonacci01@gmail.com';
            $data['company'] = $customer->title . ' ' . $customer->company;
            $data['fromEmail'] = 'hello@blueskycreation.id';
            $data['fromCompany'] = 'Blue Sky Creation';
            $data['subject'] = 'Blue Sky Creation Invoice No. ' . invNumberFormat($number, $invoice->invoice_date);
            // $cc = ['cc1@cc1.com', 'cc2@cc2.com'];
            $cc = ['anton.pru@gmail.com'];
            // $data['cc'] = 'kokonacci@gmail.com';
            $data['bcc'] = 'kokonacci@gmail.com';
            $data['body'] = 'ini adalah body atau isi dari emailnya';

            // $data1 = [
            //     'customer' => 'Anton'
            // ];
            $data1 = array('name' => 'Anton');
            // $data1['nama'] = 'Anton';




            $html = view('pdf.invoicepdftemplate', compact(['invoices', 'invoice', 'customer']));
            $mpdf->WriteHTML($html);
            $pdf = $mpdf->Output('', 'S');
            // $data1 = 'Anton Aja';

            Mail::send('pdf.invoiceEmailTemplate2', $data1, function ($message) use ($data, $pdf, $pdfFileName, $cc) {
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
            // echo 'Email is Sent';
            return back()->with('message', 'Invoice Emailed');
        }
    }

    public function kirimemail ($number) {
        // Mail::to('kokonaci@gmail.com')->send(new InvoiceMail($number));
        Mail::send(new InvoiceMail($number));
    }

    public function emailhtml () {
        $data1 = array('name' => 'Anton');
        Mail::send('pdf.invoiceEmailTemplate2', $data1, function ($message) {
            $message
                ->to('kokonacci01@gmail.com')
                ->from('hello@blueskycreation.id')
                ->cc('kokonacci@gmail.com')
                ->bcc('anton.pru@gmail.com')
                ->subject('Subject nya ini');

        });
    }


}

