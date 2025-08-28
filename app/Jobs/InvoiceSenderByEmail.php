<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\Invoice;
use App\Models\User;
use App\Models\Smtpserver;
use App\Models\Template;
use App\Models\Sendinvoice;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use Illuminate\Mail\Transport\TransportException;
use Exception;
use Swift_TransportException;

class InvoiceSenderByEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 500000;
    public $maxExceptions = 3;

    public $invoice;
    public $template;
    public $smtp;

    public $tags=[];
    public $tagvalues=[];
    public $recipientEmail;

    
    
    public function __construct($invoiceId, $templateId, $recipientEmail)
    {
        $this->invoice  = Invoice::find($invoiceId);
        $this->template = Template::find($templateId);
        $this->smtp     = Smtpserver::first();
        $this->recipientEmail = $recipientEmail;

    }
    
    public function handle(): void
    {
        if ($this->invoice && $this->template && $this->smtp && $this->recipientEmail) {

            $user = User::find($this->invoice->user_id);

            if ($user) {
                $send_status = '';
                $config = [
                    'driver'     => 'smtp',
                    'host'       => $this->smtp->hostname,
                    'port'       => $this->smtp->port,
                    'username'   => $this->smtp->username,
                    'password'   => $this->smtp->password,
                    'encryption' => $this->smtp->encryption,
                    'from'       => ['address' => $this->smtp->from_address, 'name' => config('app.name')],
                    'reply_to'   => [
                        'address' => $this->smtp->from_address,
                        'name'    => config('app.name'),
                    ],
                    'sendmail' => '/usr/sbin/sendmail -bs',
                    'pretend'  => false,
                ];
                Config::set('mail', $config);


                /* replaced text message */
                $replaced_text = $this->template->body;
                foreach ($this->tagvalues as $key => $value) {
                    $pattern = '/' . preg_quote($key, '/') . '/';
                    if (preg_match($pattern, $replaced_text)) {
                        $value2 = empty($value) ? $user->getAttribute(str_replace(['{', '}'], '', $key)) : $value;
                        $replaced_text = preg_replace($pattern, $value2, $replaced_text);
                    }
                }
                $replaced_text = preg_replace("/[[:blank:]]+/"," ",$replaced_text);
                /* replaced text message */ 


                $mailinfo = [
                    'email'       => $this->recipientEmail,
                    'from'        => $this->smtp->from_address,
                    'sender_name' => config('app.name'),
                    'subject'     => $this->template->name,
                    'body'        => $replaced_text,
                    'tracking_id' => '',
                    'attachments' => storage_path('app/public/pdfs/').$this->invoice->generated_invoice
                ];


                try {
                    Mail::send('email.sendinvoice', ['mailinfo' => $mailinfo], function ($message) use ($mailinfo) {
                        $message->from($mailinfo['from'], $mailinfo['sender_name']);
                        $message->to($mailinfo['email'], $mailinfo['sender_name'])->subject($mailinfo['subject']);
                        // Attach a single file
                        $message->attach($mailinfo['attachments']);
                    });

                    $send_status = 1;
                } catch (TransportException $e) {
                    $send_status = 0;
                }

                // after sent save the data to 
                if($send_status == 1){
                    Sendinvoice::create([
                        'user_id'    => $this->invoice->user_id,
                        'invoice_id' => $this->invoice->id,
                        'body'       => $replaced_text,
                        'attachment' => storage_path('app/public/pdfs/').$this->invoice->generated_invoice,
                        'status'     => 'send',
                    ]);
                }
            }
        }
    }
}
