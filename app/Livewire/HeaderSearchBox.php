<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class HeaderSearchBox extends Component
{
    public $name;


    public function render()
    {

        $data['lists'] = User::when($this->name, function($query, $name){
            return $query->where('first_name', 'LIKE', '%'.$name.'%')
            ->orWhere('last_name', 'LIKE', '%'.$name.'%')
            ->orWhere('email', 'LIKE', '%'.$name.'%')
            ->orWhere('phone', 'LIKE', '%'.$name.'%');
        })->where('id','!=', 1)->limit(10)->get();

        return view('livewire.header-search-box', $data);
    }
}
