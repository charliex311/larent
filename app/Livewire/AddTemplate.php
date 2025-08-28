<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;
use App\Models\Template;

class AddTemplate extends Component
{

    public $name;
    public $type;
    public $template;
    public $row;

    public $tags=[];
    

    public function mount(Request $request)
    {
        $this->row = Template::find($request->id) ? Template::find($request->id) : null;
        $this->name = $this->row ? $this->row->name : $this->name;
        $this->type = $this->row ? $this->row->type : $this->type;
        $this->template = $this->row ? $this->row->body : $this->template;

        $this->tags = [
            '{first_name}',
            '{last_name}',
            '{email}',
            '{phone}',
            '{company}',
            '{city}',
            '{postal_code}',
            '{country}'
        ];
    }

    public function saveChanges()
    {

        $this->validate(
            [
                'name' => 'required',
                'template' => 'required',
                'type' => 'required',
            ],
            [
                'name.required' => 'Enter Template Title.',
                'template.required' => 'Enter Email Body Content.',
                'type.required' => 'Select Type.'
            ]
        );
        $message = '';

        if ($this->row) {
            $this->row->update([
                'name'   => $this->name,
                'body' => $this->template,
                'type' => $this->type
            ]);
            $message = 'Updated.';
        } else {
            Template::create([
                'name'   => $this->name,
                'body' => $this->template,
                'type' => $this->type
            ]);
            $message = 'Created.';
        }

        $this->dispatch('success', message: $message);
        return $this->redirect('/admin/email-templates', navigate:true);
    }


    public function render()
    {

        $pre_types = Template::pluck('type')->toArray();

        $data['types'] = [
            'add_customer',
            'add_job_admin',
            'add_job_customer',
            'add_service_customer',
            'cancel_cooperation',
            'cancel_job_admin',
            'cancel_job_customer',
            'cancel_job_employee',
            'edit_job_admin',
            'edit_job_customer',
            'forgot_password',
            'move_job_admin',
            'move_job_customer',
            'stop_job_employee',
            'unpaid_invoice',
            'paid_invoice',
            'ask_for_deposit',
            'deposit_confirmation'
        ];

        $data['types'] = array_diff($data['types'], $pre_types);
        
        return view('livewire.add-template', $data);
    }
}