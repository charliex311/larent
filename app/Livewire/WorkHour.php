<?php

namespace App\Livewire;


use Illuminate\Http\Request;
use Livewire\Component;
use App\Models\Joblist;
use App\Models\Service;
use App\Models\Task;
use App\Models\Emplyeetransaction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Carbon\Carbon;


class WorkHour extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $from;
    public $to;
    public $customer;
    public $service;
    public $employee;


    /* for job edit */
    public $row;
    public $message;
    public $start_time;
    public $end_time;
    public $employee_hours;
    public $customer_hours;


    public $editrows=[];
    public $lists=[];
    

    public function mount(Request $request)
    {
        $this->from     = $request->from;
        $this->to       = $request->to;
        $this->customer = $request->customer;
        $this->service  = $request->service;
        $this->employee = $request->employee;
    }

    public function search()
    {
        $query = '/admin/works-hour?from='.$this->from.'&&to='.$this->to.'&&customer='.$this->customer.'&&service='.$this->service.'&&employee='.$this->employee;
        return $this->redirect($query, navigate: false);
    }


    public function edit($ID)
    {
        $job = Joblist::find($ID);
        if ($job) {
            if ($job->job_status == '4') {
                $this->row = $job;
                $task = $this->row ? $this->row->tasks()->first() : null;
                $this->message = $this->row ? $this->row->employee_message : $this->message;
                $this->start_time = $task && $task->start_time ? $task->start_time->toDateTimeString() : $this->start_time;
                $this->end_time = $task && $task->end_time ? $task->end_time->toDateTimeString() : $this->end_time;
                $this->employee_hours = $this->row ? $this->row->employee_hours : $this->employee_hours;
                $this->customer_hours = $this->row ? $this->row->customer_hours : $this->customer_hours;
            }
        }
    }

    public function updateChangedMessage($key,$rowID)
    {
        $job     = Joblist::find($rowID);
        $message = $this->editrows[$key]['employee_message'];

        if ($job && Auth::user()->hasPermissionTo('work-edit-message')) {
            if ($job->job_status == '4') {
                $job->update([
                    'employee_message' => $message
                ]);
            } // if Job is completed
        }
    }

    public function startEndTimeTrigger($key, $rowID)
    {
        $job  = Joblist::find($rowID);
        $task = $job && $job->tasks()->first() ? $job->tasks()->first() : NULL;
        $employee_transaction = $job ? Emplyeetransaction::where('joblist_id', $job->id)->first() : NULL;

        if (Auth::user()->hasPermissionTo('work-edit-start-time') || Auth::user()->hasPermissionTo('work-edit-stop-time')) {
            if ($job && $task && $employee_transaction) {
    
                // if Job is completed
                if ($job->job_status == '4') {
                    $new_hour = 0;
                    $new_minutes = 0;
                    $years = intval(getYearFromDateTime($this->editrows[$key]['start_time'], $this->editrows[$key]['end_time']));
                    if ($years > 0) {
                        $days = $years*365;
                        $new_hour += $days*24;
                    }
                    $months = intval(getMonthsFromDateTime($this->editrows[$key]['start_time'], $this->editrows[$key]['end_time']));
                    if ($months > 0) {
                        $days = $months*30;
                        $new_hour += $days*24;
                    }
                    $days = intval(getDaysFromDateTime($this->editrows[$key]['start_time'], $this->editrows[$key]['end_time']));
                    if ($days > 0) {
                        $new_hour += $days*24;
                    }
                    $hours = intval(getHoursFromDateTime($this->editrows[$key]['start_time'], $this->editrows[$key]['end_time']));
                    if ($hours > 0) {
                        $new_hour += $hours;
                    }
                    $minutes = intval(getMinutesFromDateTime($this->editrows[$key]['start_time'], $this->editrows[$key]['end_time']));
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
                    $task->update([
                        'start_time' => Carbon::parse($task->start_time->toDateString().' '.$this->editrows[$key]['start_time']),
                        'end_time' => Carbon::parse($task->start_time->toDateString().' '.$this->editrows[$key]['end_time']),
                    ]);
                    $employee_price = calculatePrice($job->hourly_rate, $new_hour.'.'.$new_minutes) + OptionalProductPriceOfJoblist($job->id);
                    $task->update([
                        'end_time'   => Carbon::parse($task->start_time)->addHours($new_hour)->addMinutes($new_minutes),
                    ]);
                    $job->update([
                        'employee_hours' => $new_hour.'.'.$new_minutes,
                        'employee_price'   => $employee_price,
                    ]);
                    $employee_transaction->update([
                        'amount' => calculateTotalBillAmount(ExactJobCompletedTotalHour($job->id), $job->hourly_rate, $job->id),
                    ]);
                    $this->editrows->put($key, array_merge($this->editrows[$key], [
                        'end_time' => Carbon::parse($task->start_time)->addHours($new_hour)->addMinutes($new_minutes)->toTimeString(),
                        'employee_hours' => $new_hour.'.'.$new_minutes,
                        'employee_price' => $employee_price
                    ]));
                }
                //$this->editrows->put($key, array_merge($this->editrows[$key], ['employee_hours' => $new_hour.'.'.$new_minutes]));
            }
        }

    }


    public function employeeHoursTrigger($key, $rowID)
    {
        $job  = Joblist::find($rowID);
        $task = $job && $job->tasks()->first() ? $job->tasks()->first() : null;
        $employee_transaction = $job ? Emplyeetransaction::where('joblist_id', $job->id)->first() : NULL;

        if (Auth::user()->hasPermissionTo('work-edit-employee-hours')) {
            if ($job && $task && $employee_transaction) {
    
                // if Job is completed
                if ($job->job_status == '4') {
                    $hour = $this->editrows[$key]['employee_hours'];
    
                    if ($hour != 0 || $hour != '0') {
    
                        $hour = strpos($hour,'.') !== false ? $hour : $hour.'.00' ;
                        list($hours, $minutes) = explode('.', $hour);
                        $hours = intval($hours);
                        $minutes = $minutes;
                
                        if ($minutes >= 60) {
                            $hours += intdiv($minutes, 60);
                            $minutes %= 60;
                        }
                
                        if ($hours < 2) {
                            //$this->editrows[$key]['employee_hours'] = 2;
                            $hours = 2;
                            $minutes = 0;
                        }
            
                        $employee_price = calculatePrice($job->hourly_rate, $hours.'.'.$minutes) + OptionalProductPriceOfJoblist($job->id);
                        
                        $task->update([
                            'end_time'   => Carbon::parse($task->start_time)->addHours($hours)->addMinutes($minutes),
                        ]);
            
                        $job->update([
                            'employee_hours' => $hours.'.'.$minutes,
                            'employee_price'   => $employee_price,
                        ]);
    
                        $employee_transaction->update([
                            'amount' => calculateTotalBillAmount(ExactJobCompletedTotalHour($job->id), $job->hourly_rate, $job->id),
                        ]);
            
                        $this->editrows->put($key, array_merge($this->editrows[$key], [
                            'end_time' => Carbon::parse($task->start_time)->addHours($hours)->addMinutes($minutes)->toTimeString(),
                            'employee_hours' => $hours.'.'.$minutes,
                            'employee_price' => $employee_price
                        ]));
                    }
    
                }
    
            }
        }

    }


    public function customerHoursTrigger($key, $rowID)
    {
        $job  = Joblist::find($rowID);
        $task = $job && $job->tasks()->first() ? $job->tasks()->first() : null;

        if (Auth::user()->hasPermissionTo('work-edit-customer-hours')) {
            if ($job && $task) {
    
                // if Job is completed
    
                if ($job->job_status == '4') {
    
                    $hour = $this->editrows[$key]['customer_hours'];
    
                    if ($hour != 0 || $hour != '0') {
    
                        $hour = strpos($hour,'.') !== false ? $hour : $hour.'.00' ;
                        list($hours, $minutes) = explode('.', $hour);
                        $hours = intval($hours);
                        $minutes = $minutes;
                
                        if ($minutes >= 60) {
                            $hours += intdiv($minutes, 60);
                            $minutes %= 60;
                        }
        
        
                        $employee_price = $job->employee_price;
                        $customer_price = customerPrice($job->id, $hours.'.'.$minutes);
                        $company_profit = $customer_price - $employee_price;
        
                        $job->update([
                            'customer_hours' => $hours.'.'.$minutes,
                            'customer_price' => $customer_price,
                            'total_price'    => $company_profit,
                        ]);
        
                        $this->editrows->put($key, array_merge($this->editrows[$key], [
                            'customer_hours' => $hours.'.'.$minutes,
                            'customer_price' => $customer_price,
                            'total_price'    => $company_profit,
                        ]));
                    }
                }
            }
        }

    }

    public function saveChanges()
    {
        $task = $this->row->tasks()->first();

        if ($task) {

            $task->update([
                'start_time' => Carbon::parse($this->start_time),
                'end_time'   => Carbon::parse($this->end_time),
            ]);
            
            $employee_price = calculatePrice($this->row->hourly_rate, $this->employee_hours) + OptionalProductPriceOfJoblist($this->row->id);
            $customer_price = customerPrice($this->row->id, $this->customer_hours);
            $company_profit = $customer_price - $employee_price;

            $this->row->update([
                'employee_message' => $this->message,
                'employee_hours'   => $this->employee_hours,
                'employee_price'   => $employee_price,
                'customer_hours'   => $this->customer_hours,
                'customer_price'   => $customer_price,
                'total_price'      => $company_profit,
            ]);

            $this->clearFileds();
        }

    }

    public function clearFileds()
    {
        $this->reset(['row','message','start_time','end_time','employee_hours','customer_hours']);
    }

    
    public function render()
    {

        /* start_time & end_time & employee hours*/

        $this->reset(['lists','editrows']);

        $firstDayOfMonth = Carbon::now()->startOfMonth(); // Get the first day of the current month
        $lastDayOfMonth = Carbon::now()->endOfMonth(); // Get the last day of the current month

        if (role_name(Auth::user()->id) == 'Administrator') {

            $this->lists = Joblist::when($this->customer, function($query, $customer){
                return $query->where('user_id',$customer);
            })
            ->when($this->service, function($query, $service){
                return $query->where('service_id', $service);
            })
            ->when($this->employee, function($query, $employee){
                return $query->where('employee_id', $employee);
            })
            ->when($this->from && $this->to, function($query){

                $from = Carbon::parse($this->from)->startOfDay();
                $to = Carbon::parse($this->to)->endOfDay();
                return $query->whereBetween('job_date', [$from, $to]);
            })
            ->latest()
            ->get();

        } elseif(role_name(Auth::user()->id) == 'Employee') {
            $this->lists = Joblist::where('employee_id', Auth::user()->id)
            ->whereIn('job_status',['3','4'])
            ->whereBetween('created_at', [$firstDayOfMonth, $lastDayOfMonth])
            ->latest()
            ->get();
        
        } elseif (role_name(Auth::user()->id) == 'Customer') {
            $this->lists = Joblist::where('user_id', Auth::user()->id)->latest()->get();
        }

        $this->editrows = $this->lists->map(function($i){
            return [
                'employee_message' => $i->employee_message,
                'start_time'       => $i->tasks()->first() && $i->tasks()->first()->start_time ? $i->tasks()->first()->start_time->toTimeString() : null,
                'end_time'         => $i->tasks()->first() && $i->tasks()->first()->end_time ? $i->tasks()->first()->end_time->toTimeString() : null,
                'employee_hours'   => $i->employee_hours ? $i->employee_hours : 0,
                'employee_price'   => $i->employee_price ? $i->employee_price : 0,
                'customer_hours'   => $i->customer_hours ? $i->customer_hours : 0,
                'customer_price'   => $i->customer_price ? $i->customer_price : 0,
                'total_price'      => $i->total_price ? $i->total_price : 0,
            ];
        });

        $data['customers'] = User::role('Customer')->get();
        $data['employees'] = User::role('Employee')->get();
        $data['services']  = Service::all();
        return view('livewire.work-hour', $data);
    }
}
