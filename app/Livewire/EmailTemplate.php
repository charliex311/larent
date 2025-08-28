<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Template;
use Livewire\WithPagination;

class EmailTemplate extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $title;

    public function search()
    {
        // code here
    }

    public function delete($id)
    {
        $row = Template::find($id) ? Template::find($id) : null;
        if ($row) {
            $row->delete();
            $this->dispatch('success', message: 'Deleted.');
        }

        return $this->redirect('/admin/email-templates', navigate:true);
    }


    public function render()
    {
        $data['templates'] = Template::where('name','LIKE', '%'. $this->title . '%')->paginate(12);
        return view('livewire.email-template', $data);
    }
}
