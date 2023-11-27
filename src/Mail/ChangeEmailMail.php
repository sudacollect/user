<?php

namespace Gtd\Extension\User\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ChangeEmailMail extends Mailable
{
    use Queueable, SerializesModels;

    public $verify_code;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($verify_code)
    {
        $this->verify_code = $verify_code;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('修改邮箱验证码')
            ->markdown('vendor.notifications.email',[
                'title' => '邮箱验证码',
                'body' => "您正在修改邮箱， 验证码 ".$this->verify_code,
                'tips' => '验证码有效期是30分钟,请尽快验证使用. 如果不是您自己的操作,请忽略此邮件.',
                // 'actionUrl'   => $active_url,
                // 'actionText'   => '立即重置密码',
            ]);
    }
}
