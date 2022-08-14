<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class orderMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $data;
    public function __construct($data)
    {
     $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('Mails.order_checkout')
                    ->from('thaolinh250292@gmail.com','Hệ thống thương mại điện tử UNIMART')
                    ->subject('[unimart] Thông báo đặt hàng thành công!')
                    ->with($this->data);
                   
    }
}
