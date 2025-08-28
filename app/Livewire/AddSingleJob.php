<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Joblist;
use App\Models\User;

class AddSingleJob extends Component
{
    public function render()
    {
        return view('livewire.add-single-job');
    }
}
