<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Customertransaction;
use Illuminate\Support\Facades\Auth;

class InvoicePayment extends Component
{

    public $invoice;
    public $currency;
    public $id;
    public $transaction_id;
    public $amount;
    public $date;
    public $remarks;

    public function mount(Request $request)
    {
        $this->id = $request->id;
        $this->invoice = Invoice::find($request->id);
    }

    public function delete($id)
    {
        $row = Customertransaction::find($id);
        if ($row) {
            $row->delete();
        }
        $this->redirect('/admin/invoice-payments?id='.$this->id);
    }

    public function makePaymentNow()
    {
        $row = Customertransaction::find($this->transaction_id);

        if (role_name(Auth::user()->id) == 'Administrator') {

            $this->validate([
                'amount'  => 'required',
                'date'    => 'required',
                'remarks' => 'required'
            ]);

            if ($row) {
                $row->update([
                    'amount' => -$this->amount,
                    'date'   => $this->date,
                    'type'   => $this->remarks,
                    'status' => 'success',
                ]);
            } else {
                Customertransaction::create([
                    'user_id'    => $this->invoice->user_id,
                    'invoice_id' => $this->invoice->id,
                    'amount'     => -$this->amount,
                    'date'       => $this->date,
                    'type'       => $this->remarks,
                    'status'     => 'success',
                ]);
            }
            $this->redirect('/admin/invoice-payments?id='.$this->id);
        }
    }

    public function resetFields()
    {
        $this->reset(['amount','date','remarks','transaction_id']);
    }



    public function render()
    {
        $data['transactions']      = Customertransaction::where('invoice_id', $this->id)->get();
        $data['customer_name']     = fullName($this->invoice->user_id);
        $data['customer_date']     = parseDateOnly($this->invoice->date);
        $data['total_price']       = $this->invoice->total_price.' '.currencySign(1);
        $data['remaining_balance'] = balanceRemain($this->id) == 0 ? '0.00 '.currencySign(1) : balanceRemain($this->id).' '.currencySign(1);
        return view('livewire.invoice-payment', $data);
    }
}
