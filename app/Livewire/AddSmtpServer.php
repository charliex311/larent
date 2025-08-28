<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use App\Models\Smtpserver;

class AddSmtpServer extends Component
{
    public $row;
    public
        $name,
        $hostname,
        $username,
        $password,
        $port,
        $encryption='ssl',
        $from_address,
        $hourly_limit;

    public $to;

    public function mount()
    {
        $this->row = Smtpserver::first() ? Smtpserver::first() : Smtpserver::create();
        $this->name = $this->row ? $this->row->name : $this->name;
        $this->hostname = $this->row ? $this->row->hostname : $this->hostname;
        $this->username = $this->row ? $this->row->username : $this->username;
        $this->password = $this->row ? $this->row->password : $this->password;
        $this->port = $this->row ? $this->row->port : $this->port;
        $this->encryption = $this->row && $this->row->encryption ? $this->row->encryption : 'tls';
        $this->from_address = $this->row ? $this->row->from_address : $this->from_address;
        $this->hourly_limit = $this->row ? $this->row->hourly_limit : $this->hourly_limit;
    }


    public function save()
    {
        $this->validate(
            [
                'name' => 'required',
                'hostname' => 'required',
                'username' => 'required',
                'password' => 'required',
                'port' => 'required|integer',
                'encryption' => 'required',
                'from_address' => 'required',
                'hourly_limit' => 'required|integer',
            ],
            [
                'name.required' => 'Enter Server Name',
                'hostname.required' => 'Enter Hostname.',
                'username.required' => 'Enter Username.',
                'password.required' => 'Enter Password.',
                'port.required' => 'Enter Port Number.',
                'encryption.required' => 'Select En-cryption Type.',
                'from_address.required' => 'Enter Email Address',
                'hourly_limit.required' => 'Enter Hourly Sending Limit.',
            ],
        );

        if ($this->row) {
            $this->row->update([
                'name'         => $this->name,
                'hostname'     => $this->hostname,
                'username'     => $this->username,
                'password'     => $this->password,
                'port'         => $this->port,
                'encryption'   => $this->encryption,
                'from_address' => $this->from_address,
                'hourly_limit' => $this->hourly_limit
            ]);
            $this->dispatch('success', message: 'Updated Successfully.');
            // return $this->redirect('/admin/smtp-server', navigate:true);
        }
    }


    public function testSmtp()
    {
        $this->validate(
            [
                'from_address' => 'required',
                'to' => 'required',
            ],
            [
                'from_address.required' => 'Enter From Email Address.',
                'to.required' => 'Enter Destination Email Address.',
            ]
        );
        $server = Smtpserver::first();

        if ($server) {
            $from = $this->from_address;
            $to = $this->to;
            $from_name = companyname();
            $reply_email = $server->from_address;
            $send_status = null;

            $config = [
                'driver' => 'smtp',
                'host' => $server['hostname'],
                'port' => $server['port'],
                'username' => $server['username'],
                'password' => $server['password'],
                'encryption' => $server['encryption'],
                'from' => ['address' => $from, 'name' => $from_name],
                'reply_to' => [
                    'address' => $reply_email,
                    'name' => $from_name,
                ],
                'sendmail' => '/usr/sbin/sendmail -bs',
                'pretend' => false,
            ];

            Config::set('mail', $config);

            $mailinfo = [
                'email'       => $to,
                'from'        => $from,
                'sender_name' => $from_name,
                'subject'     => 'SMTP Testing '.date("Y"),
                'body'        => 'Server is working perfectly. '
            ];
            try {
                Mail::send('email.sample', ['mailinfo' => $mailinfo],
                    function ($message) use ($mailinfo) {
                        $message->from($mailinfo['from'], $mailinfo['sender_name']);
                        $message->to($mailinfo['email'], $mailinfo['sender_name'])->subject($mailinfo['subject']);
                    });
                $send_status = 1;
            } catch (\Exception $e) {
                if ($e->getMessage()) {
                    $send_status = 0;
                }
            }
            if($send_status == 1){
                $server->update(['status' => 1]);
                $this->dispatch('success', message: 'Mail Sent.');

            } elseif($send_status == 0) {
                $this->dispatch('warning', message: 'Mail Not Send!');
                return;
            }
        } else {
            $this->dispatch('warning', message: 'Invalid SMTP.');
            return;
        }
    }


    public function render()
    {
        return view('livewire.add-smtp-server');
    }
}
