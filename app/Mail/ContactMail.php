<?php

namespace App\Mail;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

	protected Contact $contact;

	/**
	 * Create a new message instance.
	 *
	 * @param Contact $contact
	 */
    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
	    $subject = trans('r-Wasd contact: ');
		collect(Contact::getSubjectDropdownOptions())
			->where('value', $this->contact->subject)
			->first(function ($item) use(&$subject) {
				$subject .= $item['title'];
			});

        return $this->view('email.contact', [
				'contact' => $this->contact,
	        ])
	        ->from($this->contact->email, $this->contact->name)
	        ->subject($subject);
    }
}
