<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Joblist;
use App\Models\Emplyeetransaction;
use App\Models\Optionalproduct;
use App\Models\Service;
use App\Models\User;
use App\Models\Taskfile;
use App\Models\Task;
use App\Models\Address;
use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


class JobCalendar extends Component
{
    use WithFileUploads;
    public $events;
    public $employee_message;
    public $taskfiles=[];

    public $latitude;
    public $longitude;


    /*veriables for edit any job*/
    public $customer;
    public $customer_type;
    public $job_date;
    public $job_time;
    public $checkin;
    public $checkin_time;
    public $checkout;
    public $checkout_time;
    public $service;
    public $address;
    public $task_hour;
    public $recurrence_type;
    public $number_of_people;
    public $code_from_the_door;
    public $job_notes;
    public $optionals=[];
    public $employee;
    public $job_row;

    public $addresses=[];


    /*veriables for adding job*/
    public $new_customer;
    public $new_customer_type;
    public $new_job_date;
    public $new_job_time;
    public $new_checkin;
    public $new_checkin_time;
    public $new_checkout;
    public $new_checkout_time;
    public $new_service;
    public $new_address;
    public $new_task_hour;
    public $new_recurrence_type;
    public $new_number_of_people;
    public $new_code_from_the_door;
    public $new_job_notes;
    public $new_optionals=[];
    public $new_employee;

    public $new_addresses=[];

    public function mount()
    {
        $directoryName = 'taskfiles';
        $directoryPath = storage_path('app/public/'.$directoryName);

        if (!File::exists($directoryPath)) {
            File::makeDirectory($directoryPath);
        }
    }

    public function updateAddress()
    {
        /* addresses */
        $selectedService = serviceAddress($this->service);
        if ($selectedService) {
            $this->reset('addresses');
            $this->addresses[] = [
                'address_for' => 'service',
                'address' => $selectedService,
            ];
            $othersAddressArray = Address::where('user_id', $this->customer)->get()->map(function ($address) {
                return [
                    'address_for' => $address->address_for,
                    'address' => otherAddres($address->id), // Assuming you have a function called otherAddress
                ];
            });
            $this->addresses = array_merge($this->addresses, $othersAddressArray->toArray());
        } else {
            $this->reset('addresses');
            /*load the others address*/
            $this->addresses[] = Address::where('user_id', $this->customer)->get()->map(function ($address) {
                return [
                    'address_for' => $address->address_for,
                    'address' => otherAddres($address->id),
                ];
            });


        }
        /*address*/


    }


    public function updateNewAddress()
    {
        /* addresses */

        if ($this->new_service) {
            # code...
            $selectedService = serviceAddress($this->new_service);


            if ($selectedService) {
                $this->reset('new_addresses');
                $this->new_addresses[] = [
                    'address_for' => 'service',
                    'address' => $selectedService,
                ];
                $othersAddressArray = Address::where('user_id', $this->new_customer)->get()->map(function ($address) {
                    return [
                        'address_for' => $address->address_for,
                        'address' => otherAddres($address->id), // Assuming you have a function called otherAddress
                    ];
                });
                $this->new_addresses = array_merge($this->new_addresses, $othersAddressArray->toArray());


            } else {
                $this->reset('new_addresses');
                /*load the others address*/
                $this->new_addresses = Address::where('user_id', $this->new_customer)->get()->map(function ($address) {
                    return [
                        'address_for' => $address->address_for,
                        'address' => otherAddres($address->id),
                    ];
                });
            }

            // Find the first item where 'address_for' is 'Billing Address'
            $firstBillingAddress = collect($this->new_addresses)->first(function ($item) {
                return $item['address_for'] === 'Billing Address';
            });

            $this->new_address = $firstBillingAddress ? $firstBillingAddress['address'] : null;

            if (!$firstBillingAddress) {
                $firstBillingAddress = collect($this->new_addresses)->first(function ($item) {
                    return $item['address_for'] === 'service';
                });
                $this->new_address = $firstBillingAddress ? $firstBillingAddress['address'] : null;
            }

            if (!$firstBillingAddress) {
                $firstBillingAddress = collect($this->new_addresses)->first(function ($item) {
                    return $item['address_for'] === 'location';
                });
                $this->new_address = $firstBillingAddress ? $firstBillingAddress['address'] : null;
            }



        } else{
            $this->new_addresses = [];
        }
        /*address*/


    }


