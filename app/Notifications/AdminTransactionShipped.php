<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AdminTransactionShipped extends Notification
{
    use Queueable;

    protected $transaction;
    protected $company;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($transaction, $company)
    {
        $this->transaction = $transaction;
        $this->company = $company;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

    public function toDatabase($notifiable)
    {
        return [
            'transaction_id' =>  $this->transaction->id,
            'transaction_type' =>  $this->transaction->type_transaction,
            'transaction_sum' =>  $this->transaction->total_sum,
            'company_id' =>  $this->company->id,
            'company_name' =>  $this->company->name
        ];//type_transaction 0-deposit, 3-aboniment
    }
}
