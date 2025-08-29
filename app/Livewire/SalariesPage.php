<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class SalariesPage extends Component
{
    public $row = null;
    public $role = null;


    function mount($user_id) {
        $this->row = User::findOrFail($user_id);
        $this->role = role_name($user_id);
    }

    public function render()
    {
        return view('livewire.salaries-page');
    }
}