    public function GetCustomerType()
    {
        $id = $this->customer ?? null;
        $customer = $id ? User::find($id) : null;

        if ($customer) {
            $this->customer_type = Str::lower($customer->customer_type) ?? null;
        } else {
            $this->reset('customer_type');
        }
    }

    public function GetNewCustomerType()
    {
        $id = $this->new_customer ?? null;
        $customer = $id ? User::find($id) : null;

        if ($customer) {
            $this->new_customer_type = Str::lower($customer->customer_type) ?? null;
        } else {
            $this->reset('new_customer_type');
        }

    }


    public function addNewJob()
    {
        $this->validate(
            [
                'new_customer' => 'required',
                'new_employee' => 'required',
                'new_job_date' => ['required_if:new_customer_type,company,private'],
                'new_job_time' => ['required_if:new_customer_type,company,private'],
                'new_checkin' => 'required_if:new_customer_type,host',
                'new_checkin_time' => 'required_if:new_customer_type,host',
                'new_checkout' => 'required_if:customer_type,host',
                'new_checkout_time' => 'required_if:customer_type,host',
                'new_service' => 'required',
                'new_address' => 'required',
                'new_task_hour' => 'required',
                'new_recurrence_type' => 'required',
            ],
            [
                'new_customer.required' => 'Customer Not Selected.',
                'new_employee.required' => 'Employee Not Selected.',
                'new_job_date.required_if' => '',
                'new_job_time.required_if' => '',
                'new_checkin.required_if' => '',
                'new_checkin_time.required_if' => '',
                'new_checkout.required_if' => '',
                'new_checkout_time.required_if' => '',
                'new_service.required' => 'required',
                'new_address.required' => 'required',
                'new_task_hour.required' => 'required',
                'new_recurrence_type.required' => 'required',
            ]
        );


        $hourly_rate = 0.00;
        $currency = NULL;
        if ($this->new_employee) {
            $employee    = User::find($this->new_employee);
            $hourly_rate = $employee->setting['hourly_rate'];
            $currency    = $employee->setting['currency'];

            if ($hourly_rate == 0) {
                $this->dispatch('warning', message: 'Employee Did not Set the Hourly Rate.');
                return;
            }
        }


        $checkin = null;
        $checkout = null;
        $job_date = null;
        if (customerType($this->new_customer) == 'host') {
            $checkin = $this->new_checkin && $this->new_checkin_time ? parseDateTimeForPC($this->new_checkin.' '.$this->new_checkin_time) : null;
            $checkout = $this->new_checkout && $this->new_checkout_time ? parseDateTimeForPC($this->new_checkout.' '.$this->new_checkout_time) : null;
        } else {
            $job_date = $this->new_job_date && $this->new_job_time ? parseDateTimeForPC($this->new_job_date.' '.$this->new_job_time) : null;
        }


        Joblist::create([
            'user_id'            => $this->new_customer,
            'checkin'            => $checkin,
            'checkout'           => $checkout,
            'job_date'           => $job_date,
            'total_task_hour'    => $this->new_task_hour ? $this->new_task_hour : null,
            'hourly_rate'        => $hourly_rate,
            'currency'           => $currency,
            'recurrence_type'    => $this->new_recurrence_type ? $this->new_recurrence_type : null,
            'job_notes'          => $this->new_job_notes ? $this->new_job_notes : null,
            'optional_product'   => $this->new_optionals ? json_encode($this->new_optionals) : json_encode([]),
            'employee_id'        => $this->new_employee ? $this->new_employee : null,
            'service_id'         => $this->new_service ? $this->new_service : null,
            'job_address'        => $this->new_address ? $this->new_address : null,
            'job_status'         => $this->new_employee ? '2' : '1',
            'number_of_people'   => $this->new_number_of_people ? $this->new_number_of_people : null,
            'code_from_the_door' => $this->new_code_from_the_door ? $this->new_code_from_the_door : null,
            'service_price'      => $this->new_service ? servicePrice($this->new_service) : null,
        ]);


        $this->dispatch('success', message: 'Added Successfully.');
        return $this->redirect('/admin/jobs-calendar' , navigate:false);
    }

