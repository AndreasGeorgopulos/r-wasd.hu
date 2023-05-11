<?php

namespace App\Mail;

use App\Models\Order;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Str;

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
	    $mailConfig = config('app.mail.order.shipped');
		$subject = Str::replaceFirst('{order-no}', $this->order->order_code, $mailConfig['subject']);

	    return $this->view('email.notify_shipped_order', [
			    'order' => $this->order,
			    'companyName' => config('app.company.name'),
		    ])
		    ->from($mailConfig['from']['email'], $mailConfig['from']['name'])
		    ->cc($mailConfig['cc'])
		    ->bcc($mailConfig['bcc'])
		    ->subject($subject);
    }
}
