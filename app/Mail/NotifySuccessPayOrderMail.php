<?php

namespace App\Mail;

use App\Models\Order;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Mail for success payment after order complete
 *
 * Throws exception if order has no payment transaction id
 */
class NotifySuccessPayOrderMail extends Mailable
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
		if (empty($this->order->paypal_response)) {
			throw new Exception(trans('Order has no payment transaction id.'));
		}
	}

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): NotifySuccessPayOrderMail
    {
		return $this->view('email.notify_success_pay_order', [
			    'order' => $this->order,
			    'companyName' => config('app.company.name'),
		    ])
		    ->from(config('app.company.email'), config('app.company.name'))
			->bcc([config('app.company.email')])
		    ->subject('r-Wasd Payment Successful / Order No. ' . $this->order->order_code);
    }
}