    public function editJob($id)
    {
        $this->reset([
            'customer',
            'job_date',
            'job_time',
            'checkin',
            'checkin_time',
            'checkout',
            'checkout_time',
            'service',
            'address',
            'task_hour',
            'recurrence_type',
            'number_of_people',
            'code_from_the_door',
            'job_notes',
            'optionals',
            'employee',
            'job_row'
        ]);
        if (role_name(Auth::user()->id) == 'Administrator') {
            $this->job_row  = Joblist::find($id);
            $this->customer = $this->job_row ? $this->job_row->user_id : $this->customer;
            $this->job_date = $this->job_row && $this->job_row->job_date ? $this->job_row->job_date->toDateTimeString() : $this->job_date;
            $this->job_time = $this->job_row && $this->job_row->job_date ? $this->job_row->job_date->toTimeString() : $this->job_time;

            $this->checkin = $this->job_row && $this->job_row->checkin ? $this->job_row->checkin->toDateTimeString() : $this->checkin;
            $this->checkin_time = $this->job_row && $this->job_row->checkin ? $this->job_row->checkin->toTimeString() : $this->checkin_time;

            $this->checkout = $this->job_row && $this->job_row->checkout ? $this->job_row->checkout->toDateTimeString() : $this->checkout;
            $this->checkout_time = $this->job_row && $this->job_row->checkout ? $this->job_row->checkout->toTimeString() : $this->checkout_time;

            $this->service  = $this->job_row && $this->job_row->service_id ? $this->job_row->service_id : $this->service;
            $this->address  = $this->job_row && $this->job_row->job_address ? $this->job_row->job_address : $this->address;
            $this->task_hour = $this->job_row && $this->job_row->total_task_hour ? $this->job_row->total_task_hour : $this->task_hour;
            $this->recurrence_type = $this->job_row && $this->job_row->recurrence_type ? $this->job_row->recurrence_type : $this->recurrence_type;
            $this->number_of_people = $this->job_row && $this->job_row->number_of_people ? $this->job_row->number_of_people : $this->number_of_people;
            $this->code_from_the_door = $this->job_row && $this->job_row->code_from_the_door ? $this->job_row->code_from_the_door : $this->code_from_the_door;
            $this->job_notes = $this->job_row && $this->job_row->job_notes ? $this->job_row->job_notes : $this->job_notes;
            $this->optionals = $this->job_row && $this->job_row->optional_product ? json_decode($this->job_row->optional_product) : $this->optionals;
            $this->employee = $this->job_row && $this->job_row->employee_id ? $this->job_row->employee_id : $this->employee;
            $this->updateAddress();
        }
    }


