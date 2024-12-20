<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;

class HrUserQueryNotification extends Notification
{
    use Queueable;

    public $user;
    public $msg; 
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user,$msg)
    {
        $this->user = $user;
        $this->msg = $msg;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database'];
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
        ->subject('Query Request Notification')
        ->greeting("Hi ".$this->user->name)
        ->line($this->msg)
        ->action('View Queries', url("query/allqueries"))
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

          return new DatabaseMessage([
            'subject'=>'Query Request Notification',
            'message'=>$this->msg,
            'action'=>url("query/allqueries"),
            'type'=>'Query Request',
            'icon'=>'md-file-text'
        ]);

    }
}
