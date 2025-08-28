<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Docverify;
use Illuminate\Support\Facades\Auth;

class ProfilePage extends Component
{

    use WithFileUploads;

    public $myfile;
    public $type;

    public function approve($id)
    {
        Docverify::find($id)->update(['status' => 1]);
        return $this->redirect('/admin/document-page', navigate:true);
    }

    public function reject($id)
    {
        Docverify::find($id)->update(['status' => 2]);
        return $this->redirect('/admin/document-page', navigate:true);
    }

    public function save()
    {
        $this->validate(
            [
                'myfile' => 'required',
                'type' => 'required',
            ]
        );
        if ($this->myfile) {
            if ($this->myfile->getClientOriginalExtension() == 'jpg' || $this->myfile->getClientOriginalExtension()) {
                $single = $this->myfile->store('verification', 'public');
                Docverify::create([
                    'user_id' => Auth::user()->id,
                    'file' => $single,
                    'type' => $this->type
                ]);
            }
            return $this->redirect('/admin/document-page', navigate:true);
        }
    }

    public function render()
    {
        $data['lists'] = role_name(Auth::user()->id) == 'Administrator' ? Docverify::get() : Docverify::where('user_id', Auth::user()->id)->get();
        return view('livewire.profile-page', $data);
    }
}
