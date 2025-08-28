<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;
use App\Models\Joblist;
use Illuminate\Support\Facades\Auth;

class ViewWorkHour extends Component
{
    public $job;

    public function mount(Request $request)
    {
        $this->job = Joblist::find($request->job) ?? NULL;
    }


    public function render()
    {
        $data['tasks'] = $this->job ? $this->job->tasks : [];
        return view('livewire.view-work-hour', $data);
    }
}
