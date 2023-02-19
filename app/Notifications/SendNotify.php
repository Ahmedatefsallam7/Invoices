<?php

namespace App\Notifications;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendNotify extends Notification
{
    use Queueable;

    private $invoice_id;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Invoice $invoice_id)
    {
        $this->invoice_id = $invoice_id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [/*'mail',*/'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */


    /*public function toMail($notifiable)
    {
        $url = "http://127.0.0.1:8000/invoice-detailes/" . $this->invoice_id;
        return (new MailMessage)
            ->from('ahmedatefsallam7@gmail.com.com', 'Ahmed Atef')
            ->subject("اضافة فاتوره جديده")
            ->greeting(auth()->user()->name . " اهلا بك ")
            ->line('تم اضافة فاتوره جديده لك')
            ->action('عرض الفاتوره', $url)
            ->line('شكراَََ');
    }*/

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $invoices = Invoice::find($this->invoice_id);
        foreach ($invoices as $invoice) {
            $number = $invoice->invoice_number;
        }

        return [
            'id' => $this->invoice_id,
            'title' => ' تم اضافة فاتوره رقم  '  . $number . '  بواسطة  ',
            'user' => auth()->user()->name,
        ];
    }
}