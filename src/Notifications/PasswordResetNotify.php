<?php

namespace Gtd\Extension\User\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Gtd\Extension\User\Models\User;
use Gtd\Extension\User\Models\UserChange;

class PasswordResetNotify extends Notification implements ShouldQueue
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
        $active_url = url('x-'.$this->user->userType->type_name.'/passport/password/reset?token='.$this->user->reset_token);
        
        return (new MailMessage)
                    ->subject('密码重置')
                    ->from('hello@no-reply.gtd.xyz','Suda')
                    ->markdown('vendor.notifications.email',[
                        'title' => '密码重置',
                        'body' => '您正在重置密码,账号 '.$this->user->email,
                        'tips' => '找回密码有效期是24小时,请尽快重置. 如果不是您自己的操作,请忽略此邮件.',
                        'actionUrl'   => $active_url,
                        'actionText'   => '立即重置密码',
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
