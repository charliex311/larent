<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Paymentmethod;

use App\Models\Deposithistory;
use App\Models\Stripething;

class PaymentMethodPage extends Component
{

    use WithFileUploads;
    use WithPagination;

    public $row;
    public $name;
    public $details;
    public $mylogo;
    public $status;

    public $stripe_public_key;
    public $stripe_secret_key;

    public function edit($id)
    {
        $this->reset(['row','name','details','mylogo']);
        $this->row = Paymentmethod::find($id);
        $this->name = $this->row ? $this->row->name : $this->name;
        $this->details = $this->row ? $this->row->details : $this->details;
        $this->status = $this->row ? $this->row->status : $this->status;
        
        if ($this->name == 'Stripe' || $this->name == 'stripe') {

            $stripe = Stripething::first() ? Stripething::first() : Stripething::create();
            $this->stripe_public_key = $stripe ? $stripe->public_key : $this->stripe_public_key;
            $this->stripe_secret_key = $stripe ? $stripe->secret_key : $this->stripe_secret_key;
        } else {
            $this->reset(['stripe_public_key','stripe_secret_key']);
        }
    }

    public function delete($id)
    {
        $row = Paymentmethod::find($id);
        if ($row) {
            //$row->delete();
            $this->dispatch('success', message: 'Deleted.');
            return $this->redirect('/admin/payment-method', navigate:true);
        }
    }

    public function saveChanges()
    {
        $this->validate(
            [
                'name' => 'required',
                'details' => 'required',
                'status' => 'required',
            ],
            [
                'name.required' => 'Enter Payment Method Name.',
                'details.required' => 'Enter Payment Details',
                'status.required' => 'Enter Status'
            ]
        );

        $logo = '';

        if ($this->mylogo) {
            $allowedExtensions = ['jpg', 'png', 'jpeg'];
            $fileExtension = $this->mylogo->getClientOriginalExtension();
            if (in_array($fileExtension, $allowedExtensions)) {
                $filename = $this->mylogo->getClientOriginalName();
                $logo = uploadFTP($this->mylogo);
                if ($logo) {
                    $this->reset('mylogo');
                }
            }
        }

        if ($this->row) {

            if (empty($logo)) {
                $logo = $this->row->logo;
            }

            $this->row->update([
                'name'    => $this->name,
                'details' => $this->details,
                'logo'    => $logo,
                'status'  => $this->status,
            ]);

            if ($this->name == 'Stripe' || $this->name == 'stripe') {
                $stripe = Stripething::first() ? Stripething::first() : Stripething::create();
                $stripe->update([
                    'public_key' => $this->stripe_public_key,
                    'secret_key' => $this->stripe_secret_key,
                ]);
            }
            $this->dispatch('success', message: 'Payment Method has been Updated.');
            return $this->redirect('/admin/payment-method', navigate:true);
        } else {
            Paymentmethod::create([
                'name' => $this->name,
                'details' => $this->details,
                'logo' => $logo,
                'status' => $this->status,
            ]);
            $this->dispatch('success', message: 'Payment Method has been Added.');
            return $this->redirect('/admin/payment-method', navigate:true);
        }


    }


    public function render()
    {
        $data['lists'] = Paymentmethod::paginate(20);
        return view('livewire.payment-method-page', $data);
    }
}
