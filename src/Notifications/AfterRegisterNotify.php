<?php

namespace Gtd\Extension\User\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Gtd\Extension\User\Models\User;

class AfterRegisterNotify extends Notification implements ShouldQueue
{
    use Queueable;
    
    
    public $user;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
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
        $active_url = url('x-'.$this->user->userType->type_name.'/passport/register/check?token='.$this->user->reset_token);

        return (new MailMessage)
            ->subject('注册验证')
            ->from('hello@no-reply.gtd.xyz','Suda')
            ->markdown('vendor.notifications.email',[
                'title' => '注册验证',
                'body' => '您的注册帐户是 '.$this->user->email,
                'tips' => '感谢您的注册. 如果不是您自己的操作,请忽略此邮件.',
                'actionUrl'   => $active_url,
                'actionText'   => '点击确认注册',
            ]);
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
