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

    }


    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Invoice Mail',
            cc: ['anton.pru@gmail.com', 'anton.phangesti.com'],
            from: 'michelle@blueskycreation.com',
            to: 'kokonacci@gmail.com',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {

        $invoice = Invoice::where('number', $this->number)->first();
        $customer = Customer::where('id', $invoice->customer_id)->first();


        return new Content(
            view: 'pdf.invoiceEmailTemplate2',
            with: ['custName' => $customer->name

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

        $mpdf = new \Mpdf\Mpdf();
        ob_get_clean();

        $html = view('pdf.invoicepdftemplate', compact(['invoices', 'invoice', 'customer']));
        $mpdf->WriteHTML($html);
        $pdf = $mpdf->Output('', 'S');
        return [
            Attachment::fromData(fn () => $pdf, 'Report.pdf')
            ->withMime('application/pdf'),
        ];
    }
}
