<?php

namespace App\Mail;

use App\Models\Order;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Mail for sent order
 *
 * Throws exception if order has no postal tracking code
 */
class NotifyShippedOrderMail extends Mailable
{
    use Queueable, SerializesModels;

	protected Order $order;

	/**
	 * Create a new message instance.
	 *
	 * @param Order $order
	 * @throws Exception
	 */
    public function __construct(Order $order)
    {
	    $this->order = $order;
	    if (empty($this->order->postal_tracking_code)) {
		    throw new Exception(trans('Order has no postal tracking code.'));
	    }
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): NotifyShippedOrderMail
    {
	    return $this->view('email.notify_shipped_order', [
			    'order' => $this->order,
			    'companyName' => config('app.company.name'),
		    ])
		    ->from(config('app.company.email'), config('app.company.name'))
		    ->subject('r-Wasd Shipping Confirmation / Order No. ' . $this->order->order_code);
    }
}
