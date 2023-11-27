<?php

namespace Gtd\Extension\User\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Gtd\Extension\User\Models\User;

use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailable;
use Gtd\Extension\User\Mail\ChangeEmailMail;

class ChangeEmailNotify extends Notification implements ShouldQueue
{
    use Queueable;
    
    
    public $user;
    public $new_email;
    public $verify_code;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($new_email,$verify_code)
    {
        $this->new_email = $new_email;
        $this->verify_code = $verify_code;
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
        
        return (new ChangeEmailMail($this->verify_code))->to($this->new_email);
        
        /**
        return (new MailMessage)
                    ->subject('修改邮箱验证码')
                    ->from('hello@no-reply.gtd.xyz','Suda')
                    ->to($this->new_email)
                    ->line('您正在修改邮箱账号,')
                    ->line('验证码 '.session()->get('email_verify_code'))
                    // ->action('立即找回密码', $active_url)
                    ->line('验证码有效期是30分钟,请尽快使用.');
        */
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
