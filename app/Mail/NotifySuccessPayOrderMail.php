<?php

namespace App\Mail;

use App\Models\Order;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

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
	    $mailConfig = config('app.mail.order.success_payment');
	    $subject = Str::replaceFirst('{order-no}', $this->order->order_code, $mailConfig['subject']);

		return $this->view('email.notify_success_pay_order', [
			    'order' => $this->order,
			    'companyName' => config('app.company.name'),
		    ])
			->from($mailConfig['from']['email'], $mailConfig['from']['name'])
			->cc($mailConfig['cc'])
			->bcc($mailConfig['bcc'])
			->subject($subject);
    }
}