    public function updateJob()
    {
        //dd(parseDateTimeForPC($this->job_date.' '.$this->job_time));
        if ($this->job_row) {

            $checkin = null;
            $checkout = null;
            $job_date = null;
            if (customerType($this->customer) == 'host') {
                $checkin = $this->checkin ? parseDateTimeForPC($this->checkin) : null;
                $checkout = $this->checkout ? parseDateTimeForPC($this->checkout) : null;
            } else {
                $job_date = $this->job_date ? parseDateTimeForPC($this->job_date) : null;
            }


            $hourly_rate = 0.00;
            $currency = NULL;
            if ($this->employee && $this->employee) {
                $employee    = User::find($this->employee);
                $hourly_rate = $employee->setting['hourly_rate'];
                $currency    = $employee->setting['currency'];
            }


            $this->job_row->update([
                'user_id'            => $this->customer,
                'checkin'            => $checkin,
                'checkout'           => $checkout,
                'job_date'           => $job_date,
                'total_task_hour'    => $this->task_hour ? $this->task_hour : null,
                'hourly_rate'        => $hourly_rate,
                'currency'           => $currency,
                'recurrence_type'    =>  $this->recurrence_type ?  $this->recurrence_type : null,
                'job_notes'          => $this->job_notes ? $this->job_notes : null,
                'optional_product'   => $this->optionals ? json_encode($this->optionals) : null,
                'employee_id'        => $this->employee ? $this->employee : null,
                'service_id'         => $this->service ? $this->service : null,
                'job_address'        => $this->address ? $this->address : null,
                'number_of_people'   => $this->number_of_people ? $this->number_of_people : null,
                'code_from_the_door' => $this->code_from_the_door ? $this->code_from_the_door : null,
                'service_price'      => servicePrice($this->job_row->id),
            ]);
            session()->flash('success', 'Updated Successfully.');
            return $this->redirect('/admin/jobs-calendar', navigate:false);
        }
    }

    public function start($id)
    {
        $job = Joblist::find($id) ?? NULL;
        if ($job) {

            // check the job date
            $job->update(['job_status' => 3]);

            Task::create([
                'user_id'         => $job->employee_id,
                'joblist_id'      => $job->id,
                'start_time'      => now(),
                'start_latitude'  => $this->latitude,
                'start_longitude' => $this->longitude,
            ]);

            return $this->redirect('/admin/jobs-calendar');
        }
    }

    public function cancel($id)
    {
        $this->validate(
            ['employee_message' => 'required'],
            [
                'employee_message.required' => 'Enter message.'
            ]
        );
        $job = Joblist::find($id) ?? NULL;
        if ($job) {
            $job->update([
                'job_status' => 5,
                'employee_message' => $this->employee_message
            ]);
            $lastest_task = $job->tasks()->latest()->first();
            if ($lastest_task) {
                $lastest_task->update(['end_time' => now()]);
            }
            return $this->redirect('/admin/jobs-calendar');
        }
    }

    public function delete($id)
    {
        $job = Joblist::find($id) ?? NULL;
        if ($job) {
            if ($job->job_status == 1 || $job->job_status == 2) {
                $job->tasks()->delete();
                $job->delete();
                return $this->redirect('/admin/jobs-calendar', navigate:false);
            } else {
                return;
            }
        } else {
            return;
        }
    }

