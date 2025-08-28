<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Invoice;
use App\Models\Sendinvoice;
use App\Models\Smtpserver;
use App\Models\Template;
use App\Models\Joblist;
use App\Models\Setting;
use App\Models\User;
use App\Jobs\SendUnpaidInvoice;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Mail\Transport\TransportException;

use Livewire\WithPagination;
use Exception;
use Swift_TransportException;

class UnpaidInvoices extends Component
{

    public $invoice;
    public $template;
    public $tags=[];
    public $tagvalues=[];

    use WithPagination;

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

        $user = User::find(1);
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

    public function deleteInvoice($id)
    {
        $invoice = Invoice::find($id);
        if ($invoice) {
            Joblist::where('invoice_id', $invoice->id)->update(['invoice_id' => NULL, 'invoice_created' => 'no']);
            $invoice->delete();
            $this->dispatch('success', message: 'Invoice has been Deleted.');
            return $this->redirect('/admin/unpaid-invoices', navigate:true);
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
            [
                'invoice' => 'required',
                'template' => 'required',
            ],
            [
                'invoice.required' => 'Invoice Not Selected.',
                'template.required' => 'Select Template.'
            ]
        );
        $user = User::find($this->invoice->user_id);
        $smtp = Smtpserver::first();
        $template = Template::find($this->template);
        
        if ($user && $smtp && $template) {

            /* replaced text message */
            $replaced_text = $template->body;
            foreach ($this->tagvalues as $key => $value) {
                $pattern = '/' . preg_quote($key, '/') . '/';
                if (preg_match($pattern, $replaced_text)) {
                    $value2 = empty($value) ? $user->getAttribute(str_replace(['{', '}'], '', $key)) : $value;
                    $replaced_text = preg_replace($pattern, $value2, $replaced_text);
                }
            }
            $replaced_text = preg_replace("/[[:blank:]]+/"," ",$replaced_text);
            /* replaced text message */

            dispatch((new SendUnpaidInvoice($user->id, $this->invoice->id, $template->name, $replaced_text)));

            $this->dispatch('success', message: 'Submitted.');
            return $this->redirect('/admin/unpaid-invoices', navigate:false);


        } else {
            $this->dispatch('warning', message: 'SMTP Server is not Available!!!');
            return;
        }
    }


    public function render()
    {

        if(role_name(Auth::user()->id) == 'Administrator'){
            $data['lists'] = Invoice::where('status', 'unpaid')->paginate(50);
        } elseif(role_name(Auth::user()->id) == 'Customer'){
            $data['lists'] = Invoice::where('user_id', Auth::user()->id)->where('status', 'unpaid')->paginate(50);
        } elseif(role_name(Auth::user()->id) == 'Employee'){
            $data['lists'] = [];
        }


        $data['templates'] = Template::all();


        $data['body'] = $this->template ? Template::find($this->template)->body : '';
        
        return view('livewire.unpaid-invoices',  $data);
    }
}
