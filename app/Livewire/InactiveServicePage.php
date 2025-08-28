<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Service;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class InactiveServicePage extends Component
{


    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $row;
    public $perpage=10;

    public $regularity='';
    public $speciality='';
    public $unit='';

    public function deleteItem($id)
    {
        $item = Service::find($id);
        if ($item) {
            $item->delete();
            $this->dispatch('success', message: 'Service Removed.');
            return;
        }
    }

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
                return;
            }

            if ($data->speciality == 'special') {
                $data->update(['speciality' => 'normal']);
                return;
            }
        }
    }


    public function changeRegularity($id)
    {
        $data = Service::find($id) ?? NULL;
        if ($data) {
            
            if ($data->regularity == 'regular') {
                $data->update(['regularity' => 'sunday']);
                return;
            }

            if ($data->regularity == 'sunday') {
                $data->update(['regularity' => 'regular']);
                return;
            }
        }
    }

    public function markActive($id)
    {
        $data = Service::find($id) ?? NULL;
        if ($data) {
            $data->update(['status' => '1']);
            return;
        }
    }

    public function markPending($id)
    {
        $data = Service::find($id) ?? NULL;
        if ($data) {
            $data->update(['status' => '0']);
            return;
        }
    }

    public function markInactive($id)
    {
        $data = Service::find($id) ?? NULL;
        if ($data) {
            $data->update(['status' => '2']);
            return;
        }
    }

    public function render()
    {
        $data['counter'] = Auth::user()->id == 1 ? Service::where('status',2)->when($this->unit , function ($query, $unit) {
            return $query->where('unit',$unit);
        })->when($this->speciality , function ($query, $speciality) {
            return $query->where('speciality',$speciality);
        })->when($this->regularity , function ($query, $regularity) {
            return $query->where('regularity',$regularity);
        })->count() : Service::where('user_id',Auth::user()->id)->when($this->unit , function ($query, $unit) {
            return $query->where('unit',$unit);
        })->when($this->speciality , function ($query, $speciality) {
            return $query->where('speciality',$speciality);
        })->when($this->regularity , function ($query, $regularity) {
            return $query->where('regularity',$regularity);
        })->where('status',2)->count() ;

        $data['lists'] = Auth::user()->id == 1 ? Service::where('status',2)->when($this->unit , function ($query, $unit) {
            return $query->where('unit',$unit);
        })->when($this->speciality , function ($query, $speciality) {
            return $query->where('speciality',$speciality);
        })->when($this->regularity , function ($query, $regularity) {
            return $query->where('regularity',$regularity);
        })->paginate($this->perpage) : Service::where('user_id',Auth::user()->id)->where('status',2)->when($this->unit , function ($query, $unit) {
            return $query->where('unit',$unit);
        })->when($this->speciality , function ($query, $speciality) {
            return $query->where('speciality',$speciality);
        })->when($this->regularity , function ($query, $regularity) {
            return $query->where('regularity',$regularity);
        })->paginate($this->perpage);


        return view('livewire.inactive-service-page', $data);
    }
}
