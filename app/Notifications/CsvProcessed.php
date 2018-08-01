<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use App\Csv;

class CsvProcessed extends Notification implements ShouldBroadcast
{
    use Queueable;
	$csv;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Csv $csv)
    {
        $this->csv = $csv;
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
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
			'id' => $this->csv->id,
            'result' => $this->csv->result
        ];
    }
	
	/**
	 * Get the broadcastable representation of the notification.
	 *
	 * @param  mixed  $notifiable
	 * @return BroadcastMessage
	 */
	public function toBroadcast($notifiable)
	{
		return new BroadcastMessage([
			'id' => $this->csv->id,
            'result' => $this->csv->result
        ]);
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
}
