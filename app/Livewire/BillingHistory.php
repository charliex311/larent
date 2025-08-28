<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Emplyeetransaction;
use App\Models\Withdraw;
use App\Models\Deposithistory;
use App\Models\Customertransaction;
use App\Models\Paymentmethod;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class BillingHistory extends Component
{
    use WithPagination;

    public $payment_method_name;
    public $deposit_amount;
    public $deposit_transaction_id;
    public $notes;

    

    public function makeWithdraw($amount)
    {
        $amount = doubleval($amount);
        if ($amount > 0) {


            if (checkPaymentDetails(Auth::user()->id) == false) {
                $this->dispatch('warning', message: 'Unable to Withdraw! Bank Information Not Found!!!');
                return;
            }
            $withdraw = Withdraw::create([
                'user_id' => Auth::user()->id,
                'transaction_id' => invoice_prefix(Auth::user()->id) ? strtoupper(invoice_prefix(Auth::user()->id)) . strtoupper(uniqid()) : 'TX'. strtoupper(uniqid()),
                'amount' => $amount,
                'payment_details' => paymentDetails(Auth::user()->id)
            ]);
            if ($withdraw) {
                Emplyeetransaction::create([
                    'user_id'     => Auth::user()->id,
                    'withdraw_id' => $withdraw->id,
                    'amount'      => -$amount,
                    'type'        => 'withdraw',
                    'status'      => 'unpaid',
                ]);
            }
            return $this->redirect('/admin/billing-history', navigate:true);
        } else {
            $this->dispatch('warning', message: 'Insufficient Balance.');
            return;
        }
    }

    public function topUp()
    {
        $this->validate(
            [
                'payment_method_name' => 'required',
                'deposit_amount' => 'required',
                'deposit_transaction_id' => 'required',
            ],
            [
                'payment_method_name.required' => 'Select Payment Method.',
                'deposit_amount.required' => 'Enter Deposit Amount.',
                'deposit_transaction_id.required' => 'Enter Transaction id',
            ]
        );

        

        $payment_method_row = Paymentmethod::where('name',  $this->payment_method_name)->first();
        
        if ($payment_method_row) {
            if ($payment_method_row->status == 'disable') {
                $this->dispatch('warning', message: 'Payment Method You Selected is Currently Disabled.');
                return;
            }
        }

        $deposit = Deposithistory::create([
            'user_id' => Auth::user()->id,
            'payment_method' => $this->payment_method_name ? $this->payment_method_name : null,
            'payment_details' => $this->deposit_transaction_id ? $this->deposit_transaction_id : null,
            'amount' => $this->deposit_amount ? $this->deposit_amount : 0.00,
            'notes' => $this->notes,
        ]);

        if ($deposit) {
            Customertransaction::create([
                'user_id' => $deposit->user_id,
                'amount'  => 0,
                'transaction_id' => $deposit->payment_details,
                'deposithistory_id' => $deposit->id,
                'type'    => 'deposit',
                'status'  => 'in_review'
            ]);
        }



        if ($deposit) {
            $this->dispatch('success', message: 'Submitted for Review.');
        }

        
        return $this->redirect('/admin/billing-history', navigate:true);
    }

    public function render()
    {
        if ($this->payment_method_name) {
            $selectMethod = Paymentmethod::where('name', 'LIKE', '%'.$this->payment_method_name.'%')->first();
            if($selectMethod){
                $data['payment_details'] = $selectMethod->details;
            } else {
                $data['payment_details'] = '';
            }
        } else {
            $data['payment_details'] = '';
        }
        $data['total_amount'] = Emplyeetransaction::where('user_id',Auth::user()->id)->sum('amount');

        $data['withdraws'] = Withdraw::where('user_id',Auth::user()->id)->paginate(50);
        
        
        $data['lists'] = Customertransaction::where('user_id',Auth::user()->id)->latest()->paginate(50);

        $data['payment_methods'] = Paymentmethod::where('status', 'enable')->get();
        $this->dispatch('balance-updated');
        return view('livewire.billing-history', $data);
    }
}
