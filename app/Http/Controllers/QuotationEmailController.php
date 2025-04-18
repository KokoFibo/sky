<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Customer;
use App\Models\Quotation;
use App\Mail\quotationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\App;
use Barryvdh\DomPDF\Facade\Pdf;

class QuotationEmailController extends Controller
{
    public function index($number)
    {

        $quotations = Quotation::where('number', $number)->get();
        $quotation = Quotation::where('number', $number)->first();
        $customer = Customer::find($quotation->customer_id);

        return view('pdf.quotationpdf', compact(['quotations', 'quotation', 'customer']));
    }

    public function pdf($number)
    {
        $quotations = Quotation::where('number', $number)->get();
        $quotation = Quotation::where('number', $number)->first();
        $customer = Customer::find($quotation->customer_id);

        $data['email'] = 'kokonacci@gmail.com';
        $data['title'] = 'ini adalah title';
        $data['subject'] = 'ini adalah subject';
        $data['body'] = 'ini adalah body atau isi dari emailnya';
        $pdf = Pdf::loadView('pdf.quotationpdftemplate', compact(['quotations', 'quotation', 'customer', 'data']));
        Mail::send('pdf.quotationpdftemplate', $data, function ($message) use ($data, $pdf, $customer) {
            $message->to($data["email"], $data["email"])
                ->subject($data["title"])
                ->attachData($pdf->output(), "text.pdf");
        });
    }

    public function pdf1($number)
    {
        $quotations = Quotation::where('number', $number)->get();
        $quotation = Quotation::where('number', $number)->first();
        $customer = Customer::find($quotation->customer_id);
        // $saveLocation = 'public/storage/pdf/';
        $pdfFileName = 'BlueSkyCreation_' . quoNumberFormat($number, $quotation->quotation_date) . '.pdf';
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

        $data['email'] = 'testaja@testaja.com';
        $data['subject'] = 'ini adalah title atau judulnya';
        $data['body'] = 'ini adalah body atau isi dari emailnya';



        $pdf = Pdf::loadView('pdf.quotationpdftemplate', compact(['quotations', 'quotation', 'customer']));
        // $request->session()->flash('message', 'PDF Generated');
        // return back();
        return $pdf->download('template.pdf');
        // return back()->with('message', 'PDF Generated');
    }


    public function quotationEmail($number)
    {
        // Mail::to('kokonaci@gmail.com')->send(new InvoiceMail($number));
        try {
            Mail::send(new quotationMail($number));
            $data = Quotation::where('number', $number)->get();
            foreach ($data as $d) {

                $d->emailed_at = Carbon::parse(Carbon::now())->format('Y-m-d H:i:s');
                $d->status = 'Emailed';
                $d->save();
            }
            return redirect(route('quotation'))->with('success', 'Email sent');
        } catch (\Exception $e) {
            return $e->getMessage();
            return redirect(route('quotation'))->with('error', 'Fail Sending Email');
        }
    }
}
