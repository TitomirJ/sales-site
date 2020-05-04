<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderShipped extends Mailable
{
    use Queueable, SerializesModels;

    public $company;
    public $orders;

    public function __construct($company, $orders)
    {
        $this->company = $company;
        $this->orders = $orders;
    }


    public function build()
    {
        return $this->subject('Поступил новый заказ')->view('emails.providers.orders.orderShipped');
    }
}
