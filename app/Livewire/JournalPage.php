<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Joblist;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class JournalPage extends Component
{

    public $user_id;
    public $job_id;
    public $journals_data=[];


    protected $listeners = ['refreshJournals'];

    public function refreshJournals()
    {
        $this->filter();
    }

    public function filter()
    {
        $jobIds = Joblist::when($this->job_id, function($query, $job_id) {
            return $query->where('id', $job_id);
        })->when($this->user_id, function($query, $user_id) {
            return $query->where('user_id', $user_id);
        })->where('job_status', '4')->latest()->pluck('id')->toArray(); // 

        $auth_type = role_name(Auth::user()->id);
        $user_id   = Auth::user()->id;
        $this->journals_data = journaLists($jobIds, $auth_type, $user_id);
    }


    public function render()
    {
        $data['jobs'] = Joblist::all();
        $data['customers'] = User::role('Customer')->get();
        
        return view('livewire.journal-page', $data);
    }
}
