<?php

namespace App\Livewire;

use App\Models\Optionalproduct;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Service;

class AddServicePage extends Component
{

    use WithFileUploads;
    public $title;
    public $unit='Day';
    public $currency='€';
    public $price;
    public $tax;
    public $tax_value;
    public $total_price;
    public $status='1';
    public $regularity='regular';
    public $speciality='normal';
    public $address;
    public $postal_code;
    public $city="Berlin";
    public $country="Germany";
    public $box_code;
    public $client_code;
    public $deposit_code;
    public $access_phone;

    public $floor_number;
    public $house_number;


    public $square_weather;
    public $room;
    public $maximal_capacity_place;
    public $wifi_name;
    public $wifi_password;
    public $balcony;

    public $row;

    public $is_address=false;


    public $images = [];
    public $videos = [];
    public $myfiles=[];
    public $upload_id;
    public $media_caption;


    public $products = [];
    public $choosenProduct = null;
    public $optionalProducts = [];


    public function mount(Request $request)
    {
        $this->row = Service::find($request->id);
        $this->optionalProducts = $this->row ? $this->row->optionalProducts : [];
        $this->products = $this->row ? Optionalproduct::whereNotIn('id', $this->optionalProducts?->pluck('optional_product_id') ?? [])->get() : [];

        $this->title       = $this->row ? $this->row->title : $this->title;
        $this->unit        = $this->row ? $this->row->unit : $this->unit;
        $this->price       = $this->row ? $this->row->price : $this->price;
        $this->currency    = $this->row ? $this->row->currency : $this->currency;
        $this->tax         =  $this->row ? $this->row->tax : $this->tax; //globalTax();
        $this->tax_value   = $this->row ? $this->row->tax_value : $this->tax_value;
        $this->total_price = $this->row ? $this->row->total_price : $this->total_price;
        $this->address     = $this->row ? $this->row->street : $this->address;
        $this->postal_code = $this->row ? $this->row->postal_code : $this->postal_code;
        $this->city        = $this->row && $this->row->city ? $this->row->city : 'Berlin';
        $this->country     = $this->row && $this->row->country ? $this->row->country : 'Germany';
        $status = '1';
        if ($this->row) {
            $this->is_address = $this->row->street || $this->row->postal_code || $this->row->city || $this->row->country ? true : false;
            $status = $this->row->status;
        } else {
            if (role_name(Auth::user()->id) != 'Administrator') {
                $status = '1';
            }
        }

        $this->status       = $status;
        $this->box_code     = $this->row ? $this->row->box_code : $this->box_code;
        $this->client_code  = $this->row ? $this->row->client_code : $this->client_code;
        $this->deposit_code = $this->row ? $this->row->deposit_code : $this->deposit_code;
        $this->access_phone = $this->row ? $this->row->access_phone : $this->access_phone;
        $this->floor_number = $this->row ? $this->row->floor_number : $this->floor_number;
        $this->house_number = $this->row ? $this->row->house_number : $this->house_number;

        $this->regularity     = $this->row ? $this->row->regularity : $this->regularity;
        $this->speciality     = $this->row ? $this->row->speciality : $this->speciality;
        $this->square_weather = $this->row ? $this->row->square_weather : $this->square_weather;
        $this->room           = $this->row ? $this->row->room : $this->room;
        $this->maximal_capacity_place = $this->row ? $this->row->maximal_capacity_place : $this->maximal_capacity_place;
        $this->wifi_name      = $this->row ? $this->row->wifi_name : $this->wifi_name;
        $this->wifi_password  = $this->row ? $this->row->wifi_password : $this->wifi_password;
        $this->balcony        = $this->row ? $this->row->balcony : $this->balcony;
        $this->upload_id      = $this->row ? $this->row->upload_id: $this->upload_id;
    }



    public function triggerCalTaxVal()
    {
        if ($this->price && $this->tax) {
            $percentage = doubleval($this->tax) / 100;
            $this->tax_value = number_format($percentage * doubleval($this->price), 2);
            $this->total_price = $this->tax_value ? number_format(doubleval($this->tax_value) + doubleval($this->price), 2) : 0;
        } else {
            $this->reset(['tax_value','total_price']);
        }
    }


