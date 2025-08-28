<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Invoice;
use App\Models\Joblist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use Illuminate\Mail\Transport\TransportException;
use App\Models\Sendinvoice;
use App\Models\Smtpserver;
use App\Models\Template;
use App\Models\Setting;
use App\Models\User;
use Exception;
use Swift_TransportException;



class InvoicePage extends Component
{

    use WithPagination;

    public $invoice;
    public $template;
    public $tags=[];
    public $tagvalues=[];
    public $invoice_id;

    public $emails=[];

    protected $listeners = ['setInvoiceId'];

    public function mount()
    {
        $this->tags = [
            '{first_name}',
            '{last_name}',
            '{email}',
            '{phone}',
            '{company}',
            '{city}',
            '{postal_code}',
            '{country}'
        ];

        $user    = User::find(1);
        $setting = Setting::find(1);

        if ($user && $setting) {

            $this->tagvalues = [
                '{first_name}' => '',
                '{last_name}' => '',
                '{email}' => '',
                '{phone}' => '',
                '{company}' => '',
                '{city}' => '',
                '{postal_code}' => '',
                '{country}' => '',
            ];
        }

    }

    public function setInvoiceId($id)
    {
        $this->invoice_id = $id;
    }

    public function deleteInvoice($id)
    {
        $invoice = Invoice::find($id);
        if ($invoice) {
            Joblist::where('invoice_id', $invoice->id)->update(['invoice_id' => NULL, 'invoice_created' => 'no']);
            Customertransaction::where('invoice_id', $invoice->id)->delete();
            $invoice->delete();
            $this->dispatch('success', message: 'Invoice has been Deleted.');
            return;
        }
    }

    public function selectedCustomer($id)
    {
        $this->reset(['invoice','template']);
        $this->invoice = Invoice::find($id);
    }

    public function sendMail()
    {
        $this->validate(
            ['invoice'  => 'required','template' => 'required',],
            ['invoice.required'  => 'Invoice Not Selected.','template.required' => 'Select Template.']
        );
        $this->invoice = Invoice::find($this->invoice_id);
        if ($this->invoice) {
            $user     = User::find($this->invoice->user_id);
            $smtp     = Smtpserver::first();
            $templace = Template::find($this->template);
            if ($user && $smtp && $templace) {
                $send_status = '';
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
    
                /* replaced text message */
                $replaced_text = $templace->body;
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
                    'email'       => customerEmail($this->invoice->user_id),
                    'from'        => $smtp['from_address'],
                    'sender_name' => config('app.name'),
                    'subject'     => $templace->name,
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

                    Mail::send('email.sendinvoice', ['mailinfo' => $mailinfo], function ($message) use ($mailinfo) {
                        $message->from($mailinfo['from'], $mailinfo['sender_name']);
                        $message->to(customerEmail(1), $mailinfo['sender_name'])->subject($mailinfo['subject']);
                        // Attach a single file
                        $message->attach($mailinfo['attachments']);
                    });

                    $send_status = 1;
                } catch (TransportException $e) {
                    $send_status = 0;
                }
    
                if($send_status == 1){
                    Sendinvoice::create([
                        'user_id' => $this->invoice->user_id,
                        'invoice_id' => $this->invoice->id,
                        'body' => $replaced_text,
                        'attachment' => storage_path('app/public/pdfs/').$this->invoice->generated_invoice,
                        'status' => 'send',
                    ]);
                }
                $this->dispatch('success', message: 'Send Successfully.');
                return $this->redirect('/admin/invoices', navigate:false);
            } else {
                $this->dispatch('warning', message: 'SMTP Server is not Available!!!');
                return;
            }
        }
    }


    public function render()
    {
        if(role_name(Auth::user()->id) == 'Administrator') {
            $data['paid_invoices']   = Invoice::where('status', 'paid')->get();
            $data['unpaid_invoices'] = Invoice::where('status', 'unpaid')->get();
        } elseif(role_name(Auth::user()->id) == 'Customer') {
            $data['paid_invoices']   = Invoice::where('user_id', Auth::user()->id)->where('status', 'paid')->get();
            $data['unpaid_invoices'] = Invoice::where('user_id', Auth::user()->id)->where('status', 'unpaid')->get();
        } else {
            $data['paid_invoices'] = [];
            $data['unpaid_invoices'] = [];
        }

        $data['templates'] = Template::all();
        $data['body'] = $this->template ? Template::find($this->template)->body : '';

        return view('livewire.invoice-page', $data);
    }
}
