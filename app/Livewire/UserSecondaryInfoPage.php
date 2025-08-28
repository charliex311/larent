<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Secondaryinfo;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserSecondaryInfoPage extends Component
{
    public $role;

    public $info;
    public $row;
    public $email;
    public $phone;
    public $usrid;
    

    public function mount(Request $request)
    {
        $this->usrid = $request->id;
        $this->row   = User::withTrashed()->find($request->id) ? User::withTrashed()->find($request->id) : null;
        $this->role  = $request->type;
    }

    public function edit($id)
    {
        $this->reset(['info','email','phone']);
        $this->info = Secondaryinfo::find($id);
        $this->email = $this->info ? $this->info->email : $this->email;
        $this->phone = $this->info ? $this->info->phone : $this->phone;
    }

    public function delete($id)
    {
        $info = Secondaryinfo::find($id);
        if ($info) {
            $info->delete();
            session()->flash('success', 'Deleted Successfully.');
            return $this->redirect('/admin/edit-secondary-info?id='.$this->row->id.'&&type='.$this->role, navigate:true);
        }
    }


    public function saveChanges()
    {
        $this->validate(
            [
                'email' => 'required',
                'phone' => 'required',
            ],
            [
                'email.required' => 'Enter Email Address',
                'phone.required' => 'Enter Phone Number',
            ]
        );

        $type = '';
        $message = '';

        if ($this->info) {
            $this->info->update([
                'email' => $this->email,
                'phone' => $this->phone,
            ]);
            $type = 'close_seconday_modal';
            $message = 'Updated Successfully.';
        } else {
            Secondaryinfo::create([
                'user_id' => $this->row->id,
                'email' => $this->email,
                'phone' => $this->phone,
            ]);
            $type = 'close_seconday_modal';
            $message = 'Added Successfully.';
        }
        session()->flash('success', $message);
        $this->reset(['info','email','phone']);
        return $this->redirect('/admin/edit-secondary-info?id='.$this->row->id.'&&type='.$this->role, navigate:true);
    }

    public function render()
    {
        $data['lists'] = Secondaryinfo::where('user_id', $this->row->id)->get();
        return view('livewire.user-secondary-info-page', $data);
    }
}
