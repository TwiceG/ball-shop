<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Support\HtmlString;

class SendTOTPToken extends Mailable
{
    protected $totpToken;

    public function __construct($totpToken)
    {
        $this->totpToken = $totpToken;
    }

    public function build()
    {
        $message = "Your TOTP token is: {$this->totpToken}";

        return $this->subject('Your TOTP Token')
            ->view('emails.2fa')
            ->with('totpMessage', $message);
    }

}
