<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\User;
use App\Models\Invoice;
use App\Models\Address;
use App\Models\Joblist;
use App\Models\Setting;

use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;

class GenerateInvoice extends Component
{

    public $customer;
    public $billing_address;
    public $current_date;
    public $invoice_prefix='_';
    public $random_invoice_number;
    public $start_date;
    public $end_date;

    public $jobs=[];


    public $total_customer_price = 0;
    public $total_tax = 0;
    public $total_price = 0;

    public $currency;
    public $invoice;

    public function mount(Request $request)
    {
        $this->invoice = Invoice::find($request->id);

        if ($this->invoice) {
            $this->random_invoice_number = $this->invoice->invoice_number;
            $this->customer = $this->invoice->user_id;
            $this->current_date = $this->invoice->date->toDateString();
            $this->start_date = $this->invoice->start_date->toDateString();
            $this->end_date = $this->invoice->end_date->toDateString();
        } else {
            $this->random_invoice_number = intval(last_invoice_number()) + 1 ;
           $this->current_date = now()->toDateString();
        }
    }
    

    public function getJobs()
    {
        if ($this->start_date && $this->end_date && $this->customer) {
            $startOfDay = Carbon::parse($this->start_date)->startOfDay();
            $endOfDay = Carbon::parse($this->end_date)->endOfDay();

            if ($this->invoice) {
                $this->jobs = Joblist::where('user_id', $this->customer)
                ->where('job_status','4')
                ->where(function ($query) use ($startOfDay, $endOfDay) {
                    $query->whereBetween('job_date', [$startOfDay, $endOfDay])
                        ->orWhereNull('job_date')
                        ->orWhere(function ($innerQuery) use ($startOfDay, $endOfDay) {
                            $innerQuery->whereBetween('checkout', [$startOfDay, $endOfDay])
                                ->whereNull('job_date');
                        });
                })
                ->get();
            } else {
                $this->jobs = Joblist::where('user_id', $this->customer)
                ->where('invoice_created','=','no')
                ->where('job_status','4')
                ->where(function ($query) use ($startOfDay, $endOfDay) {
                    $query->whereBetween('job_date', [$startOfDay, $endOfDay])
                        ->orWhereNull('job_date')
                        ->orWhere(function ($innerQuery) use ($startOfDay, $endOfDay) {
                            $innerQuery->whereBetween('checkout', [$startOfDay, $endOfDay])
                                ->whereNull('job_date');
                        });
                })
                ->get();
            }

            $this->currency = currencySign();
        } else {
            $this->jobs = [];
            $this->currency = '';
        }

        // calculating prices & tax

        $total_customer_price = 0;
        $total_tax = 0;
        $total_price = 0;

        foreach($this->jobs as $jobitem){
            $total_customer_price += calculateTotalBillAmount(getTotalHour($jobitem->id), $jobitem->hourly_rate, $jobitem->id);
            $total_tax += calculateTaxUsingCustomerPrice($jobitem->id);
        }

        $this->total_customer_price = doubleval($total_customer_price);
        $this->total_tax = doubleval($total_tax);
        $total_price = $total_customer_price + $total_tax;
        $this->total_price = doubleval($total_price);
    }



