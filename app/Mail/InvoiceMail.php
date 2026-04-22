<?php

namespace App\Mail;

use App\Models\Invoice;
use App\Models\Contract;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Spatie\Browsershot\Browsershot;
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
        $subject = 'Invoice ' . $invoice_number . ' ' . $customer->company . ' for ' . $month;

        return new Envelope(
            subject: $subject,
            // cc: 'tiffany.blueskycreation@gmail.com',
            // bcc: 'info.blueskycreation@gmail.com',
            from: new Address('info@blueskycreation.id', 'Blue Sky Creation'),
            to: $customer->email,
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
            // view: 'pdf.invoiceEmailTemplate',
            view: 'pdf.invoiceEmailTemplate',
            with: [
                'title' => $customer->salutation,
                'custName' => $customer->name,
                'invoice_number' => $invoice_number,
                'company' => $customer->company,
                'due_date' => tanggal($invoice->due_date)
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
        $contract = Contract::where('contract_number', $invoice->contract)->first();
        if ($contract != '') {
            $contract_number = contractNumberFormat($contract->contract_number, $contract->contract_date);
            // dd($contract_number);
        } else {
            $contract_number = '-';
            // dd($contract_number);
        }
        $pdfFileName = 'BlueSkyCreation_' . invNumberFormat($this->number, $invoice->invoice_date) . '.pdf';
        $template =  view('pdf.invoicepdftemplate', compact(['invoices', 'invoice', 'customer', 'contract_number']))->render();

        $footerHtml = view('pdf.footer')->render();

        $pdf = Browsershot::html($template)
            ->setNodeBinary('/usr/bin/node')
            ->setChromePath('/usr/bin/google-chrome')
            ->setEnvironmentOptions([
                'HOME' => '/tmp',
                'XDG_CONFIG_HOME' => '/tmp',
                'XDG_CACHE_HOME' => '/tmp',
            ])
            ->showBackground()
            ->noSandbox()
            ->showBrowserHeaderAndFooter()
            ->footerHtml($footerHtml)
            ->addChromiumArguments([
                '--disable-crash-reporter',
            ])
            ->fo
            ->format('A4')
            ->pdf(); // hasil binary

        // Kirim langsung ke browser untuk di-download
        // return response($pdf)
        //     ->header('Content-Type', 'application/pdf')
        //     ->header('Content-Disposition', 'attachment; filename="' . $pdfFileName . '"');

        // return back()->with('message', 'PDF Generated');

        return [
            Attachment::fromData(fn() => $pdf, $pdfFileName)
                ->withMime('application/pdf'),
        ];
    }
}
