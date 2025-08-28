<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Livewire\WithFileUploads;
use App\Models\User;
use App\Models\Setting;
use App\Models\Address;

class SettingPage extends Component
{

    use WithFileUploads;

    public $myphoto;
    public $first_name;
    public $last_name;
    public $email;
    public $phone;
    public $date_of_birth;

    public $company;
    public $company_email;
    public $website;
    public $company_address;
    public $street;
    public $postal_code;
    public $city;
    public $country;
    public $invoice_prefix;
    public $invoice_number;
    public $invoice_text;
    public $currency='€';
    public $hourly_rate;
    public $bank;
    public $bic;
    public $iban;
    public $ust_idnr;
    public $business_number;
    public $fiscal_number;

    public $row;

    public $profile_row;

    public $addresses=[];
    public $address_row;

    public $new_password;
    public $confirm_new_password;

    public function mount()
    {
        $this->row = Auth::user() && Auth::user()->setting ? Auth::user()->setting : null;
        $this->profile_row = Auth::user() ? Auth::user() : null;

        /*profile information*/ 
        $this->first_name = $this->profile_row ? $this->profile_row->first_name : $this->first_name; 
        $this->last_name = $this->profile_row ? $this->profile_row->last_name : $this->last_name; 
        $this->email = $this->profile_row ? $this->profile_row->email : $this->email; 
        $this->phone = $this->profile_row ? $this->profile_row->phone : $this->phone;
        $this->date_of_birth = $this->profile_row && $this->profile_row->date_of_birth ? $this->profile_row->date_of_birth->format('d-m-Y') : $this->date_of_birth;
        $this->street = $this->profile_row ? $this->profile_row->street : $this->street;
        $this->postal_code = $this->profile_row ? $this->profile_row->postal_code : $this->postal_code;
        $this->city = $this->profile_row ? $this->profile_row->city : $this->city;
        $this->country = $this->profile_row ? $this->profile_row->country : $this->country;

        /*setting information*/
        $this->company = $this->row ? $this->row->company : $this->company;
        $this->company_email = $this->row ? $this->row->company_email : $this->company_email;
        $this->company_address = $this->row ? $this->row->company_address : $this->company_address;
        $this->website = $this->row ? $this->row->website : $this->website;
        $this->invoice_prefix = date('Y');
        $this->invoice_number = $this->row ? $this->row->invoice_number : $this->invoice_number;
        $this->invoice_text = $this->row ? $this->row->invoice_text : $this->invoice_text;
        $this->currency = $this->row ? $this->row->currency : $this->currency;
        $this->hourly_rate = $this->row ? $this->row->hourly_rate : $this->hourly_rate;
        $this->bank = $this->row ? $this->row->bank : $this->bank;
        $this->bic = $this->row ? $this->row->bic : $this->bic;
        $this->iban = $this->row ? $this->row->iban : $this->iban;
        $this->ust_idnr = $this->row ? $this->row->ust_idnr : $this->ust_idnr;
        $this->business_number = $this->row ? $this->row->business_number : $this->business_number;
        $this->fiscal_number = $this->row ? $this->row->fiscal_number : $this->fiscal_number;
    }
    
    public function deleteAddress($id)
    {
        $address = Address::find($id) ?? NULL;
        if ($address) {
            if (Auth::user()->id == $address->user_id) {
                $address->delete();
            } else {
                $this->closeAddressForm();
                return;
            }
        } else {
            $this->closeAddressForm();
            return;
        }
    }

    public function editAddress($id)
    {
        $address = Address::find($id) ?? NULL;
        if ($address) {
            if (Auth::user()->id == $address->user_id) {
                $this->address_row = $address;
                $this->addresses[] = [
                    'street'   => $address->street,
                    'postal_code' => $address->postal_code,
                    'city' => $address->city,
                    'country' => $address->country,
                    'address_for' => $address->address_for,
                ];
            } else {
                $this->closeAddressForm();
                return;
            }
        } else {
            $this->closeAddressForm();
            return;
        }
    }
    public function closeAddressForm()
    {
        $this->reset(['addresses','address_row']);
    }

    public function addAddressForm()
    {
        $this->addresses[] = [
            'street'   => '',
            'postal_code' => '',
            'city' => '',
            'country' => '',
            'address_for' => '',
        ];
    }

    public function addAddress()
    {
        $this->validate([
            'addresses.*.street' => 'required',
            'addresses.*.postal_code' => 'required',
            'addresses.*.city' => 'required',
            'addresses.*.country' => 'required',
            'addresses.*.address_for' => 'required',
        ]);


        if ($this->address_row) {
            $this->address_row->update([
                'street'   => $this->addresses[0]['street'],
                'postal_code' => $this->addresses[0]['postal_code'],
                'city' => $this->addresses[0]['city'],
                'country' => $this->addresses[0]['country'],
                'address_for' => $this->addresses[0]['address_for'],
            ]);
        } else {
            Address::create([
                'user_id'   => Auth::user()->id,
                'street'   => $this->addresses[0]['street'],
                'postal_code' => $this->addresses[0]['postal_code'],
                'city' => $this->addresses[0]['city'],
                'country' => $this->addresses[0]['country'],
                'address_for' => $this->addresses[0]['address_for'],
            ]);
        }


        $this->closeAddressForm();
    }

