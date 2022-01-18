<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Request;

class MyResetPassword extends Notification
{
    use Queueable;

    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;

    /**
     * Create a notification instance.
     *
     * @param  string  $token
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = route('frontend.password.reset', $this->token);
        if(Request::route()->getPrefix() === '/admin'){
            $url = route('admin.password.reset', $this->token);
        }
        return (new MailMessage)
            ->subject('Yêu cầu thay đổi mật khẩu')
            ->line('Bạn nhận được email bởi vì chúng tôi nhận được yêu cầu thay đổi mật khẩu từ tài khoản của bạn.')
            ->action('Reset Password', $url)
            ->line('Nếu bạn không thực hiện yêu cầu này, thì hãy bỏ qua email này.');
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