    public function updatedImages($value)
    {
        $this->myfiles = array_merge($this->myfiles, $value);
    }

    public function updatedVideos($value)
    {
        $this->myfiles = array_merge($this->myfiles, $value);
    }

    public function saveChanges()
    {
        $this->validate(
            [
                'title'       => 'required',
                'unit'        => 'required',
                'currency'    => 'required',
                'price'       => 'required',
                'tax'         => 'required',
                'tax_value'   => 'required',
                'total_price' => 'required',
                'address'     =>'required_if:is_address,=,true',
                'postal_code' =>'required_if:is_address,=,true',
                'city'        =>'required_if:is_address,=,true',
                'country'     =>'required_if:is_address,=,true',
            ],
            [
                'title.required'          => 'Enter title',
                'unit.required'           => 'select unit ',
                'currency.required'       => 'select currency',
                'price.required'          => 'enter price',
                'tax.required'            => 'enter tax',
                'tax_value.required'      => 'enter tax value',
                'total_price.required'    => 'enter total price',
                'address.required_if'     => 'Enter street address',
                'postal_code.required_if' => 'Enter postal code',
                'city.required_if'        => 'Enter city',
                'country.required_if'     => 'Enter country',
            ]
        );



        $message ='';
        $status = '';

        $serviceID = $this->row ? $this->row->id : NULL;

        $status = role_name(Auth::user()->id) == 'Administrator' ? $this->status : 1;

        if ($this->row) {

            $this->row->update([
                'title'        => $this->title,
                'unit'         => $this->unit,
                'price'        => $this->price ? $this->price : 0.000,
                'currency'     => $this->currency ?? NULL,
                'tax'          => $this->tax && $this->price ? $this->tax : 0.000,
                'tax_value'    => $this->tax_value ? $this->tax_value : 0.000,
                'total_price'  => $this->total_price ? $this->total_price : 0.000,
                'status'       => $this->status,
                'street'       => $this->is_address ? $this->address : null,
                'postal_code'  => $this->is_address ? $this->postal_code : null,
                'city'         => $this->is_address ? $this->city : null,
                'country'      => $this->is_address ? $this->country : null,
                'box_code'     => $this->is_address ? $this->box_code : null,
                'client_code'  => $this->is_address ? $this->client_code : null,
                'deposit_code' => $this->is_address ? $this->deposit_code : null,
                'access_phone' => $this->is_address ? $this->access_phone : null,
                'floor_number' => $this->is_address ? $this->floor_number : null,
                'house_number' => $this->is_address ? $this->house_number : null,
            ]);
            $message = 'Service has been Updated.';
        } else {
            $new_service = Service::create([
                'title'        => $this->title,
                'unit'         => $this->unit,
                'price'        => $this->price ? $this->price : 0.000,
                'currency'     => $this->currency ?? NULL,
                'tax'          => $this->tax && $this->price ? $this->tax : 0.000,
                'tax_value'    => $this->tax_value ? $this->tax_value : 0.000,
                'total_price'  => $this->total_price ? $this->total_price : 0.000,
                'status'       => $status,
                'street'       => $this->is_address ? $this->address : null,
                'postal_code'  => $this->is_address ? $this->postal_code : null,
                'city'         => $this->is_address ? $this->city : null,
                'country'      => $this->is_address ? $this->country : null,
                'box_code'     => $this->is_address ? $this->box_code : null,
                'client_code'  => $this->is_address ? $this->client_code : null,
                'deposit_code' => $this->is_address ? $this->deposit_code : null,
                'access_phone' => $this->is_address ? $this->access_phone : null,
                'floor_number' => $this->is_address ? $this->floor_number : null,
                'house_number' => $this->is_address ? $this->house_number : null,
            ]);

            $message = 'Service has been Added.';
            $serviceID = $new_service->id;
        }

        // files work
        $filesData   = [];
        $sending_url = config('app.url') . '/api/upload-via-ftp';
        $uploadId    = $serviceID;

        if ($uploadId) {

            foreach ($this->myfiles as $file) {
                $extension      = $file->getClientOriginalExtension();
                $uniqueFileName = uniqid() . '.' . $extension;
                $remotePath     = 'uploads/' . $uniqueFileName;

                // Prepare files to send to the API
                $filesData[] = [
                    'path' => $remotePath,
                    'file' => $file,
                    'name' => $uniqueFileName
                ];
            }

            // Flatten the array for multipart request
            $multipartData = [];

            foreach ($filesData as $fileData) {
                $multipartData[] = [
                    'name'     => 'files[]',
                    'contents' => fopen($fileData['file']->getRealPath(), 'r'),
                    'filename' => $fileData['name'],
                    'id'       => $uploadId,
                ];

                // Add the upload ID as a regular form field
                $multipartData[] = [
                    'name'     => 'upload_id',
                    'contents' => $uploadId
                ];

                $multipartData[] = [
                    'name'     => 'media_caption',
                    'contents' => $this->media_caption
                ];
            }

            Http::async()->asMultipart()->post($sending_url, $multipartData)->wait();
        }



        $this->dispatch('success', message: $message);

        $pending  = '/admin/pending-service';
        $active   = '/admin/active-service';
        $inactive = '/admin/inactive-service';

        $redirectlink = '';

        if ($status == '0') {
            $redirectlink = $pending;
        } elseif($status == '1'){
            $redirectlink = $active;
        } elseif($status == '2'){
            $redirectlink = $inactive;
        }
        // return $this->redirect($redirectlink);

        //return redirect()->to('admin/edit-service?id='.$uploadId);

        return redirect()->to('admin/services');
    }

