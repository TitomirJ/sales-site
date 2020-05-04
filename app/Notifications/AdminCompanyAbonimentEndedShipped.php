<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AdminCompanyAbonimentEndedShipped extends Notification
{
    use Queueable;

    protected $company;
    protected $timestemp_id;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($company, $timestemp_id)
    {
        $this->company = $company;
        $this->timestemp_id = $timestemp_id;
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
            'timestemp_id' => $this->timestemp_id,
            'company_id' =>  $this->company->id,
            'company_name' =>  $this->company->name,
            'company_ab' =>  $this->company->ab_to
        ];
    }
}
