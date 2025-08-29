<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Setting;
use App\Models\Customertype;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Validation\Rules\Password;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class AddUserPage extends Component
{

    use WithFileUploads;

    public $first_name;
    public $last_name;
    public $email;
    public $phone;
    public $date_of_birth;
    public $nationality;
    public $street;
    public $postal_code;
    public $city;
    public $country;
    public $password;
    public $role;
    public $customer_type;
    public $status='1';
    public $notes;

    public $currency;
    public $hourly_rate;
    public $bank;
    public $bic;
    public $iban;
    public $ust_idnr;
    public $business_number;
    public $fiscal_number;

    public $whatsapp_id = null;
    public $botsailor_id = null;
    public $telegram_id = null;

    public $row;

    public $customer_role_name;
    public $custom_type_name;

    public $permissionname;


    public $access_mode='Unblocked';
    public $blocking_reason;

    public $company_name = null;

    public $passport_no = null;
    public $passport_expiry = null;
    public $passport_picture = null;
    public $uploadedPassportPicture = null;
    public $uploadedProfile = null;

    public $photo = null;

    public function mount(Request $request)
    {
        $this->row            = User::withTrashed()->find($request->id) ? User::withTrashed()->find($request->id) : null;
        $this->first_name     = $this->row ? $this->row->first_name : $this->first_name;
        $this->last_name      = $this->row ? $this->row->last_name : $this->last_name;
        $this->email          = $this->row ? $this->row->email : $this->email;
        $this->phone          = $this->row ? $this->row->phone : $this->phone;
        $this->date_of_birth  = $this->row && $this->row->date_of_birth ? $this->row->date_of_birth->toDateString() : $this->date_of_birth;
        $this->role           = $request->type;
        $this->customer_type  = $this->row ? $this->row->customer_type : $this->customer_type;
        $this->permissionname = collect([]);

        $this->whatsapp_id    = $this->row ? $this->row->whatsapp_id : $this->whatsapp_id;
        $this->botsailor_id   = $this->row ? $this->row->botsailor_id : $this->botsailor_id;
        $this->telegram_id    = $this->row ? $this->row->telegram_id : $this->telegram_id;

        $this->company_name = $this->row ? $this->row->company_name : $this->company_name;

        if (!empty($this->row)) {
            $this->permissionname   = collect([]);
            $this->getallpermisions = $this->row->getAllPermissions();
            $this->permissionname   = $this->row->getAllPermissions()->pluck('id');
        } else {
            $this->getallpermisions = [];
        }

        $this->street          = $this->row && $this->row->street ? $this->row->street : $this->street;
        $this->postal_code     = $this->row && $this->row->postal_code ? $this->row->postal_code : $this->postal_code;
        $this->city            = $this->row && $this->row->city ? $this->row->city : $this->city;
        $this->country         = $this->row && $this->row->country ? $this->row->country : $this->country;
        $this->notes           = $this->row && $this->row->setting ? $this->row->setting->note_for_email : $this->notes;
        $this->nationality     = $this->row && $this->row->nationality ? $this->row->nationality : $this->nationality;

        $this->currency        = $this->row && $this->row->setting ? $this->row->setting->currency : $this->currency;
        $this->hourly_rate     = $this->row && $this->row->setting ? $this->row->setting->hourly_rate : $this->hourly_rate;
        $this->bank            = $this->row && $this->row->setting ? $this->row->setting->bank : $this->bank;
        $this->bic             = $this->row && $this->row->setting ? $this->row->setting->bic : $this->bic;
        $this->iban            = $this->row && $this->row->setting ? $this->row->setting->iban : $this->iban;
        $this->ust_idnr        = $this->row && $this->row->setting ? $this->row->setting->ust_idnr : $this->ust_idnr;
        $this->business_number = $this->row && $this->row->setting ? $this->row->setting->business_number : $this->business_number;
        $this->fiscal_number   = $this->row && $this->row->setting ? $this->row->setting->fiscal_number : $this->fiscal_number;
        $this->passport_no     = $this->row && $this->row->setting ? $this->row->setting->passport_no : $this->passport_no;
        $this->passport_expiry = $this->row && $this->row->setting ? $this->row->setting->passport_expiry?->format('Y-m-d') : $this->passport_expiry;
        $this->passport_picture = $this->row && $this->row->setting ? $this->row->setting->passport_picture : $this->passport_picture;
        $this->photo           = $this->row ? $this->row->photo : $this->photo;

        if (role_name(Auth::id()) == 'Administrator' || role_name(Auth::id()) == 'administrator') {
            if ($this->row) {
                $this->access_mode = $this->row->deleted_at ? 'Blocked' : 'Unblocked';
            }
            $this->blocking_reason = $this->row ? $this->row->block_reason : '';
        }

    }


    function updatedCustomerType() {
        if($this->customer_type == 'Company') {
            $this->first_name = null;
            $this->last_name = null;
        }else{
            $this->company_name = null;
        }
    }

    public function addRole()
    {
        $this->validate(['customer_role_name' => 'required'], ['customer_role_name.required' => 'Enter Role Name.']);
        $role = Role::where('name',$this->customer_role_name)->first() ?? null;
        if (!$role) {
            $role = Role::create(['name' => $this->customer_role_name]);
            $this->dispatch('success', message: 'Role has been Added.');
            return;
        } else {
            $this->dispatch('warning', message: 'Role Already Exists!');
            return;
        }
    }

    public function addType()
    {
        $this->validate(['custom_type_name' => 'required'], ['custom_type_name.required' => 'Enter Customer Name.']);
        $customer = Customertype::where('name',$this->custom_type_name)->first() ?? null;
        if (!$customer) {
            $customer = Customertype::create(['name' => Str::lower($this->custom_type_name)]);
            $this->dispatch('success', message: 'Role has been Added.');
            // $this->customer_type = Str::lower($this->custom_type_name);
            $this->reset('custom_type_name');
            // return $this->redirect('/admin/add-user', navigate:false);
            return;
        } else {
            $this->dispatch('warning', message: 'Role Already Exists!');
            return;
        }
    }

    public function addPermission($value)
    {
        $getid = $value ? $this->permissionname->search($value) : false;
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

    public function saveChanges()
    {
        $this->validate(
            [
                'first_name' => 'required_without:company_name',
                'last_name'  => 'required_without:company_name',
                'email'      => 'required',
                'phone'      => 'required',
                'role'       => 'required',
                'customer_type' => 'required_if:role,Customer',
                'company_name' => 'required_if:customer_type,Company',
                'uploadedPassportPicture' => 'nullable|image',
            ],

            [
                'first_name.required' => 'Enter First Name.',
                'last_name.required'  => 'Enter Last Name.',
                'email.required'      => 'Enter Email Address.',
                'phone.required'      => 'Enter Phone Number.',
                'role.required'       => 'Select Role.',
                'customer_type.required_if' => 'Select Customer Type.'
            ]
        );

        $customerType = $this->customer_type ? $this->customer_type : NULL;
        $message = '';
        $url = '';

        if ($this->row) {
            $oldHourlyRate = $this->row->setting ? $this->row->setting->hourly_rate : 0;
            $this->resetValidation('password');
            $this->row->update([
                'first_name'     => $this->first_name,
                'last_name'      => $this->last_name,
                'email'          => $this->email,
                'phone'          => $this->phone,
                'password'       => $this->password ? bcrypt($this->password) : $this->row->password,
                'customer_type' => $customerType,
                'date_of_birth' => $this->date_of_birth ? $this->date_of_birth : null,
                'street'        => $this->street ? $this->street : null,
                'postal_code'   => $this->postal_code ? $this->postal_code : null,
                'city'          => $this->city ? $this->city : null,
                'country'       => $this->country ? $this->country : null,
                'nationality'   => $this->nationality ? $this->nationality : null,
                'whatsapp_id'   => $this->whatsapp_id ? $this->whatsapp_id : null,
                'botsailor_id'  => $this->botsailor_id ? $this->botsailor_id : null,
                'telegram_id'   => $this->telegram_id ? $this->telegram_id : null,
                'company_name'  => $this->company_name ? $this->company_name : null,
                'photo' => $this->uploadedProfile ? $this->uploadedProfile->store('profiles', 'public') : $this->photo,
            ]);

            $this->row->setting->update([
                'note_for_email' => $this->notes ? $this->notes : null,
                'currency'       => $this->currency ? $this->currency : null,
                'hourly_rate'    => $this->hourly_rate ? doubleval($this->hourly_rate) : 0,
                'bank'           => $this->bank ? $this->bank : null,
                'iban'           => $this->iban ? $this->iban : null,
                'bic'            => $this->bic ? $this->bic : null,
                // 'ust_idnr'       => $this->ust_idnr ? $this->ust_idnr : null,
                'passport_no'   => $this->passport_no ? $this->passport_no : null,
                'passport_expiry' => $this->passport_expiry ? $this->passport_expiry : null,
                'passport_picture' => $this->uploadedPassportPicture ? $this->uploadedPassportPicture->store('passports', 'public') : $this->passport_picture,
            ]);

            if($this->row->setting && $this->row->setting->hourly_rate != $oldHourlyRate){
                $this->row->salaries()->update(['is_current' => false]);
                $this->row->salaries()->create([
                    'amount' => $this->row->setting->hourly_rate,
                    'effective_date' => now(),
                    'is_current' => true,
                    'currency' => $this->row->setting->currency
                ]);
            }

            /*first removing all roles from the user*/
            foreach($this->row->roles as $item){
                if($this->row->id != 1){
                    $this->row->removeRole($item);
                }
            }
            // assign role
            if($this->row->id != 1){
                $this->row->assignRole($this->role);
            }

            $this->row->syncPermissions($this->permissionname->values()->all());
            $message = 'Updated';

            if ($this->access_mode == 'Blocked') {
                $this->row->update(['block_reason' => $this->blocking_reason]);
                $this->row->delete();
            } else{
                $this->row->update(['block_reason' => $this->blocking_reason?$this->blocking_reason:NULL]);
                $this->row->restore();
            }
            $url = '/admin/add-user?id='.$this->row->id.'&&type='.Str::ucfirst($this->role);
        } else {

            $checkExists = User::where('email',$this->email)->first();
            if($checkExists)
            {
                $this->dispatch('error', message:'This '.$this->role.' Already Exists.');
                return;
            }

            if ($this->password) {
                $user = User::create([
                    'first_name'     => $this->first_name,
                    'last_name'      => $this->last_name,
                    'email'          => $this->email,
                    'phone'          => $this->phone,
                    'password'       => bcrypt($this->password),
                    'remember_token' => Str::random(10),
                    'customer_type'  => $customerType,
                    'date_of_birth'  => $this->date_of_birth ? $this->date_of_birth : null,
                    'street'         => $this->street ? $this->street : null,
                    'postal_code'    => $this->postal_code ? $this->postal_code : null,
                    'city'           => $this->city ? $this->city : null,
                    'country'        => $this->country ? $this->country : null,
                    'nationality'    => $this->nationality ? $this->nationality : null,
                    'whatsapp_id'    => $this->whatsapp_id ? $this->whatsapp_id : null,
                    'botsailor_id'   => $this->botsailor_id ? $this->botsailor_id : null,
                    'telegram_id'    => $this->telegram_id ? $this->telegram_id : null,
                    'company_name'   => $this->company_name ? $this->company_name : null,
                ]);

                if ($user) {


                    if ($this->role == 'Customer') {
                        $user->givePermissionTo([
                            'chat',
                            'dashboard',
                            'invoices',
                            'settings-update',
                            'settings-upload-documents',
                            'settings-view',
                            'service',
                            'work-work-hour'
                        ]);
                    }

                    if ($this->role == 'Employee') {
                        $user->givePermissionTo([
                            'chat',
                            'dashboard',
                            'settings-update',
                            'settings-upload-documents',
                            'settings-view',
                            'work-work-hour'
                        ]);
                    }

                    if ($this->role == 'Manager') {
                        $user->givePermissionTo([
                            'chat',
                            'dashboard',
                            'settings-update',
                            'settings-upload-documents',
                            'settings-view'
                        ]);
                    }

                    if (!$user->setting) {
                        Setting::create([
                            'user_id'        => $user->id,
                            'note_for_email' => $this->notes ? $this->notes : null,
                        ]);
                    }

                    $user->assignRole($this->role);
                    $user->syncPermissions($this->permissionname->values()->all());

                    if ($this->status == 0) {
                        $user->delete();
                    }

                    $url = '/admin/users?type='.Str::ucfirst($this->role);
                }

                $message = 'Created.';
            } else {
                $this->addError('password','Enter password.');
                return;
            }
        }
        session()->flash('success', $message);
        return $this->redirect($url, navigate:false);
    }

    public function deleteRole($name)
    {
        $role = Role::findByName($name);

        if ($name == 'Administrator' || $name == 'administrator') {
            $this->dispatch('warning', message: 'unable to Delete.');
            return;
        }

        if ($name == 'Employee' || $name == 'employee') {
            $this->dispatch('warning', message: 'unable to Delete.');
            return;
        }

        if ($name == 'Customer' || $name == 'customer') {
            $this->dispatch('warning', message: 'unable to Delete.');
            return;
        }

        if (count($role->permissions) > 0) {
            $this->dispatch('warning', message: 'unable to Delete.');
            return;
        }

        $default = Customertype::where('name', 'normal')->first();

        if (!$default) {
            Customertype::create(['name' => 'normal']);
        }

        $users = User::role($name)->get();
        if (count($users) > 0) {
            User::role($name)->update(['customer_type' => 'normal']);
        }
        foreach($users as $user){
            $user->removeRole($name);
            $user->assignRole('Customer');
        }

        $role->delete();
        $this->dispatch('success', message: 'Role: '.$name.' has been Deleted.');
        return $this->redirect('/admin/add-user', navigate:false);
    }

    public function deleteType($name)
    {
        if ($name == 'normal') {
            $this->dispatch('warning', message: 'Unable to delete type: '.$name);
            return;
        }

        $lower = Str::lower($name);
        $capitalize = Str::ucfirst($name);
        $upper = Str::upper($name);

        $nameArray = [];
        array_push($nameArray, $lower);
        array_push($nameArray, $capitalize);
        array_push($nameArray, $upper);

        $data = Customertype::where('name',$name)->first();

        $default = Customertype::where('name', 'normal')->first();
        if (!$default) {
            Customertype::create(['name' => 'normal']);
        }
        $users = User::whereIn('customer_type',$nameArray)->get();
        if (count($users) > 0) {
            User::whereIn('customer_type',$nameArray)->update(['customer_type'=>'normal']);
        }

        $data->delete();
        $this->dispatch('success', message: 'Type: '.$name.' has been Deleted.');
        return $this->redirect('/admin/add-user', navigate:false);
    }


    public function render()
    {
        $data['roles'] = Role::all();
        $data['types'] = Customertype::all();
        $data['permissions'] = Auth::user()->id == 1 ? Permission::all() : Auth::user()->getAllPermissions();
        return view('livewire.add-user-page', $data);
    }
}
