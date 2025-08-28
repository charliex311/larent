<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;


class UnpaidUsersPage extends Component
{


    use WithPagination;



    public function render()
    {
        $data['users'] = User::role('Customer')
        ->whereHas('customertransactions', function ($query) {
            $query->select('user_id')
                  ->selectRaw('SUM(amount) as total_amount')
                  ->groupBy('user_id')
                  ->havingRaw('SUM(amount) < 0');
        })
        ->with(['customertransactions' => function ($query) {
            $query->select('user_id')
                  ->selectRaw('SUM(amount) as total_amount')
                  ->groupBy('user_id');
        }])
        ->paginate(10);
        return view('livewire.unpaid-users-page', $data);
    }
}
