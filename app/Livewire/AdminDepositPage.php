<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Deposithistory;
use App\Models\Customertransaction;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class AdminDepositPage extends Component
{
    use WithPagination;

    public function approve($id)
    {
        $row = Deposithistory::find($id);
        if ($row) {

            $transaction = Customertransaction::where('transaction_id', $row->payment_details)->where('status','success')->first();
            if (!$transaction) {
                Customertransaction::create([
                    'user_id' => $row->user_id,
                    'amount'  => $row->amount,
                    'transaction_id' => $row->payment_details,
                    'deposithistory_id' => $row->id,
                    'type'    => 'deposit',
                    'status'  => 'success'
                ]);
            }

            Customertransaction::where('transaction_id', $row->payment_details)->whereIn('status',['reject','in_review'])->delete();

            

            $row->update(['status' => 'success']);
            $this->dispatch('success', message: 'Approved.');
        }
        return $this->redirect('/admin/deposit-history', navigate:true);
    }


    public function reject($id)
    {
        $row = Deposithistory::find($id);
        if ($row) {

            $transaction = Customertransaction::where('transaction_id', $row->payment_details)->first();

            if ($transaction) {
                Customertransaction::where('transaction_id', $row->payment_details)->whereIn('status',['success','in_review'])->delete();
            }

            Customertransaction::create([
                'user_id' => $row->user_id,
                'amount'  => 0,
                'transaction_id' => $row->payment_details,
                'deposithistory_id' => $row->id,
                'type'    => 'deposit',
                'status'  => 'reject'
            ]);
            $row->update(['status' => 'reject']);
            $this->dispatch('success', message: 'Rejected.');
        }
        return $this->redirect('/admin/deposit-history', navigate:true);
    }

    public function render()
    {
        $data['lists'] = Deposithistory::latest()->paginate(50);
        return view('livewire.admin-deposit-page', $data);
    }
}
