<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Withdraw;
use Livewire\WithPagination;

class WithdrawUnpaid extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public function approveNow($id)
    {
       $row = Withdraw::find($id);
       if ($row) {
            $transaction = $row->transactions()->first();
            if ($transaction) {
                $transaction->update(['status' => 'paid']);
                $row->update(['status' => 'paid']);
                $this->dispatch('success',message: 'Approved Successfully.');
            }
       }
    }


    public function rejectNow($id)
    {
        $row = Withdraw::find($id);
       if ($row) {
            $row->update(['status' => 'reject']);
            $this->dispatch('warning', message: 'Rejected.');
       }
    }

    public function render()
    {
        $data['lists'] = Withdraw::where('status','unpaid')->latest()->paginate(20);
        return view('livewire.withdraw-unpaid', $data);
    }
}
