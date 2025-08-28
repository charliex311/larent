<?php

namespace App\Livewire;

use Livewire\WithPagination;
use Illuminate\Http\Request;
use Livewire\Component;
use App\Models\User;


class UsersPage extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $query;
    public $query2;
    public $rolename;

    public $status=1;
    public $perpage=10;

    public function mount(Request $request)
    {
        $this->rolename = $request->type ?? NULL;
    }

    public function search()
    {
        $this->resetPage();
    }

    public function changeStatus($id)
    {
       $user = User::withTrashed()->find($id);
        if ($user) {
            if($user->id == 1){
                return;
            }
            if ($user->deleted_at == null) {
                $user->delete();
            } else{
                $user->restore();
            }
        }
        $url = '/admin/users?type='.$this->rolename;
        //return $this->redirect($url, navigate:true);
    }


    public function render()
    {
        $this->search();
        
        if ($this->status == 1) {
            $data['total'] = User::role($this->rolename)->count();
            $data['users'] = User::role($this->rolename)
            ->when($this->query, function($query, $keyword){
                return $query->where('first_name', 'LIKE', '%'.$keyword.'%')
                ->orWhere('last_name', 'LIKE', '%'.$keyword.'%')
                ->orWhere('phone', 'LIKE', '%'.$keyword.'%')
                ->orWhere('email', 'LIKE', '%'.$keyword.'%');
            })
            ->paginate($this->perpage);
        } elseif($this->status == 0) {
            $data['total'] = User::role($this->rolename)->onlyTrashed()->count();
            $data['users'] = User::role($this->rolename)->onlyTrashed()
            ->when($this->query, function($query, $keyword){
                return $query->where('first_name', 'LIKE', '%'.$keyword.'%')
                ->orWhere('last_name', 'LIKE', '%'.$keyword.'%')
                ->orWhere('phone', 'LIKE', '%'.$keyword.'%')
                ->orWhere('email', 'LIKE', '%'.$keyword.'%');
            })
            ->paginate($this->perpage);
        }
        
        $data['active_users'] = User::role($this->rolename)->get();
        $data['inactive_users'] = User::role($this->rolename)->onlyTrashed()->get();
        
        return view('livewire.users-page', $data);
    }
}