    public function saveProfile()
    {
        $message = 'Invalid.';
        $type = 'warning';
        $this->dispatch( $type, message: $message);
    }

    public function saveChanges()
    {

        /*if (role_name(Auth::user()->id) != 'Administrator') {
            $this->validate(
                [
                    'first_name' => 'required',
                    'last_name' => 'required',
                    'email' => 'required',
                    'phone' => 'required',
                    'date_of_birth' => 'required',
                    'street' => 'required',
                    'postal_code' => 'required',
                    'city' => 'required',
                    'country' => 'required',
                    'currency' => 'required',
                    'bank' => 'required',
                    'bic' => 'required',
                    'iban' => 'required',
                    'ust_idnr' => 'required',
                    'business_number' => 'required',
                    'fiscal_number' => 'required',
                ],
                [
                    'first_name.required' => 'Enter First Name',
                    'last_name.required' => 'Enter Last Name',
                    'email.required' => 'Enter Email',
                    'phone.required' => 'Enter Phone Number',
                    'date_of_birth.required' => 'Enter Date-of-Birth',
                    'street.required' => 'Enter street',
                    'postal_code.required' => 'Enter postal code',
                    'city.required' => 'Enter city',
                    'country.required' => 'Enter country',
                    'currency.required' => 'Enter currency',
                    'bank.required' => 'Enter bank',
                    'bic.required' => 'Enter bic',
                    'iban.required' => 'Enter iban',
                    'ust_idnr.required' => 'required',
                    'business_number.required' => 'Enter business number',
                    'fiscal_number.required' => 'Enter fiscal number',
                ]
            );

        }*/

        $message = 'Invalid.';
        $type    = 'warning';

        if ($this->row) {
            
            $this->row->update([
                'company'         => $this->company,
                'company_email'   => $this->company_email,
                'company_address' => $this->company_address,
                'website'         => $this->website,
                'invoice_prefix'  => $this->invoice_prefix,
                'invoice_number'  => $this->invoice_number,
                'invoice_text'    => $this->invoice_text,
                'currency'        => $this->currency,
                'hourly_rate'     => $this->hourly_rate,
                'bank'            => $this->bank,
                'bic'             => $this->bic,
                'iban'            => $this->iban,
                'ust_idnr'        => $this->ust_idnr,
                'business_number' => $this->business_number,
                'fiscal_number'   => $this->fiscal_number,
            ]);

            $message = 'Updated.';
            $type    = 'success';
        }


        if ($this->profile_row) {
            
            $this->profile_row->update([
                'first_name'    => $this->first_name,
                'last_name'     => $this->last_name,
                'email'         => $this->email,
                'phone'         => $this->phone,
                'date_of_birth' => $this->date_of_birth,
                'street'        => $this->street,
                'postal_code'   => $this->postal_code,
                'city'          => $this->city,
                'country'       => $this->country,
                
            ]);
        }

        $this->dispatch( $type, message: $message);
        return;
    }

    public function savePassword()
    {

        $this->validate(
            [
                'new_password' =>'required',
                'confirm_new_password' =>'required',
            ],
            [
                'new_password.required' => 'type new password',
                'confirm_new_password.required' => 're-type new password',
            ]
        );

        /*check new & confirm password before update */
        if ($this->new_password != $this->confirm_new_password) {
            $this->addError('confirm_new_password','unmatched confirmed password!');
            return;
        } else {
            $this->resetValidation();
        }
        
        $myprofile = Auth::user();
        $type = 'warning';
        $message = 'Password Not changed.';

        if ($myprofile) {
            $password = $this->new_password ?  bcrypt($this->new_password) : $myprofile->password;
            $myprofile->update([
                'password' => $password,
            ]);
            $type = 'success';
            $message = 'Password has been Changed Successfully.';
        }

        $this->dispatch($type, message: $message);
        session()->flash($type,$message);
        $this->reset(['new_password','confirm_new_password']);
    }


    public function render()
    {

        /* FILE UPLOAD */
        if ($this->myphoto && $this->profile_row) {
            $allowedExtensions = ['jpg', 'png', 'jpeg'];
            $fileExtension = $this->myphoto->getClientOriginalExtension();
        
            if (in_array($fileExtension, $allowedExtensions)) {
                /*$filename = $this->myphoto->getClientOriginalName();
                $uploaded = Storage::disk('public')->put('uploads', $this->myphoto);*/

                $uploaded = uploadFTP($this->myphoto);
        
                if ($uploaded) {
                    $this->profile_row->update(['photo' => $uploaded]);
                    $this->reset('myphoto');
                } else {
                    //dd('not-uploaded');
                }
            }
        }      
        /* FILE UPLOAD */

        $data['address_lists'] = Address::where('user_id', Auth::user()->id)->get(); 
        return view('livewire.setting-page', $data);
    }
}
