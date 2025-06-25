<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;

class FcmNotification extends Notification
{
    use Queueable;

    protected $title;
    protected $message;
    protected $deviceToken;

    /**
     * Create a new notification instance.
     */
    public function __construct($title, $message, $deviceToken)
    {
        $this->title = $title;
        $this->message = $message;
        $this->deviceToken = $deviceToken;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['fcm'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
    public function toFcm($notifiable)
    {
        $SERVER_API_KEY = config('services.fcm.server_key');

        $response = Http::withHeaders([
            'Authorization' => 'key=' . $SERVER_API_KEY,
            'Content-Type' => 'application/json',
        ])->post('https://fcm.googleapis.com/fcm/send', [
            'to' => $this->deviceToken,
            'notification' => [
                'title' => $this->title,
                'body' => $this->message,
                'sound' => 'default',
            ],
            'priority' => 'high',
        ]);

        return $response->json(['message'=>'notification have been send']);
    }
}
