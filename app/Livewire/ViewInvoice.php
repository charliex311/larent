<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Invoice;
use App\Models\Customertransaction;
use App\Models\Setting;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;


class ViewInvoice extends Component
{
    public $row;
    public $currency;

    public function mount(Request $request)
    {
        $this->row = Invoice::find($request->id);
        $this->currency = $this->row ? $this->row->currency : currencySign();
    }

    public function recievePaymentConfirm($id)
    {
        return $this->redirect('/admin/invoice-payments?id='.$id, navigate:false);
        /*if (role_name(Auth::user()->id) == 'Administrator') {
            $this->row->update(['status'=> 'paid']);
            Customertransaction::create([
                'user_id'    => $this->row->user_id,
                'invoice_id' => $this->row->id,
                'amount'     => -$this->row->total_price,
                'type'       => 'Charge for Invoice Number : '.$this->row->invoice_number,
                'status'     => 'success',
            ]);
            $this->dispatch('success', message: 'Payment Added Successfully.');
            return $this->redirect('/admin/customer-pdf-download?id='.$this->row->id);
        } else {
            return $this->redirect('/admin/view-invoice?id='.$id, navigate:true);
        }*/
    }


    public function render()
    {
        $data['company'] = Setting::where('user_id', 1)->first();
        $data['jobs'] = $this->row ? $this->row->jobs : [];
        return view('livewire.view-invoice', $data);
    }
}
