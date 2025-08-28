<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\Invoice;
use App\Models\Joblist;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class PaidInvoices extends Component
{

    use WithPagination;


    public function render()
    {
        if(role_name(Auth::user()->id) == 'Administrator'){
            $data['lists'] = Invoice::where('status', 'paid')->paginate(50);
        } elseif(role_name(Auth::user()->id) == 'Customer'){
            $data['lists'] = Invoice::where('user_id', Auth::user()->id)->where('status', 'paid')->paginate(50);
        } elseif(role_name(Auth::user()->id) == 'Employee'){
            $data['lists'] = [];
        }
        return view('livewire.paid-invoices', $data);
    }
}
