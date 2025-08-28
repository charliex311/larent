<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Optionalproduct;
use Illuminate\Http\Request;
use Livewire\WithFileUploads;


class AddOptionalProduct extends Component
{
    use WithFileUploads;

    public $name;
    public $currency;
    public $price;
    public $icon;
    public $status;

    public $row;

    public function mount(Request $request)
    {
        $this->row = OptionalProduct::find($request->id) ?? null;
        $this->name = $this->row ? $this->row->name : $this->name; 
        $this->currency = $this->row ? $this->row->currency : currencySign(); 
        $this->price = $this->row ? $this->row->add_on_price : $this->price; 
        $this->icon = $this->row ? $this->row->icon : $this->icon;
        $this->status = $this->row ? $this->row->status : '1';
    }

    public function saveChanges()
    {
        $this->validate(
            [
                'name'     => 'required',
                'currency' => 'required',
                'price'    => 'required',
                'status'   => 'required',
            ],
            [
                'name.required'     => 'Enter Product Name.',
                'currency.required' => 'Select Currency.',
                'price.required'    => 'Enter Price.',
                'status.required'   => 'Select Status.'
            ]
        );


        //  product image
        $icon = null;
        if ($this->icon){
            if($this->icon->getClientOriginalExtension() == 'png' || $this->icon->getClientOriginalExtension() == 'jpg' || $this->icon->getClientOriginalExtension() == 'jpeg'){
                $icon = uploadFTP($this->icon);
            } else {
                $this->dispatch('warning', message: 'Only jpg, jpeg & png');
                return;
            }
        } else {
            $icon = $this->row ? $this->row->icon : null;
        }

        if ($this->row) {
            $this->row->update([
                'name'         => $this->name,
                'status'       => $this->status,
                'icon'         => $icon,
                'currency'     => $this->currency,
                'add_on_price' => $this->price
            ]);

            $message = 'Updated Successfully.';
        } else {
            Optionalproduct::create([
                'name'         => $this->name,
                'status'       => $this->status,
                'icon'         => $icon,
                'currency'     => $this->currency,
                'add_on_price' => $this->price
            ]);
            $message = 'Created Successfully.';
        }

        $this->dispatch('success', message: $message);
        return $this->redirect('/admin/optional-products', navigate:true);
    }


    public function render()
    {
        return view('livewire.add-optional-product');
    }
}
