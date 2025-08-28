<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Joblist;
use App\Models\Service;
use App\Models\Address;
use App\Models\Optionalproduct;
use App\Models\User;

class AddJob extends Component
{
    public $customer;
    public $customer_type;
    public $checkin;
    public $checkout;
    public $total_task_hour;
    public $recurrence_type;
    public $service_id;

    public $optionals=[];

    public $employee;
    public $employee_message;
    public $number_of_people;
    public $code_from_the_door;


    /**/
    public $servicesArray=[]; 


    /*addresses*/
    public $addresses=[];

    public function addServices()
    {
        $this->servicesArray[] = [
            'service_id' => '',
            'job_address' => '',
            'checkin' => '',
            'checkout' => '',
            'job_date' => '',
            'total_task_hour' => '',
            'recurrence_type' => '',
            'number_of_people' => '',
            'code_from_the_door' => '',
            'job_notes' => '',
            'optionals' => []
        ];
        $this->dispatch('service-added');
    }

    public function removeFromServicesArray($index)
    {
        unset($this->servicesArray[$index]);
    }

    public function saveChanges()
    {

        $customer_type = '';

        if ($this->customer) {
            $customer_type = customerType($this->customer['value']);
        }

        $this->validate(
            [
                'customer' => 'required',
                'employee' => 'required',
                'servicesArray.*.service_id' => 'required',
                'servicesArray.*.job_address' => 'required',
                'servicesArray.*.total_task_hour' => 'required',
                'servicesArray.*.recurrence_type' => 'required',
                'servicesArray.*.checkin' => 'required_if:customer_type,host',
                'servicesArray.*.checkout' => 'required_if:customer_type,host',
                'servicesArray.*.job_date' => ['required_if:customer_type,company,private'],
            ],
            [
                'customer.required' => 'Customer Not Selected.',
                'employee.required' => 'Employee Not Selected.',
            ]
        );

        if (count($this->servicesArray) == 0) {
            $this->dispatch('warning', message: 'Service Not Selected!');
            return;
        }


        $hourly_rate = 0.00;
        $currency = NULL;
        if ($this->employee && $this->employee['value']) {
            $employee    = User::find($this->employee['value']);
            $hourly_rate = $employee->setting['hourly_rate'];
            $currency    = $employee->setting['currency'];

            if ($hourly_rate == 0) {
                $this->dispatch('warning', message: 'Employee Did not Set the Hourly Rate.');
                return;
            }
        }
        foreach($this->servicesArray as $key => $item){

            $checkin = null;
            $checkout = null;
            $job_date = null;
            if (customerType($this->customer['value']) == 'host') {
                $checkin = $item['checkin'] ? parseDateTimeForPC($item['checkin']) : null;
                $checkout = $item['checkout'] ? parseDateTimeForPC($item['checkout']) : null;
            } else {
                $job_date = $item['job_date'] ? parseDateTimeForPC($item['job_date']) : null;
            }

            

            Joblist::create([
                'user_id'            => $this->customer['value'] ?? null,
                'checkin'            => $checkin,
                'checkout'           => $checkout,
                'job_date'           => $job_date,
                'total_task_hour'    => $item['total_task_hour'] ? $item['total_task_hour'] : null,
                'hourly_rate'        => $hourly_rate,
                'currency'           => $currency,
                'recurrence_type'    => $item['recurrence_type'] ? $item['recurrence_type'] : null,
                'job_notes'          => $item['job_notes'] ? $item['job_notes'] : null,
                'optional_product'   => $item['optionals'] ? json_encode($item['optionals']) : json_encode([]),
                'employee_id'        => $this->employee && $this->employee['value'] ? $this->employee['value'] : null,
                'employee_message'   => $this->employee_message ? $this->employee_message : null,
                'service_id'         => $item['service_id'] ? $item['service_id'] : null,
                'job_address'        => $item['job_address'] ? $item['job_address'] : null,
                'job_status'         => $this->employee && $this->employee['value'] ? '2' : '1',
                'number_of_people'   => $item['number_of_people'] ? $item['number_of_people'] : null,
                'code_from_the_door' => $item['code_from_the_door'] ? $item['code_from_the_door'] : null,
                'service_price'      => $item['service_id'] ? servicePrice($item['service_id']) : null,
            ]);
        }

        $this->dispatch('success', message: 'Job Submitted.');
        return $this->redirect('/admin/jobs-calendar', navigate:false);
    }

    public function GetCustomerType()
    {
        $id = $this->customer['value'] ?? null;
        $customer = $id ? User::find($id) : null;

        if ($customer) {
            $this->customer_type = $customer->customer_type ?? null;
        } else {
            $this->reset('customer_type');
        }
    }

    public function updateAddress($key0)
    {
        $serviceId = $this->servicesArray[$key0]['service_id'];
        $id = $this->customer['value'] ?? null;
        // Retrieve the selected service by its ID

        
        $selectedService = serviceAddress($serviceId);

        
        if ($selectedService) {
            $this->servicesArray[$key0]['job_address'] = $selectedService;
            $this->reset('addresses');
            $this->addresses[] = [
                'address_for' => 'service',
                'address' => $selectedService,
            ];
            $othersAddressArray = Address::where('user_id', $id)->get()->map(function ($address) {
                return [
                    'address_for' => $address->address_for,
                    'address' => otherAddres($address->id), // Assuming you have a function called otherAddress
                ];
            });
            $this->addresses = array_merge($this->addresses, $othersAddressArray->toArray());
        } else {

            
            $this->servicesArray[$key0]['job_address'] = null; // Reset the address if no service is selected
            $this->reset('addresses');
            /*load the others address*/
            $this->addresses[] = Address::where('user_id', $id)->get()->map(function ($address) {
                return [
                    'address_for' => $address->address_for,
                    'address' => otherAddres($address->id),
                ];
            });

            
        }
    }


    


    public function render()
    {
        $this->GetCustomerType();
        $data['customers'] = User::role('Customer')->get();
        $data['employees'] = User::role('Employee')->get();
        $data['acd'] = $this->customer['value'] ?? null;
        $data['services'] = Service::where('user_id', $this->customer['value'] ?? null)->where('status', 1)->get();
        $data['optionalproducts'] = Optionalproduct::all();
        return view('livewire.add-job', $data);
    }
}
