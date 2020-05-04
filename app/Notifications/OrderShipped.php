<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Carbon\Carbon;

class OrderShipped extends Notification
{
    use Queueable;

    protected $order;
    protected $company;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($order, $company)
    {
        $this->order = $order;
        $this->company = $company;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

    public function toDatabase($notifiable)
    {
        return [
            'order_id' => $this->order->id,
            'replied_time' => Carbon::now(),
            'company_id' =>  $this->company->id,
            'company_name' =>  $this->company->name,
        ];
    }
}
