<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RestoreCanceledOrder extends Mailable
{
    use Queueable, SerializesModels;

    public $company;
    public $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($company, $order)
    {
        $this->company = $company;
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Востановлен отменненный заказ')->view('emails.providers.orders.restoreCanceledOrder');
    }
}
