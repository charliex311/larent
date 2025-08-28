<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Secondarycontact;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class AddContactPage extends Component
{

    public $role;

    public $info;
    public $row;
    public $name;
    public $email;
    public $phone;


    public function mount(Request $request)
    {
        $this->row = User::withTrashed()->find($request->id) ? User::withTrashed()->find($request->id) : null;
        $this->role = $request->type;
    }


    public function edit($id)
    {
        $this->cleanFields();
        $this->info = Secondarycontact::find($id);
        $this->name = $this->info ? $this->info->name : $this->name;
        $this->email = $this->info ? $this->info->email : $this->email;
        $this->phone = $this->info ? $this->info->phone : $this->phone;
    }

    public function delete($id)
    {
        $info = Secondarycontact::find($id);
        if ($info) {
            $info->delete();
            session()->flash('success', 'Deleted Successfully.');
            return $this->redirect('/admin/add-contact-person?id='.$this->row->id.'&&type='.$this->role, navigate:true);
        }
    }


    public function saveChanges()
    {
        $this->validate(
            [
                'name' => 'required',
                'email' => 'required',
                'phone' => 'required',
            ],
            [
                'name.required' => 'Enter Name',
                'email.required' => 'Enter Email',
                'phone.required' => 'Enter Phone',
            ]
        );

        $type = '';
        $message = '';

        if ($this->info) {
            $this->info->update([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
            ]);
            $type = 'close_contact_person_modal';
            $message = 'Updated Successfully.';
        } else {
            Secondarycontact::create([
                'user_id' => $this->row->id,
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
            ]);
            $type = 'close_contact_person_modal';
            $message = 'Uploaded Successfully.';
        }        
        session()->flash('success', $message);
        return $this->redirect('/admin/add-contact-person?id='.$this->row->id.'&&type='.$this->role, navigate:true);
    }


    public function cleanFields()
    {
        $this->reset(['info','name','email', 'phone']);
    }


    public function render()
    {

        $data['lists'] = Secondarycontact::where('user_id',$this->row->id)->get();
        return view('livewire.add-contact-page', $data);
    }
}
