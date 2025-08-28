<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AddAddressPage extends Component
{

    public $role;

    public $info;
    public $row;

    public $street;
    public $postal_code;
    public $city;
    public $country;
    public $address_for;
    public $usrid;

    public function mount(Request $request)
    {
        $this->usrid = $request->id;
        $this->row   = User::withTrashed()->find($request->id) ? User::withTrashed()->find($request->id) : null;
        $this->role  = $request->type;
    }

    public function edit($id)
    {
        $this->cleanFields();
        $this->info = Address::find($id);
        $this->street = $this->info ? $this->info->street : $this->street;
        $this->postal_code = $this->info ? $this->info->postal_code : $this->postal_code;
        $this->city = $this->info ? $this->info->city : $this->city;
        $this->country = $this->info ? $this->info->country : $this->country;
        $this->address_for = $this->info ? $this->info->address_for : $this->address_for;
    }

    public function delete($id)
    {
        $info = Address::find($id);
        if ($info) {
            $info->delete();
            session()->flash('success', 'Deleted Successfully.');
            return $this->redirect('/admin/add-address?id='.$this->row->id.'&&type='.$this->role, navigate:true);
        }
    }


    public function saveChanges()
    {
        $this->validate(
            [
                'street' => 'required',
                'postal_code' => 'required',
                'city' => 'required',
                'country' => 'required',
                'address_for' => 'required',
            ],
            [
                'street.required' => 'Enter Street',
                'postal_code.required' => 'Enter Postal Code',
                'city.required' => 'Enter City',
                'country.required' => 'Enter Country',
                'address_for.required' => 'Select',
            ]
        );

        $type = '';
        $message = '';

        if ($this->info) {
            $this->info->update([
                'street' => $this->street,
                'postal_code' => $this->postal_code,
                'city' => $this->city,
                'country' => $this->country,
                'address_for' => $this->address_for,
            ]);
            $type = 'close_address_modal';
            $message = 'Updated Successfully.';
        } else {
            Address::create([
                'user_id' => $this->row->id,
                'street' => $this->street,
                'postal_code' => $this->postal_code,
                'city' => $this->city,
                'country' => $this->country,
                'address_for' => $this->address_for,
            ]);
            $type = 'close_address_modal';
            $message = 'Added Successfully.';
        }
        session()->flash('success', $message);
        return $this->redirect('/admin/add-address?id='.$this->row->id.'&&type='.$this->role, navigate:true);
    }

    public function cleanFields()
    {
        $this->reset(['info','street','postal_code','city','country','address_for']);
    }


    public function render()
    {
        $data['lists'] = Address::where('user_id',$this->row->id)->get();
        return view('livewire.add-address-page', $data);
    }
}