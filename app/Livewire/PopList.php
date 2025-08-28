<?php

namespace App\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\Pop;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use File;

class PopList extends Component
{

    use WithPagination;
    use WithFileUploads;


    public $image;
    public $title;
    public $description;
    public $role;
    public $user_id;
    public $status;

    public $row;


    public $search_key;
    


    public function search()
    {
        // code here
    }


    public function edit($id)
    {
        $this->row = Pop::find($id);

        $this->title = $this->row ? $this->row->title : $this->title;
        $this->description = $this->row ? $this->row->description : $this->description;
        $this->role = $this->row ? $this->row->role : $this->role;
        $this->user_id = $this->row ? $this->row->user_id : $this->user_id;
        $this->status = $this->row ? $this->row->status : $this->status;
    }


    public function delete($id)
    {
        $row = Pop::find($id);
        if ($row) {
            $row->delete();
        }
        $this->dispatch('success', message:'Deleted Successfully.');
        return $this->redirect('/admin/poplist', navigate:true);
    }



    public function savechanges()
    {
        $this->validate(
            [
                'title' => 'required',
                'description' => 'required',
                'user_id' => 'required',
                'role' => 'required',
                'status' => 'required',
            ],
            [
                'title.required' => 'Enter Title.',
                'description.required' => 'Enter Description',
                'user_id.required' => 'Enter User',
                'role.required' => 'Enter Role',
                'status.required' => 'Enter Status',
            ]
        );

        $message ='';
        $image = NULL;


        
        if ($this->row) {
            
            if ($this->image){
                if($this->image->getClientOriginalExtension() == 'png' || $this->image->getClientOriginalExtension() == 'jpg' || $this->image->getClientOriginalExtension() == 'jpeg')
                {
                    if ($this->image != null && $this->row->image)
                    {
                        $image_path = public_path().'/storage/'.$this->row->image;
                        if(File::exists($image_path)) {
                            unlink($image_path);
                        } // delete the file...
                    }
                    $image = $this->image->store('pop', 'public');
                } else {
                    $this->dispatch('warning', message: 'Only jpg, jpeg & png');
                    return;
                }
            } else {
                $image = $this->row->image;
            }

            if ($this->status == 'active') {
                Pop::where('status','active')->update(['status' => 'inactive']);
            }

            // handling image
            $this->row->update([
                'title'       => $this->title,
                'description' => $this->description,
                'user_id'     => $this->user_id,
                'role'        => $this->role,
                'image'       => $image,
                'status'      => $this->status,
            ]);
            $message = 'Updated Successfully.';
        } else {

            // handling image
            if ($this->image){
                if($this->image->getClientOriginalExtension() == 'png' || $this->image->getClientOriginalExtension() == 'jpg' || $this->image->getClientOriginalExtension() == 'jpeg') {
                    $image = $this->image->store('pop', 'public');
                } else {
                    $this->dispatch('warning', message: 'Only jpg, jpeg & png');
                    return;
                }
            } else {
                $image = null;
            }


            if ($this->status == 'active') {
                Pop::where('status','active')->update(['status' => 'inactive']);
            }

            Pop::create([
                'title'       => $this->title,
                'description' => $this->description,
                'user_id'     => $this->user_id,
                'role'        => $this->role,
                'image'       => $image,
                'status'      => $this->status,
            ]);
            $message = 'Created Successfully.';
        }
        $this->dispatch('success', message:$message);
        return $this->redirect('/admin/poplist', navigate:true);
    }

    public function render()
    {
        $data['lists'] = Pop::latest()->paginate(20);
        $data['roles'] = Role::get();
        $data['users'] = $this->role?User::role($this->role)->get():User::get(); 
        return view('livewire.pop-list', $data);
    }
}
