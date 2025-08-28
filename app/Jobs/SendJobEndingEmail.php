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
use App\Models\Joblist;
use App\Models\Smtpserver;
use Exception;
use Swift_TransportException;

class SendJobEndingEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 500000;
    public $maxExceptions = 3;
    public $employeeID;
    public $joblisttID;


    public function __construct($employeeID, $joblisttID)
    {
        $this->employeeID = $employeeID;
        $this->joblisttID = $joblisttID;
    }
    
    public function handle(): void
    {
        $smtp  = Smtpserver::first();
        $user  = User::find($this->employeeID);
        $job   = Joblist::find($this->joblisttID);
        $send_status = '';

        if ($user && $smtp && $job) {
            $config = [
                'driver'     => 'smtp',
                'host'       => $smtp['hostname'],
                'port'       => $smtp['port'],
                'username'   => $smtp['username'],
                'password'   => $smtp['password'],
                'encryption' => $smtp['encryption'],
                'from'       => ['address' => $smtp['from_address'], 'name' => config('app.name')],
                'reply_to'   => [
                    'address' => $smtp['from_address'],
                    'name'    => config('app.name'),
                ],
                'sendmail' => '/usr/sbin/sendmail -bs',
                'pretend'  => false,
            ];
            Config::set('mail', $config);

            $mailinfo = [
                'email'       => $user->email,
                'from'        => $smtp['from_address'],
                'sender_name' => config('app.name'),
                'subject'     => 'Hurry Up! And Finish Your Job!',
                'body'        => 'You have less than 15 minutes to Finish your Job!!!',
                'full_name'   => fullName($user->id),
            ];

            try {
                Mail::send('email.sendinvoice', ['mailinfo' => $mailinfo], function ($message) use ($mailinfo) {
                    $message->from($mailinfo['from'], $mailinfo['sender_name']);
                    $message->to($mailinfo['email'], $mailinfo['sender_name'])->subject($mailinfo['subject']);
                });
                $send_status = 1;
            } catch (TransportException $e) {
                $send_status = 0;
            }
        }
    }
}
