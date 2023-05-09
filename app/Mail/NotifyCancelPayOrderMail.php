<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyCancelPayOrderMail extends Mailable
{
    use Queueable, SerializesModels;

	protected Order $order;

	/**
	 * Create a new message instance.
	 *
	 * @param Order $order
	 */
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
	    return $this->view('email.notify_cancel_pay_order', [
			    'order' => $this->order,
			    'companyName' => config('app.company.name'),
		    ])
		    ->from(config('app.company.email'), config('app.company.name'))
		    ->subject('r-WASD Payment Unsuccessful / Order No. ' . $this->order->order_code);
    }
}
