<?php

namespace App\Mail;

use App\Models\Invoice;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Contracts\Queue\ShouldQueue;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $number;

    public function __construct($number)
    {
        $this->number = $number;
        // ini kah
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $invoice = Invoice::where('number', $this->number)->first();
        $customer = Customer::where('id', $invoice->customer_id)->first();
        $invoice_number = invNumberFormat($this->number, $invoice->invoice_date);
        // $month = month($invoice->due_date);
        $month = getMonthName($invoice->due_date);
        $subject = 'Invoice '.$invoice_number. ' '.$customer->company .' for ' . $month;

        return new Envelope(
            // subject: 'Invoice Mail',
            subject: $subject,
            cc: ['anton.pru@gmail.com', 'anton.phangesti@gmail.com'],
            from: 'michelle@blueskycreation.id',
            to: 'michellevelicia18@gmail.com',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $invoice = Invoice::where('number', $this->number)->first();
        $customer = Customer::where('id', $invoice->customer_id)->first();
        $invoice_number = invNumberFormat($this->number, $invoice->invoice_date);

        return new Content(
            view: 'pdf.invoiceEmailTemplate',
            with: ['title' => $customer->salutation,  'custName' => $customer->name, 'invoice_number' => $invoice_number,
            'company' => $customer->company, 'due_date' => tanggal($invoice->due_date)
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        // $pdfFileName = 'BlueSkyCreation_' . invNumberFormat($number, $invoice->invoice_date) . '.pdf';
        $invoices = Invoice::where('number', $this->number)->get();
        $invoice = Invoice::where('number', $this->number)->first();
        $customer = Customer::find($invoice->customer_id);
        $pdfFileName = 'BlueSkyCreation_' . invNumberFormat($this->number, $invoice->invoice_date) . '.pdf';
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

        $html = view('pdf.invoicepdftemplate', compact(['invoices', 'invoice', 'customer']));
        $mpdf->WriteHTML($html);
        $pdf = $mpdf->Output('', 'S');
        return [
            Attachment::fromData(fn () => $pdf, $pdfFileName)
            ->withMime('application/pdf'),
        ];
    }
}
