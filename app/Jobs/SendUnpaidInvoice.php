<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Mail\Transport\TransportException;
use App\Models\Smtpserver;
use App\Models\Template;
use App\Models\Invoice;
use App\Models\Sendinvoice;
use App\Models\User;
use Exception;
use Swift_TransportException;

class SendUnpaidInvoice implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public $tries = 500000;
    public $maxExceptions = 3;
    public $userID;
    public $invoiceID;
    public $subject;
    public $body;
    
    public function __construct($userID, $invoiceID, $template_name, $body)
    {
        $this->userID    = $userID;
        $this->invoiceID = $invoiceID;
        $this->subject   = $template_name;
        $this->body      = $body;
    }
    
    public function handle(): void
    {
        $smtp        = Smtpserver::first();
        $user        = User::find($this->userID);
        $invoice     = Invoice::find($this->invoiceID);
        $subject     = $this->subject;
        $send_status = '';
        
        if ($smtp && $user && $invoice && $subject) {
            $config = [
                'driver' => 'smtp',
                'host' => $smtp['hostname'],
                'port' => $smtp['port'],
                'username' => $smtp['username'],
                'password' => $smtp['password'],
                'encryption' => $smtp['encryption'],
                'from' => ['address' => $smtp['from_address'], 'name' => config('app.name')],
                'reply_to' => [
                    'address' => $smtp['from_address'],
                    'name' => config('app.name'),
                ],
                'sendmail' => '/usr/sbin/sendmail -bs',
                'pretend' => false,
            ];
            Config::set('mail', $config);

            $mailinfo = [
                'email'       => $user->email,
                'from'        => $smtp['from_address'],
                'sender_name' => config('app.name'),
                'subject'     => $subject,
                'body'        => $this->body,
                'tracking_id' => '',
                'attachments' => storage_path('app/public/pdfs/').$invoice->generated_invoice
            ];


            try {
                Mail::send('email.sendinvoice', ['mailinfo' => $mailinfo], function ($message) use ($mailinfo) {
                    $message->from($mailinfo['from'], $mailinfo['sender_name']);
                    $message->to($mailinfo['email'], $mailinfo['sender_name'])->subject($mailinfo['subject']);
                    $message->attach($mailinfo['attachments']);
                });
                $send_status = 1;
            } catch (TransportException $e) {
                $send_status = 0;
            }

            if($send_status == 1){
                Sendinvoice::create([
                    'user_id'    => $this->userID,
                    'invoice_id' => $this->invoiceID,
                    'body'       => $this->body,
                    'attachment' => storage_path('app/public/pdfs/').$invoice->generated_invoice,
                    'status'     => 'send',
                ]);
            }
        }
    }
}
