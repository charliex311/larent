<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Withdraw;
use Livewire\WithPagination;

class WithdrawPaid extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $data['lists'] = Withdraw::where('status','paid')->latest()->paginate(20);
        return view('livewire.withdraw-paid', $data);
    }
}
