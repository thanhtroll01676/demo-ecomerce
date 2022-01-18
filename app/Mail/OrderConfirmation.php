<?php

namespace App\Mail;

use App\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $order; // để cbị hứng $order bên ngoài (qua lệnh
    // $this->>order = cái cần hứng)
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.order-confirmation-markdown')
            ->subject('Xác nhận đơn hàng')
            ->with([
                'order' => $this->order,
                'products' => $this->order->products,
            ]);
        //     $this->view('emails.order-confirmation')
    }
}
