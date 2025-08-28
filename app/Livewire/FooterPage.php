<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Setting;
use App\Models\User;

class FooterPage extends Component
{

    public $row;
    public $profile_row;
    public $company_name;
    public $postal_code;
    public $street;
    public $city;
    public $country;
    public $mobile;
    public $website;
    public $email;
    public $tax_number;
    public $ust_idnr;
    public $business_number;
    public $bank;
    public $bic;
    public $iban;

    public function mount()
    {
        $this->row = Setting::find(1) ? Setting::find(1) : null;
        $this->profile_row = User::find(1) ? User::find(1) : null;
        $this->company_name = $this->row ? $this->row->company : $this->company_name;
        $this->street = $this->profile_row ? $this->profile_row->street : $this->street;
        $this->postal_code = $this->profile_row ? $this->profile_row->postal_code : $this->postal_code;
        $this->city = $this->profile_row ? $this->profile_row->city : $this->city;
        $this->country = $this->profile_row ? $this->profile_row->country : $this->country;
        $this->mobile = $this->profile_row ? $this->profile_row->phone : $this->mobile;
        $this->website = $this->row ? $this->row->website : $this->website;
        $this->email = $this->profile_row ? $this->profile_row->email : $this->email;
        $this->tax_number = $this->row ? $this->row->fiscal_number : $this->tax_number;
        $this->ust_idnr = $this->row ? $this->row->ust_idnr : $this->ust_idnr;
        $this->business_number = $this->row ? $this->row->business_number : $this->business_number;
        $this->bank = $this->row ? $this->row->bank : $this->bank;
        $this->bic = $this->row ? $this->row->bic : $this->bic;
        $this->iban = $this->row ? $this->row->iban : $this->iban;
    }


    public function render()
    {
        return view('livewire.footer-page');
    }
}
