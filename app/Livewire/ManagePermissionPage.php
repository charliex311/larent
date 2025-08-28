<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Auth;

class ManagePermissionPage extends Component
{
    public $row;
    public $role;
    public $info;

    public $permissionname;
    public $getallpermisions=[];
    public $getid;
    public $usrid;

    public function mount(Request $request)
    {
        $this->usrid = $request->id;
        $this->row   = User::withTrashed()->find($request->id) ? User::withTrashed()->find($request->id) : null;
        $this->role  = $this->row ? role_name($this->row->id) : null;
        $this->permissionname = $this->row ? $this->row->permissions->pluck('id') : collect([]);
    }


    public function checkPermissions()
    {
        if (!empty($this->role)) {
            $this->permissionname   = collect([]);
            $this->getallpermisions = $this->row->permissions;
            $this->permissionname   = $this->row->permissions->pluck('id');
        } else {
            $this->getallpermisions = [];
        }
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function addPermission($value)
    {
        $getid = $this->permissionname->search($value);
        
        if ($getid !== false) {
            $this->permissionname->forget($getid);
        } else {
            $this->permissionname->prepend($value);
        }
        
        $this->permissionname = $this->permissionname->unique();
        $this->permissionname->values()->all();
    }


    public function addPermissionAsGroup($items)
    {
        foreach($items as $item){
            $this->addPermission($item[0]);
        }
    }

    public function savePermissions()
    {

        if (!empty($this->row)) {
            $this->row->syncPermissions($this->permissionname->values()->all());
            $this->getallpermisions = $this->row->permissions;
            $this->permissionname = $this->row->permissions->pluck('id');  
        }
        session()->flash('success', 'Saved.');
    }

    public function render()
    {

        $data['roles'] = Auth::user()->id == 1 ? Role::whereNotIn('name',['Administrator','administrator'])->get(): Role::whereNotIn('name',['Administrator','administrator'])->get();
        $data['permissions'] = Auth::user()->id == 1 ? Permission::all() : Auth::user()->permissions;

        return view('livewire.manage-permission-page', $data);
    }
}