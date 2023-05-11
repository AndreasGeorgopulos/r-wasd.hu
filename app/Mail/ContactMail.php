<?php

namespace App\Mail;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Str;

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
		$mailConfig = config('app.mail.contact');

	    $subject = $mailConfig['subject'];
		collect(Contact::getSubjectDropdownOptions())
			->where('value', $this->contact->subject)
			->first(function ($item) use(&$subject) {
				$subject = Str::replaceFirst('{option-title}', $item['title'], $subject);
			});

        return $this->view('email.contact', [
				'contact' => $this->contact,
	        ])
	        ->from($this->contact->email, $this->contact->name)
	        ->cc($mailConfig['cc'])
	        ->bcc($mailConfig['bcc'])
	        ->subject($subject);
    }
}