    public function done($id)
    {
        $this->validate(
            ['employee_message' => 'required'],
            ['employee_message.required' => 'Enter message.']
        );

        $job = Joblist::find($id) ?? NULL;
        if ($job) {

            $lastest_task = $job->tasks()->latest()->first();

            if ($lastest_task) {
                $lastest_task->update([
                    'end_time' => now(),
                    'end_latitude' => $this->latitude,
                    'end_longitude' => $this->longitude
                ]);

                /* uploades files informations */
                foreach($this->taskfiles as $taskfile){

                    $allowedExtensions = ['jpg', 'png', 'jpeg'];
                    $fileExtension = $taskfile->getClientOriginalExtension();
                    if (in_array($fileExtension, $allowedExtensions)) {

                        /*
                        $filename = $taskfile->getClientOriginalName();
                        $uploaded = Storage::disk('public')->put('taskfiles', $taskfile);*/

                        $uploaded = uploadFTP($taskfile);

                        Taskfile::create([
                            'user_id' => $lastest_task->user_id,
                            'joblist_id' => $lastest_task->joblist_id,
                            'task_id' => $lastest_task->task_id,
                            'caption' => $this->employee_message,
                            'filename' => $uploaded,
                        ]);
                    }
                }

                /*calculate employee hour*/
                $new_hour = 0;
                $new_minutes = 0;

                $years = intval(getYearFromDateTime($lastest_task->start_time, $lastest_task->end_time));
                if ($years > 0) {
                    $days = $years*365;
                    $new_hour += $days*24;
                }

                $months = intval(getMonthsFromDateTime($lastest_task->start_time, $lastest_task->end_time));
                if ($months > 0) {
                    $days = $months*30;
                    $new_hour += $days*24;
                }

                $days = intval(getDaysFromDateTime($lastest_task->start_time, $lastest_task->end_time));

                if ($days > 0) {
                    $new_hour += $days*24;
                }

                $hours = intval(getHoursFromDateTime($lastest_task->start_time, $lastest_task->end_time));
                if ($hours > 0) {
                    $new_hour += $hours;
                }

                $minutes = intval(getMinutesFromDateTime($lastest_task->start_time, $lastest_task->end_time));
                if ($minutes > 0) {
                    $new_minutes += $minutes;
                    if ($new_minutes < 10) {
                        $new_minutes = '0'.$new_minutes;
                    }
                }

                if ($new_hour < 2) {
                    $new_hour = 2;
                    $new_minutes = 0;
                }

                $employee_price = calculatePrice($job->hourly_rate, $new_hour.'.'.$new_minutes) + OptionalProductPriceOfJoblist($job->id);
                $customer_price = customerPrice($job->id, $job->total_task_hour);
                $company_profit = $customer_price - $employee_price;

                $job->update([
                    'job_status' => 4,
                    'employee_message' => $this->employee_message,
                    'employee_hours' => $new_hour.'.'.$new_minutes,
                    'employee_price' => $employee_price,
                    'customer_hours' => $job->total_task_hour,
                    'customer_price' => $customer_price,
                    'total_price'    => $company_profit,
                ]);


                Emplyeetransaction::create([
                    'user_id'    => $job->employee_id,
                    'service_id' => $job->service_id,
                    'joblist_id' => $job->id,
                    'amount'     => calculateTotalBillAmount(ExactJobCompletedTotalHour($job->id), $job->hourly_rate, $job->id),
                    'type'       => 'income',
                    'status'     => 'added',
                ]);
            }



            return $this->redirect('/admin/jobs-calendar');
        }
    }

    public function undoIt($id)
    {
        $job = Joblist::find($id);

        if ($job) {

            if ($job->invoice_created=='no') {
                if (role_name(Auth::user()->id) == 'Administrator') {

                    // clear the tasks table
                    $tasks = Task::where('joblist_id', $id)->delete();

                    // clear the taskfiles
                    $files = Taskfile::where('joblist_id', $id)->delete();

                    // clear the employeetransacions
                    $transactions = Emplyeetransaction::where('joblist_id', $id)->delete();

                    // & finally reset & update the Job
                    $job->update([
                        'job_status'       => 2,
                        'employee_message' => NULL,
                        'employee_hours'   => 0,
                        'employee_price'   => 0,
                        'customer_hours'   => 0,
                        'customer_price'   => 0,
                        'total_price'      => 0,
                    ]);
                }
            }


        }

        return $this->redirect('/admin/jobs-calendar');
    }