    function saveProductForService() {
        $this->validate(['choosenProduct' => 'required|exists:optionalproducts,id'], ['choosenProduct.required' => 'Please choose a product', 'choosenProduct.exists' => 'Selected product does not exist']);

        if($this->row && $this->choosenProduct && $this->products->find($this->choosenProduct)){
            $this->row->optionalProducts()->updateOrCreate([
                'service_id' => $this->row->id,
                'optional_product_id' => $this->choosenProduct
            ], [
                'service_id' => $this->row->id,
                'optional_product_id' => $this->choosenProduct
            ]);

            $this->optionalProducts = $this->row ? $this->row->optionalProducts : [];
            $this->products = Optionalproduct::whereNotIn('id', $this->optionalProducts->pluck('optional_product_id'))->get();

            $this->choosenProduct = null;
        }
    }

    function deleteOptionalProduct($id) {
        if($this->optionalProducts && $this->optionalProducts->find($id)) {
            $this->optionalProducts->find($id)->delete();
            $this->optionalProducts = $this->row ? $this->row->optionalProducts : [];
            $this->products = Optionalproduct::whereNotIn('id', $this->optionalProducts->pluck('optional_product_id'))->get();
        }
    }

    public function delete($index = null, $serviceID = null)
    {
        // Find the service by ID
        $service = Service::find($serviceID);

        if ($service) {
            // Decode the 'files' JSON into an array
            $files = json_decode($service->files);

            // Check if the index exists in the array
            if (is_array($files) && array_key_exists($index, $files)) {
                $element = $files[$index];

                // Ensure that $element is an object and has a 'file' property
                if (is_object($element) && property_exists($element, 'file')) {
                    $remotePath = $element->file;

                    // Check if the file exists on the FTP and then delete it
                    if (Storage::disk('ftp')->exists($remotePath)) {
                        Storage::disk('ftp')->delete($remotePath);

                        // Remove the element at the given index
                        unset($files[$index]);

                        // Re-index the array after deletion
                        $files = array_values($files);

                        // Update the service 'files' field with the new JSON
                        $service->update(['files' => json_encode($files)]);
                    } else {
                        // Remove the element at the given index
                        unset($files[$index]);

                        // Re-index the array after deletion
                        $files = array_values($files);

                        // Update the service 'files' field with the new JSON
                        $service->update(['files' => json_encode($files)]);
                    }
                }
            }
        }

        // Redirect to the edit service page
        return redirect('/admin/edit-service?id=' . $serviceID)->with('success', 'File deleted successfully.');
    }



    public function render()
    {
        return view('livewire.add-service-page');
    }
}
