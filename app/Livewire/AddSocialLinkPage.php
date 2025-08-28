<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Social;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class AddSocialLinkPage extends Component
{

    public $role;

    public $info;
    public $row;
    public $name;
    public $link;
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
        $this->info = Social::find($id);
        $this->name = $this->info ? $this->info->name : $this->name;
        $this->link = $this->info ? $this->info->link : $this->link;
    }

    public function delete($id)
    {
        $info = Social::find($id);
        if ($info) {
            $info->delete();
            session()->flash('success', 'Deleted Successfully.');
            return $this->redirect('/admin/add-social-links?id='.$this->row->id.'&&type='.$this->role, navigate:true);
        }
    }

    public function saveChanges()
    {
        $this->validate(
            [
                'name' => 'required',
                'link' => 'required',
            ],
            [
                'name.required' => 'Enter Street',
                'link.required' => 'Enter Postal Code',
            ]
        );

        $type = '';
        $message = '';

        if ($this->info) {
            $this->info->update([
                'name' => $this->name,
                'link' => $this->link,
            ]);
            $type = 'close_social_modal';
            $message = 'Updated Successfully.';
        } else {
            Social::create([
                'user_id' => $this->row->id,
                'name' => $this->name,
                'link' => $this->link,
            ]);
            $type = 'close_social_modal';
            $message = 'Added Successfully.';
        }

        session()->flash('success', $message);
        return $this->redirect('/admin/add-social-links?id='.$this->row->id.'&&type='.$this->role, navigate:true);
    }

    public function cleanFields()
    {
        $this->reset(['info','name','link']);
    }


    public function render()
    {
        $data['lists'] = Social::where('user_id',$this->row->id)->get();
        return view('livewire.add-social-link-page', $data);
    }
}
