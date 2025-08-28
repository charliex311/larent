<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;
use App\Models\Docverify;
use Illuminate\Support\Facades\Auth;

class DocumentViewPage extends Component
{

    public $row;

    public function mount(Request $request)
    {
        $this->row = Docverify::find($request->id);
    }

    public function approve($id)
    {
        if(role_name(Auth::user()->id) == 'Employee')
        {
            return;
        }
        Docverify::find($id)->update(['status' => 1]);
        return $this->redirect('/admin/document-page', navigate:true);
    }

    public function reject($id)
    {
        if(role_name(Auth::user()->id) == 'Employee')
        {
            return;
        }
        Docverify::find($id)->update(['status' => 2]);
        return $this->redirect('/admin/document-page', navigate:true);
    }


    public function render()
    {
        return view('livewire.document-view-page');
    }
}
