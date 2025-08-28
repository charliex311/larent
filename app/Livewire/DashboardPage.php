<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Pop;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardPage extends Component
{
    public $totalServices;
    public $totalJobs;
    public $totalEmployeeHours;
    public $totalEmployeePayments;
    public $totalCustomerPrice;
    public $totalMessages;
    public $totalCustomers;
    public $totalEmployees;
    public $totalEarnings;
    public $totalInvoices;
    public $totalPaid;
    public $totalDeposit;
    public $availableBalance;
    
    public $from;
    public $to;

    public function dateToDateSearch()
    {
        if (parseDateOnly($this->from) > parseDateOnly($this->to)) {
            $this->dispatch('warning', message: 'Please Input Correct Date!');
            return;
        }
    }

    public $showPopUp = false;

    public function hidePopUps($id)
    {
        $pop = Pop::find($id);
        if ($pop) {
            Auth::user()->update(['pop_id' => $pop->id]);
        }
        return $this->redirect('/admin/dashboard', navigate:true);
    }

    public function birthDayModalHide()
    {
        session(['birthday_modal_shown' => true]);
    }

    public function render()
    {
        if (Auth::user()->pop_id && globalPopID()) {
            if (Auth::user()->pop_id == globalPopID()) {
                $this->showPopUp = true;
            } else {
                $this->showPopUp = false;
            }
        }

        $data['popup'] = globalPopID() ? Pop::find(globalPopID()) : null;

        $this->totalServices          = totalServices($this->from,$this->to);
        $this->totalJobs              = totalJobs($this->from,$this->to);
        $this->totalEmployeeHours     = totalEmployeeHours($this->from,$this->to);
        $this->totalEmployeePayments  = totalEmployeePayments($this->from,$this->to);
        $this->totalCustomerPrice     = totalCustomerPrice($this->from,$this->to);

        $this->totalMessages    = totalMessages($this->from,$this->to);

        $this->totalCustomers   = totalCustomers($this->from,$this->to);
        $this->totalEmployees   = totalEmployees($this->from,$this->to);
        $this->totalEarnings    = totalEarnings($this->from,$this->to);
        $this->totalInvoices    = totalInvoices($this->from,$this->to);
        $this->totalPaid        = totalPaid($this->from,$this->to);
        $this->totalDeposit     = totalDeposit($this->from,$this->to);
        $this->availableBalance = availableBalance($this->from,$this->to);
        
        return view('livewire.dashboard-page', $data);
    }
}
