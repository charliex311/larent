<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Joblist;
use Illuminate\Support\Facades\Auth;

class UserJournalPage extends Component
{

    public $row;
    public $role;
    public $usrid;

    protected $listeners = ['refreshJournals'];


    public function mount(Request $request)
    {
        $this->usrid = $request->id;
        $this->row   = User::withTrashed()->find($request->id) ? User::withTrashed()->find($request->id) : null;
        $this->role  = $request->type;
    }

    public function refreshJournals()
    {
        //
    }


    public function render()
    {

        $jobIds    = Joblist::where('job_status', '4')->latest()->pluck('id')->toArray();
        $auth_type = $this->role;
        $user_id   = $this->row->id;
        $data['journals_data'] = journaLists($jobIds, $auth_type, $user_id);

        return view('livewire.user-journal-page', $data);
    }
}