    public function render()
    {

        if (role_name(Auth::user()->id) == 'Administrator') {
            $events = Joblist::get()->map(function ($item) {

                $optional_products = $item->optional_product ? Optionalproduct::whereIn('id', json_decode($item->optional_product))->pluck('name')->toArray() : [];
                $Childrenbeds = '';

                if (in_array('Children beds', $optional_products)) {
                    $Childrenbeds = '<i class="fe fe-user"></a>';
                }

                $buildTitle = '';
                if ($item->job_date) {
                    $buildTitle = parseTimeForHumans2($item->job_date).'<br>';
                } else {
                    if ($item->checkout) {
                        $buildTitle = parseTimeForHumans2($item->checkout).'<br>';
                    }
                }

                if ($item->service) {
                    $buildTitle = $buildTitle.$item->service['title'].'<br>';
                }

                if ( $item->number_of_people) {
                    $buildTitle = $buildTitle.$item->number_of_people.' '.$Childrenbeds.'<br>';
                }

                if ($item->user_id) {
                    $buildTitle = $buildTitle.'<img style="width:25px;border-radius: 50%" src="'.user_photo($item->user_id).'"> '.customerName($item->user_id).'<br>';
                }

                if ($item->employee_id) {
                    $buildTitle = $buildTitle.'<img style="width:25px;border-radius: 50%" src="'.user_photo($item->employee_id).'"> '.employeeName($item->employee_id);
                }

                $merged_journals = json_decode($item->journals, true) ?? [];

                foreach ($merged_journals as &$journal) {
                    $journal['full_name'] = fullName($journal['user_id']);
                }

                return [
                    'id'       => $item->id,
                    'title'    => $buildTitle,
                    'start'    => startDate($item->id),
                    'end'      => endDate($item->id),
                    'color'    => statusColor($item->id),
                    'textColor'=> textColor(statusColor($item->id)),
                    'overlap'  => 'false',
                    'editable' => 'true',
                    'details'  => [
                        'panel' => 'Administrator',
                        'customer_id' => $item->user_id,
                        'employee_id' => $item->employee_id,
                        'emp_photo' => $item->employee ? employeePhoto($item->employee_id) : avater(),
                        'emp_name'  => $item->employee ? employeeName($item->employee_id) : 'n/a',
                        'emp_email' => $item->employee ? employeeEmail($item->employee_id) : 'n/a',
                        'emp_phone' => $item->employee ? employeePhone($item->employee_id) : 'n/a',
                        'customer_name' => customerName($item->user_id),
                        'customer_email' => customerEmail($item->user_id),
                        'job_name'       => $item->service ? $item->service['title'] : 'n/a',
                        'job_address'    => $item->job_address,
                        'checkin'        => $item->checkin ? parseDateTimeForHumans($item->checkin) : null,
                        'checkout'       => $item->checkout ? parseDateTimeForHumans($item->checkout) : null,
                        'job_date'       => $item->job_date ? parseDateTimeForHumans($item->job_date) : null,
                        'job_hour'       => $item->total_task_hour ? $item->total_task_hour : 0,
                        'job_recurrence_type' => $item->recurrence_type ? $item->recurrence_type : 'n/a',
                        'job_people'    => $item->number_of_people ? $item->number_of_people : 0,
                        'job_door_code' => $item->code_from_the_door ? $item->code_from_the_door : 'n/a',
                        'job_notes'     => $item->job_notes ? $item->job_notes : 'n/a',
                        'job_status'    => status($item->id),
                        'job_start_time' => startedJobTime($item->id),
                        'optional'       => $item->optional_product ? Optionalproduct::whereIn('id', json_decode($item->optional_product))->pluck('name')->toArray() : [],
                        'children'       => $Childrenbeds,
                        'journals'       => $merged_journals,
                    ]
                ];
            });
        } else {
            $events = Joblist::where('employee_id', Auth::user()->id)->whereIn('job_status',['1','2','3'])->get()->map(function ($item) {
                $optional_products = Optionalproduct::whereIn('id', json_decode($item->optional_product))->pluck('name')->toArray();
                $Childrenbeds = '';

                if (in_array('Children beds', $optional_products)) {
                    $Childrenbeds = '<i class="fe fe-user"></a>';
                }

                $buildTitle = '';
                if ($item->job_date) {
                    $buildTitle = parseTimeForHumans2($item->job_date).'<br>';
                } else {
                    if ($item->checkout) {
                        $buildTitle = parseTimeForHumans2($item->checkout).'<br>';
                    }
                }

                if ($item->service) {
                    $buildTitle = $buildTitle.$item->service['title'].'<br>';
                }

                if ( $item->number_of_people) {
                    $buildTitle = $buildTitle.$item->number_of_people.' '.$Childrenbeds.'<br>';
                }

                if ($item->user_id) {
                    $buildTitle = $buildTitle.customerName($item->user_id).'<br>';
                }

                if ($item->employee_id) {
                    $buildTitle = $buildTitle.employeeName($item->employee_id);
                }

                // $merged_journals = json_decode($item->journals, true) ?? [];

                // foreach ($merged_journals as &$journal) {
                //     $journal['full_name'] = fullName($journal['user_id']);
                // }

                $merged_journals = json_decode($item->journals, true) ?? [];
                $currentUserId   = Auth::user()->id;
                $user_journals = [];
                foreach ($merged_journals as &$journal) {
                    if ($journal['user_id'] == $currentUserId) {
                        $journal['full_name'] = fullName($journal['user_id']);
                        $user_journals[] = $journal;
                    }
                }

                return [
                    'id'       => $item->id,
                    'title'    => $buildTitle,
                    'start'    => startDate($item->id),
                    'end'      => endDate($item->id),
                    'color'    => statusColor($item->id),
                    'textColor'=> textColor(statusColor($item->id)),
                    'overlap'  => 'false',
                    'editable' => 'true',
                    'details'  => [
                        'panel' => 'Administrator',
                        'customer_id' => $item->user_id,
                        'employee_id' => $item->employee_id,
                        'emp_photo' => $item->employee ? employeePhoto($item->employee_id) : avater(),
                        'emp_name'  => $item->employee ? employeeName($item->employee_id) : 'n/a',
                        'emp_email' => $item->employee ? employeeEmail($item->employee_id) : 'n/a',
                        'emp_phone' => $item->employee ? employeePhone($item->employee_id) : 'n/a',
                        'customer_name' => customerName($item->user_id),
                        'customer_email' => customerEmail($item->user_id),
                        'job_name'       => $item->service ? $item->service['title'] : 'n/a',
                        'job_address'    => $item->job_address,
                        'checkin'        => $item->checkin ? parseDateTimeForHumans($item->checkin) : null,
                        'checkout'       => $item->checkout ? parseDateTimeForHumans($item->checkout) : null,
                        'job_date'       => $item->job_date ? parseDateTimeForHumans($item->job_date) : null,
                        'job_hour'       => $item->total_task_hour ? $item->total_task_hour : 0,
                        'job_recurrence_type' => $item->recurrence_type ? $item->recurrence_type : 'n/a',
                        'job_people'    => $item->number_of_people ? $item->number_of_people : 0,
                        'job_door_code' => $item->code_from_the_door ? $item->code_from_the_door : 'n/a',
                        'job_notes'     => $item->job_notes ? $item->job_notes : 'n/a',
                        'job_status'    => status($item->id),
                        'job_start_time' => startedJobTime($item->id),
                        'optional'       => Optionalproduct::whereIn('id', json_decode($item->optional_product))->pluck('name')->toArray(),
                        'children'       => $Childrenbeds,
                        'journals'       => $user_journals,
                    ]
                ];
            });
        }

        $this->events = json_encode($events);

        $this->GetCustomerType();
        $this->GetNewCustomerType();
        $this->updateNewAddress();

        $data['optionalproducts'] = Optionalproduct::all();
        $data['customers'] = User::role('Customer')->get();
        $data['employees'] = User::role('Employee')->get();
        $data['services'] = Service::when($this->customer, function($query, $customer){
            return $query->where('user_id', $customer);
        })
        ->when($this->new_customer, function($query, $new_customer){
            return $query->where('user_id', $new_customer);
        })
        ->where('status', 1)->get();
        return view('livewire.job-calendar', $data);
    }
}
