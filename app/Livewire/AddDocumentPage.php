<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\User;
use App\Models\Docverify;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\File;

class AddDocumentPage extends Component
{

    use WithFileUploads;

    public $role;

    public $info;
    public $row;

    public $name;
    public $file;
    public $usrid;

    public function mount(Request $request)
    {
        $this->usrid = $request->id;
        $this->row   = User::withTrashed()->find($request->id) ? User::withTrashed()->find($request->id) : null;
        $this->role  = $request->type;
    }

    public function edit($id)
    {
        $this->cleanFields();
        $this->info = Docverify::find($id);
        $this->name = $this->info ? $this->info->type : $this->name;
    }

    public function delete($id)
    {
        $info = Docverify::find($id);
        if ($info) {
            $file_path = public_path().'/storage/'.$info->file;
            if(file_exists($file_path)) {
                unlink($file_path);
            }
            $info->delete();
            session()->flash('success', 'Deleted Successfully.');
            return $this->redirect('/admin/add-documents?id='.$this->row->id.'&&type='.$this->role, navigate:true);
        }
    }


    public function saveChanges()
    {
        $this->validate(['name' => 'required'],['name.required' => 'Enter Street']);
        $type = '';
        $message = '';
        $filename = '';
        if ($this->file) {
            $extentions = ["png","jpg","jpeg","pdf","docx"];
            $extension = $this->file->getClientOriginalExtension();
            if (in_array($extension, $extentions)) {
                $filename = $this->file->store('verification', 'public');
            } else {
                $this->dispatch('warning', message: 'Only jpg,jpeg,png,pdf & docx files are allowed.');
                return;
            }
        } else {
            $filename = $this->info ? $this->info->file : null;
        }

        if ($this->info) {
            $this->info->update([
                'type' => $this->name,
                'file' => $filename,
            ]);
            $type = 'close_document_modal';
            $message = 'Updated Successfully.';
        } else {
            Docverify::create([
                'user_id' => $this->row->id,
                'type' => $this->name,
                'file' => $filename,
            ]);
            $type = 'close_document_modal';
            $message = 'Uploaded Successfully.';
        }

        session()->flash('success', $message);
        return $this->redirect('/admin/add-documents?id='.$this->row->id.'&&type='.$this->role, navigate:true);
    }


    public function cleanFields()
    {
        $this->reset(['info','name','file']);
    }

    public function render()
    {
        $data['lists'] = Docverify::where('user_id',$this->row->id)->get();
        return view('livewire.add-document-page', $data);
    }
}
