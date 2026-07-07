<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Application;

class JobApplicationStatus extends Notification
{
    use Queueable;

    protected ?Application $application;

    /**
     * Create a new notification instance.
     */
    public function __construct(Application $application = null)
    {
        $this->application = $application;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('update your request')
            ->greeting('Hallo' .$notifiable->name)
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

    public function updateStatus($id, Request $request)
    {
        $application = Application::find($id);
        $application->status = $request->status;
        $application->save();
    
   
        $application->user->notify(new ApplicationStatusUpdated($application));
    
        return response()->json(['message' => 'update your status']);
    }
}