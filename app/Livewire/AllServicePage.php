<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Service;
use Livewire\WithPagination;

class AllServicePage extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $row;


    public function viewAddress($id)
    {
        $this->cleanFields();
        $this->row = Service::find($id) ?? NULL;
    }

    public function cleanFields()
    {
        $this->reset('row');
    }

    public function changeSpeciality($id)
    {
        $data = Service::find($id) ?? NULL;
        if ($data) {
            
            if ($data->speciality == 'normal') {
                $data->update(['speciality' => 'special']);
                return $this->redirect('/admin/services');
            }

            if ($data->speciality == 'special') {
                $data->update(['speciality' => 'normal']);
                return $this->redirect('/admin/services');
            }
        }
    }


    public function changeRegularity($id)
    {
        $data = Service::find($id) ?? NULL;
        if ($data) {
            
            if ($data->regularity == 'regular') {
                $data->update(['regularity' => 'sunday']);
                return $this->redirect('/admin/services');
            }

            if ($data->regularity == 'sunday') {
                $data->update(['regularity' => 'regular']);
                return $this->redirect('/admin/services');
            }
        }
    }


    public function markActive($id)
    {
    
        $data = Service::find($id) ?? NULL;
        if ($data) {
            $data->update(['status' => '1']);
            return $this->redirect('/admin/services');
        }
    }

    public function markPending($id)
    {
    
        $data = Service::find($id) ?? NULL;
        if ($data) {
            $data->update(['status' => '0']);
            return $this->redirect('/admin/services');
        }
    }

    public function markInactive($id)
    {
    
        $data = Service::find($id) ?? NULL;
        if ($data) {
            $data->update(['status' => '2']);
            return $this->redirect('/admin/services');
        }
    }

    public function render()
    {
        $data['active_services'] = Service::where('status', 1)->orderBy('title','ASC')->get();
        $data['inactive_services'] = Service::where('status',2)->get();
        $data['pending_services'] = Service::where('status',0)->get();
        return view('livewire.all-service-page', $data);
    }
}
