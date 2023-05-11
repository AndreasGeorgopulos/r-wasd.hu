<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Str;

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
	    $mailConfig = config('app.mail.order.cancel_payment');
	    $subject = Str::replaceFirst('{order-no}', $this->order->order_code, $mailConfig['subject']);

	    return $this->view('email.notify_cancel_pay_order', [
			    'order' => $this->order,
			    'companyName' => config('app.company.name'),
		    ])
		    ->from($mailConfig['from']['email'], $mailConfig['from']['name'])
		    ->cc($mailConfig['cc'])
		    ->bcc($mailConfig['bcc'])
		    ->subject($subject);
    }
}
