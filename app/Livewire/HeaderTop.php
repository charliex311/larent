<?php

namespace App\Livewire;

use Livewire\Component;

class HeaderTop extends Component
{


    protected $listeners = ['balance-updated'];

    public function dataRefresh()
    {
        //
    }


    public function render()
    {

        $this->dataRefresh();
        return view('livewire.header-top');
    }
}
