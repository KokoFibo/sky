<?php

namespace App\Http\Controllers;

use Mpdf\Mpdf;
use Carbon\Carbon;
use App\Models\Invoice;
use App\Models\Contract;
use App\Models\Customer;
use App\Mail\InvoiceMail;
use Illuminate\Http\Request;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class InvoiceEmailController extends Controller
{
    public function index($number)
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

        $is_emailed = false;
        if ($invoice->status == "Emailed")  $is_emailed = true;

        return view('pdf.invoicepdf', [
            'invoices' => $invoices,
            'invoice' => $invoice,
            'customer' => $customer,
            'contract_number' => $contract_number,
            'is_emailed' => $is_emailed,
        ]);
    }



    public function pdf($number, $signature)
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
        // $saveLocation = 'public/storage/pdf/';
        $pdfFileName = 'BlueSkyCreation_' . invNumberFormat($number, $invoice->invoice_date) . '.pdf';

        if ($signature == "signature") {

            $template =  view('pdf.invoicepdftemplate', compact(['invoices', 'invoice', 'customer', 'contract_number']))->render();
        } else {
            $template =  view('pdf.invoicepdftemplateNoSignature', compact(['invoices', 'invoice', 'customer', 'contract_number']))->render();
        }

        $footerHtml = view('pdf.footer')->render();

        $pdf = Browsershot::html($template)
            ->setNodeBinary('/usr/bin/node')
            ->setChromePath('/usr/bin/google-chrome')
            ->setEnvironmentOptions([
                'HOME' => '/tmp',
                'XDG_CONFIG_HOME' => '/tmp',
                'XDG_CACHE_HOME' => '/tmp',
            ])
            ->addChromiumArguments([
                '--disable-crash-reporter',
            ])
            ->showBackground()
            ->noSandbox()
            ->showBrowserHeaderAndFooter()
            ->footerHtml($footerHtml)
            ->format('A4')
            ->pdf(); // hasil binary

        // Kirim langsung ke browser untuk di-download
        return response($pdf)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="' . $pdfFileName . '"');

        return back()->with('message', 'PDF Generated');
    }


    public function pdf1($number)
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
        $footer = '<table style="width: 100%">
        <tr>
            <td style="width: 33%; text-align:left ;  ">
                <img src="https://sky.blueskycreation.id/web.png" width="30px" style="width: 15px;">
                www.blueskycreation.id
            </td>
            <td style="width: 33%; text-align:center"><img src="https://sky.blueskycreation.id/whatsapp.png"
                    width="30px" style="width: 15px;"> 087 780 620 632</td>
            <td style="width: 33%; text-align:right"><img src="https://sky.blueskycreation.id/email.png"
                    width="30px" style="width: 15px;"> hello@blueskycreation.id</td>
        </tr>
    </table>';

        $mpdf = new \Mpdf\Mpdf();
        $mpdf->SetFooter($footer);

        ob_get_clean();
        $data['email'] = 'testaja@testaja.com';
        $data['subject'] = 'ini adalah title atau judulnya';
        $data['body'] = 'ini adalah body atau isi dari emailnya';

        $html = view('pdf.invoicepdftemplate', compact(['invoices', 'invoice', 'customer', 'contract_number']));
        $mpdf->WriteHTML($html);

        $mpdf->Output($pdfFileName, \Mpdf\Output\Destination::DOWNLOAD);
        // $request->session()->flash('message', 'PDF Generated');
        // return back();
        return back()->with('message', 'PDF Generated');
    }

    public function invoiceEmail($number)
    {
        // Mail::to('kokonaci@gmail.com')->send(new InvoiceMail($number));
        try {
            Mail::send(new InvoiceMail($number));
            $data = Invoice::where('number', $number)->get();
            foreach ($data as $d) {

                $d->emailed_at = Carbon::parse(Carbon::now())->format('Y-m-d H:i:s');
                $d->status = 'Emailed';
                $d->save();
            }
            return redirect(route('invoice'))->with('success', 'Email sent');
        } catch (\Exception $e) {
            // dd('ada kesalahan email');
            return $e->getMessage();
            // return redirect(route('invoice'))->with('error', 'Fail Sending Email');
        }
    }
}
