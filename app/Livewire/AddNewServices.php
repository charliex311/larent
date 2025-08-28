<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Service;
use App\Models\Secondarycontact;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Livewire\WithPagination;

class AddNewServices extends Component
{

    use WithPagination;

    public $role;

    public $info;
    public $row;
    public $service_id;
    public $person_id;
    public $keyword;

    public function mount(Request $request)
    {
        $this->row = User::withTrashed()->find($request->id) ? User::withTrashed()->find($request->id) : null;
        $this->role = $request->type;
    }

    public function search()
    {
        // code here
    }

    public function addService()
    {
        $this->validate(['service_id' => 'required'],['service_id.required' => 'Select Service']);
        $service = Service::find($this->service_id);
        if ($service) {
            $service->update([
                'user_id' => $this->row->id,
            ]);
            session()->flash('success', 'Service Added Successfully.');
            return $this->redirect('/admin/add-new-services?id='.$this->row->id.'&&type='.$this->role, navigate:true);
        }
    }

    public function selectedRow($id)
    {
        $service = Service::find($id);
        if ($service) {
            $this->info = $service;
        }
    }

    public function setContactPerson()
    {
        $this->validate(['person_id' => 'required'],['person_id.required' => 'Select Contact Person.']);
        if ($this->info) {
            $this->info->update(['secondarycontact_id' => $this->person_id]);
            session()->flash('success', 'Contact has been Added.');
            return $this->redirect('/admin/add-new-services?id='.$this->row->id.'&&type='.$this->role, navigate:true);
        }
    }

    public function delete($id)
    {
        $service = Service::find($id);
        if ($service) {
            $service->update([
                'user_id' => null,
                'secondarycontact_id' => null,
            ]);
            session()->flash('success', 'Removed Successfully.');
        }
        return $this->redirect('/admin/add-new-services?id='.$this->row->id.'&&type='.$this->role, navigate:true);
    }

    public function render()
    {
        $data['lists'] = Service::latest()
        ->when($this->keyword, function($query, $keyword){
            return $query->where('title', 'LIKE', '%'.$keyword.'%')
            ->orWhere('unit', 'LIKE', '%'.$keyword.'%');
        })
        ->where('user_id', $this->row->id)
        ->paginate(25);
        $data['services'] = Service::where('user_id', NULL)->get();
        $data['contact_persons'] = Secondarycontact::where('user_id', $this->row->id)->get();
        return view('livewire.add-new-services', $data);
    }
}