    public function generate()
    {
        $this->validate(
            [
                'customer'              => 'required',
                'billing_address'       => 'required',
                'current_date'          => 'required',
                'random_invoice_number' => 'required',
                'start_date'            => 'required',
                'end_date'              => 'required',
                'total_customer_price'  => 'required',
                'total_price'           => 'required',
            ],
            [
                'customer.required'              => 'Select Customer',
                'billing_address.required'       => 'Enter Billing Address',
                'current_date.required'          => 'select Date',
                'random_invoice_number.required' => 'Invoice Number is Required.',
                'start_date.required'            => 'Select Start Job Date',
                'end_date.required'              => 'Select End Job Date',
                'total_customer_price.required'  => 'Select End Job Date',
                'total_price.required'           => 'Select End Job Date',
            ]
        );


        $directoryName = 'pdfs';
        $directoryPath = storage_path('app/public/'.$directoryName);

        if (!File::exists($directoryPath)) {
            File::makeDirectory($directoryPath);
        }

        if($this->invoice){

            $removalIDS = $this->invoice->jobs->pluck('id')->toArray();
            Joblist::whereIn('id', $removalIDS)->update(['invoice_id'=>null,'invoice_created'=>'no']);

            $UpdatingIDS = $this->jobs->pluck('id')->toArray();
            Joblist::whereIn('id', $UpdatingIDS)->update(['invoice_id'=>$this->invoice->id,'invoice_created'=>'yes']);
            
            $this->invoice->update([
                'user_id'              => $this->customer,
                'billing_address'      => $this->billing_address,
                'total_customer_price' => $this->total_customer_price,
                'total_tax'            => $this->total_tax,
                'total_price'          => $this->total_price,
                'currency'             => $this->currency,
                'date'                 => parseDateTime($this->current_date),
                'start_date'           => parseDateTime($this->start_date),
                'end_date'             => parseDateTime($this->end_date),
            ]);

            $setting_row = Setting::where('user_id', 1)->first();
            $current_invoice_number = 0;
            if ($setting_row) {
                $current_invoice_number = $setting_row ? $setting_row->invoice_number : 0;
                $current_invoice_number+=1;
                $setting_row->update(['invoice_number' => $current_invoice_number]);
            }

            $row = $this->invoice;
            $data['row'] = $row;
            $data['currency'] = $this->invoice ? $this->invoice->currency : currencySign();
            $data['company']  = Setting::where('user_id', 1)->first();
            $data['jobs']     = Joblist::where('invoice_id',$this->invoice->id)->get();
            // Use Dompdf options to set configuration
            $options = new Options();
            $options->set('isHtml5ParserEnabled', true);
            $options->set('isPhpEnabled', true);
            $options->set('isRemoteEnabled', true);
            $options->set('enable_javascript', true);
            $dompdf = new Dompdf($options);
            $html = view('pdf.customer-invoice', $data)->render();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('letter', 'portrait');
            $dompdf->render();
            // Save the PDF file locally
            $pdfOutput = $dompdf->output();
            $filename = '_invoice' . uniqid('', true).'.pdf';
            $path = storage_path("app/public/pdfs/{$filename}");
            $row->update(['generated_invoice' => $filename]);
            file_put_contents($path, $pdfOutput);

            $this->dispatch('success',  message: 'Invoice ID :'.$this->invoice->invoice_number.' has been Updated.');
    
        } else {
            //
            $invoice = Invoice::create([
                'user_id'              => $this->customer,
                'billing_address'      => $this->billing_address,
                'invoice_number'       => intval(last_invoice_number()) + 1,
                'total_customer_price' => $this->total_customer_price,
                'total_tax'            => $this->total_tax,
                'total_price'          => $this->total_price,
                'currency'             => $this->currency,
                'date'                 => parseDateTime($this->current_date),
                'start_date'           => parseDateTime($this->start_date),
                'end_date'             => parseDateTime($this->end_date),
            ]);
    
            if ($invoice) {
                foreach($this->jobs as $jobitem){
                    $jobitem->update([
                        'invoice_id'      => $invoice->id,
                        'invoice_created' => 'yes',
                    ]);
                }

                $row              = $invoice;
                $data['row']      = $row;
                $data['currency'] = $invoice ? $invoice->currency : currencySign();
                $data['company']  = Setting::where('user_id', 1)->first();
                $data['jobs']     = $invoice ? $invoice->jobs : [];
                // Use Dompdf options to set configuration
                $options = new Options();
                $options->set('isHtml5ParserEnabled', true);
                $options->set('isPhpEnabled', true);
                $options->set('isRemoteEnabled', true);
                $options->set('enable_javascript', true);
                $dompdf = new Dompdf($options);
                $html   = view('pdf.customer-invoice', $data)->render();
                $dompdf->loadHtml($html);
                $dompdf->setPaper('letter', 'portrait');
                $dompdf->render();
                // Save the PDF file locally
                $pdfOutput = $dompdf->output();
                $filename  = fullName($this->customer).'_'.uniqid('', true).'.pdf';
                $path      = storage_path("app/public/pdfs/{$filename}");
                $row->update(['generated_invoice' => $filename]);
                file_put_contents($path, $pdfOutput);
                $this->dispatch('success',  message: 'Invoice ID :'.$invoice->invoice_number.' has been generated.');
            }
        }

        return $this->redirect('/admin/unpaid-invoices', navigate:true);

    }



    public function render()
    {

        $this->getJobs();

        if ($this->customer) {
           $getCustomer = User::find($this->customer);
            if ($getCustomer) {
                $billing = Address::where('user_id', $getCustomer->id)->where('address_for', 'billing')->first();
                $this->billing_address = $billing ? customerBillingAddress($billing->id): '';
                $this->invoice_prefix = invoice_prefix($getCustomer->id);
            } else {
                $this->billing_address =  null;
                $this->invoice_prefix = '_';
            }
        } else {
            $this->billing_address =  null;
            $this->invoice_prefix = '_';
        }
        $data['customers'] = User::role('Customer')->get();
        return view('livewire.generate-invoice', $data);
    }
}
