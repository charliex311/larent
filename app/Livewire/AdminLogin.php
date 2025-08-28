<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminLogin extends Component
{

    public $email, $password, $remember;

    public function authentication_act()
    {
        $this->validate(
            [
                'email' => 'required',
                'password' => 'required'
            ],
            [
                'email.required' => 'Enter Your E-mail ',
                'password.required' => 'Enter Your Password'
            ]
        );

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            $this->dispatch('successRedirect', message: 'Login is Successfull...');
            return $this->redirect('/admin/dashboard', navigate:false);
        } else {
            session()->flash('warning','Logged in Failed.');
            return $this->redirect('/' , navigate:true);
        }
    }


    public function render()
    {
        $data['title'] = 'Vzakeini Digital';
        return view('livewire.admin-login', $data)->layout('auth.template');
    }
}
