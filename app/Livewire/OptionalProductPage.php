<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Optionalproduct;

class OptionalProductPage extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $name;

    public function search()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        $data = Optionalproduct::find($id) ?? null;
        if ($data) {
            $data->delete();
            $type = 'success';
            $message = 'Product Has been Deleted.';
        } else {
            $type = 'warning';
            $message = 'Data Not Found.';
        }

        $this->dispatch($type, message: $message );
        return $this->redirect('/admin/optional-products', navigate:true);
    }

    public function render()
    {
        $data['lists'] = $this->name ? Optionalproduct::where('name', 'LIKE', '%'.$this->name.'%')->paginate(10) : Optionalproduct::paginate(10);
        return view('livewire.optional-product-page', $data);
    }
}
