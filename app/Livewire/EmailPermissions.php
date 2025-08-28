<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\User;
use App\Models\Docverify;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\File;

class EmailPermissions extends Component
{

    use WithFileUploads;

    public $role;
    public $info;
    public $row;
    public $usrid;
    public $notification='no';

    public function mount(Request $request)
    {
        $this->usrid = $request->id;
        $this->row = User::withTrashed()->find($request->id) ? User::withTrashed()->find($request->id) : null;
        $this->role = $request->type;
        $this->notification = $this->row? user_emails_permission($this->row->id):$this->notification;
    }

    public function update()
    {

        $setting = \App\Models\Setting::where('user_id', $this->row->id)->first();
        if ($setting) {
            $setting->update(['email_premissions' => $this->notification ? 'yes' : 'no']);
            session()->flash('success', 'Updated Successfully.');
            return $this->redirect('/admin/email-permissions?id='.$this->row->id.'&&type='.$this->role, navigate:true);
        }
    }


    public function render()
    {
        return view('livewire.email-permissions');
    }
}
