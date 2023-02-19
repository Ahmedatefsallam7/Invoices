<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AddInvoice extends Mailable
{
    use Queueable, SerializesModels;

    private $invoice_id;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($invoice_id)
    { 
        $this->invoice_id = $invoice_id;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            from: new Address('ahmedatefsallam7@gmail.com', 'Ahmed Atef'),
            subject: ' اضافة فاتوره جديده ',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        $url = "http://127.0.0.1:8000/invoice-detailes/".$this->invoice_id;
        return new Content(
            markdown: 'emails.AddInvoice',
            with: [
                'url' => $url,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}