<?php


use App\Models\Setting;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Secondarycontact;
use App\Models\Service;
use App\Models\Address;
use App\Models\Joblist;
use App\Models\Conversation;
use App\Models\Paymentmethod;
use App\Models\Emplyeetransaction;
use App\Models\Deposithistory;
use App\Models\Optionalproduct;
use App\Models\Customertransaction;
use App\Models\Invoice;
use App\Models\Withdraw;
use App\Models\Pop;
use App\Models\Task;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


function globalPopID()
{
    $id = '';
    if (Auth::check()) {
        $pop = Pop::latest()->where('user_id', Auth::id())->where('status', 'active')->first();
        if ($pop) {
            $id = $pop->id;
        }
    }
    return $id;
}


function globalTax()
{
    $tax = 19;
    return doubleval($tax);
}

function companyname()
{
    $company_name = Setting::find(1) && Setting::find(1)->company ? Setting::find(1)->company : config('app.name');
    return $company_name;
}


function companyEmail()
{
    $company_email = Setting::find(1) && Setting::find(1)->company_email ? Setting::find(1)->company_email : '';
    return $company_email;
}


function companyWebsite()
{
    $website = Setting::find(1) && Setting::find(1)->website ? Setting::find(1)->website : '';
    return $website;
}

function companyAddress()
{
    $company_address = Setting::find(1) && Setting::find(1)->company_address ? Setting::find(1)->company_address : '';
    return $company_address;
}

function defaultProfilePhotoUrl($name=null)
{
    // return 'https://ui-avatars.com/api/?name='.urlencode($name).'&color=7F9CF5&background=ffffff';
    return config('app.url').'/public/abdul_alim.jpg';
}

function avater()
{
    $faker = \Faker\Factory::create();
    return 'https://ui-avatars.com/api/?name='.urlencode($faker->name).'&color=ffffff&background=000000';
}

function user_photo($id)
{
    $data = \App\Models\User::find($id);
    return $data && $data->photo ? $data->photo : 'https://ui-avatars.com/api/?name='.urlencode(fullName($id)).'&color=ffffff&background=000000';
}

/*administrator*/
function admin_avater()
{
    if (Auth::check()) {
        return photo(1);
    } else {
        return avater();
    }
}

function admin_name()
{
    if (Auth::check()) {
        return fullName(1);
    } else {
        return null;
    }
}

/* /administrator  */

function photo($userId)
{
    $photo = '';
    $user = User::find($userId) ?? NULL;

    if ($user) {
        if ($user->photo != null) {
            if (file_exists(public_path('/').'/storage/'.$user->photo)) {
                $photo = asset('/public').'/storage/'.$user->photo;
            } else {
                $photo = defaultProfilePhotoUrl($user->first_name.' '.$user->last_name);
            }
        } else {
            $photo = defaultProfilePhotoUrl($user->first_name.' '.$user->last_name);
        }
    } else {
        $photo = avater();
    }

    return $photo;
}


function fullName($id)
{
    $name = '';
    $user = User::withTrashed()->find($id);
    if ($user) {
        if($user->hasRole('Customer') && $user->customer_type == "Company"){
            $name = $user->company_name ? $user->company_name : 'n/a';
        }else{
            if ($user->first_name) {
                $name = $user->first_name;
            }
            if ($user->last_name) {
                $name = $name . ' ' . $user->last_name;
            }
        }
    }
    return $name;
}

function contactPersonName($id)
{
    if (Auth::check()) {
        $name = '';
        $contact = Secondarycontact::find($id);
        if ($contact) {
            return $contact->name;
        }
    }
}

function ShowAccountAsCompany($id=null)
{
    $company_name = '';
    $user = User::withTrashed()->find($id);
    if ($user) {
        $setting = $user->setting;
        if ($setting) {
            if ($setting->company && $setting->company_email && $setting->website) {
                $company_name = $setting->company;
            }
        }
    }
    return $company_name;
}

function happyBirthDay()
{
    $status = false;
    $user = Auth::user();
    $today = Carbon::today();
    if ($user) {
        if ($user->date_of_birth) {
            $birthdate = Carbon::createFromFormat('Y-m-d', $user->date_of_birth->toDateString());
            if ($birthdate->month == $today->month && $birthdate->day == $today->day) {
                $status = true;
            }
        }
    }
    return $status;
}

function role_name($id)
{
    $name = User::withTrashed()->find($id)->roles()->first() ? User::withTrashed()->find($id)->roles()->first()->name : 'undefined';
    return $name;
}

function getTotalUserByRole($name)
{
    if (Auth::check()) {
        $users = User::role($name)->count();
        return $users;
    }
}

function user_emails_permission($id=null)
{
    $result = '';
    if (Auth::check()) {
        $setting = \App\Models\Setting::where('user_id', $id)->first();
        if ($setting) {
            $result = $setting->email_premissions;
        }
    }
    return $result;
}

function user_status($id)
{
    $user = User::withTrashed()->find($id) ? User::withTrashed()->find($id) : null;
    $status = 'inactive';

    if ($user) {
        if($user->deleted_at == null){
            $status = 'Active';
        } else {
            $status = 'Inactive';
        }
    }

    return $status;
}

/* service counter */

function pending_service_counter()
{
    $counter = 0;
    if (Auth::user()->id == 1) {
        $counter = Service::where('status', 0)->count();
    } else {
        $counter = Service::where('user_id', Auth::user()->id)->where('status', 0)->count();
    }

    return $counter;
}

function active_service_counter()
{
    $counter = 0;
    if (Auth::user()->id == 1) {
        $counter = Service::where('status', 1)->count();
    } else {
        $counter = Service::where('user_id', Auth::user()->id)->where('status', 1)->count();
    }

    return $counter;
}

function inactive_service_counter()
{
    $counter = 0;
    if (Auth::user()->id == 1) {
        $counter = Service::where('status', 2)->count();
    } else {
        $counter = Service::where('user_id', Auth::user()->id)->where('status', 2)->count();
    }

    return $counter;
}

function parseDateOnly($dateTime)
{
    if (Auth::check()) {
        $date = Carbon::parse($dateTime)->copy()->format('d-m-Y');
        return $date;
    }
}

function parseDateTimeForPC($dateTime)
{
    if (Auth::check()) {
        $date = Carbon::parse($dateTime)->copy()->format('Y-m-d H:i:s');
        return $date;
    }
}

function parseDateTime($dateTime)
{
    if (Auth::check()) {
        $date = Carbon::parse($dateTime)->copy()->format('d-m-Y H:i:s');
        return $date;
    }
}

function parseDateTimeForHumans($dateTime)
{
    if (Auth::check()) {
        $date = Carbon::parse($dateTime)->copy()->format('d-m-Y h:i a');
        return $date;
    }
}

function parseOnlyTimeForHumans($dateTime)
{
    if (Auth::check()) {
        $date = Carbon::parse($dateTime)->copy()->format('H:i: a');
        return $date;
    }
}

function parseTimeForHumans($dateTime)
{
    if (Auth::check()) {
        $date = Carbon::parse($dateTime)->copy()->format('H:i:s');
        return $date;
    }
}

function parseTimeForHumans2($dateTime)
{
    if (Auth::check()) {
        $date = Carbon::parse($dateTime)->copy()->format('h:i:s a');
        return $date;
    }
}


function getYearFromDateTime($start_time, $end_time)
{
    if (Auth::check()) {
        $timeDifference = '';
        if ($start_time && $end_time) {
            $startDateTime = Carbon::parse($start_time);
            $endDateTime = Carbon::parse($end_time);
            $timeDifference = $endDateTime->diff($startDateTime)->format('%y');
            return $timeDifference;
        }
    }
}

function getMonthsFromDateTime($start_time, $end_time)
{
    if (Auth::check()) {
        $timeDifference = '';
        if ($start_time && $end_time) {
            $startDateTime = Carbon::parse($start_time);
            $endDateTime = Carbon::parse($end_time);
            $timeDifference = $endDateTime->diff($startDateTime)->format('%m');
            return $timeDifference;
        }
    }
}
function getDaysFromDateTime($start_time, $end_time)
{
    if (Auth::check()) {
        $timeDifference = '';
        if ($start_time && $end_time) {
            $startDateTime = Carbon::parse($start_time);
            $endDateTime = Carbon::parse($end_time);
            $timeDifference = $endDateTime->diff($startDateTime)->format('%d');
            return $timeDifference;
        }
    }
}
function getHoursFromDateTime($start_time, $end_time)
{
    if (Auth::check()) {
        $timeDifference = '';
        if ($start_time && $end_time) {
            $startDateTime = Carbon::parse($start_time);
            $endDateTime = Carbon::parse($end_time);
            $timeDifference = $endDateTime->diff($startDateTime)->format('%H');
            return $timeDifference;
        }
    }
}

function getMinutesFromDateTime($start_time, $end_time)
{
    if (Auth::check()) {
        $timeDifference = '';
        if ($start_time && $end_time) {
            $startDateTime = Carbon::parse($start_time);
            $endDateTime = Carbon::parse($end_time);
            $timeDifference = $endDateTime->diff($startDateTime)->format('%I');
            return $timeDifference;
        }
    }
}

function getSecondsFromDateTime($start_time, $end_time)
{
    if (Auth::check()) {
        $timeDifference = '';
        if ($start_time && $end_time) {
            $startDateTime = Carbon::parse($start_time);
            $endDateTime = Carbon::parse($end_time);
            $timeDifference = $endDateTime->diff($startDateTime)->format('%S');
            return $timeDifference;
        }
    }
}

function getHour($start_time, $end_time)
{

    if (Auth::check()) {
        $timeDifference= null;
        if ($start_time && $end_time) {
            $startDateTime = Carbon::parse($start_time);
            $endDateTime = Carbon::parse($end_time);
            $timeDifference = $endDateTime->diff($startDateTime)->format('%H:%I:%S');
        }
        return $timeDifference;
    }
}

function addHourResult($first, $second)
{
    if (Auth::check()) {
        $sumFormatted = null;
        if ($first && $second) {
            $time1 = Carbon::parse($first);
            $time2 = Carbon::parse($second);
            $sum = $time1->addHours($time2->hour)->addMinutes($time2->minute)->addSeconds($time2->second);
            $sumFormatted = $sum->format('H:i:s');
        }
        return $sumFormatted;
    }
}

/*services*/
function serviceName($id)
{
    if (Auth::check()) {

        $service = Service::find($id);
        $name = '';
        if ($service) {
            $name = $service->title ? $service->title : '';
        }
        return $name;
    }

}

function serviceAddress($id)
{

    if (Auth::check()) {

        $service = Service::find($id);

        $address = '';

        if ($service) {
            $address = $service->street ? $address.$service->street : $address;
            $address = $service->postal_code ? $address.', '.$service->postal_code : $address;
            $address = $service->city ? $address.', '.$service->city : $address;
            $address = $service->country ? $address.', '.$service->country.'.' : $address;
        }

        return $address;

    }
}

function serviceUnit($id)
{

    if (Auth::check()) {

        $service = Service::find($id);
        $unit = '';
        if ($service) {
            $unit = $service->unit ? $service->unit : '';
        }

        return $unit;
    }
}

function servicePrice($id)
{

    if (Auth::check()) {

        $service = Service::find($id);
        $price = 0;
        if ($service) {
            $price = $service->price ? $service->price : 0;
        }

        return doubleval($price);
    }
}

function serviceCurrency($id)
{

    if (Auth::check()) {

        $service = Service::find($id);
        $currency = '';
        if ($service) {
            $currency = $service->currency ? $service->currency : '';
        }
        return $currency;
    }
}

function serviceTax($id)
{
    if (Auth::check()) {

        $service = Service::find($id);
        $tax = 0.00;
        if ($service) {
            $tax = $service->tax ? $service->tax : 0.00;
        }
        return doubleval($tax);
    }

}

function otherAddres($id)
{

    if (Auth::check()) {

        $data = Address::find($id);

        $address = '';

        if ($data) {
            $address = $data->street ? $address.$data->street : $address;
            $address = $data->postal_code ? $address.', '.$data->postal_code : $address;
            $address = $data->city ? $address.', '.$data->city : $address;
            $address = $data->country ? $address.', '.$data->country.'.' : $address;
        }

        return $address;
    }
}

function priceFormat($currency, $price)
{
    if (Auth::check()) {

        $modifiedPrice = $currency ? number_format($price, 2, ',', '.').$currency : number_format($price, 2, ',', '.');
        return $modifiedPrice;
    }
}

function getImageUrl($image)
{
   $img = asset('/public/storage').'/'.$image;
   return $img;
}

function systemFormattedDateTime($date)
{
    if (Auth::check()) {
        $modifiedDate = Carbon::parse($date)->toDayDateTimeString();
        return $modifiedDate;
    }
}

function getDateName($date)
{
    if (Auth::check()) {

        $dayName = '';
        if ($date) {
            $carbonDate = Carbon::parse($date);
            $dayName = $carbonDate->format('l');
            $dayName = Str::lower($dayName);
        }
        return $dayName;
    }
}

function allServiceUnits()
{
    if (Auth::check()) {

        $data = Service::pluck('unit')->unique()->toArray();
        return $data;
    }
}

/* Job List */

function completedJob()
{

    if (Auth::check()) {

        $user = Auth::user();
        $total = 0;
        $startOfMonth = Carbon::now()->startOfMonth(); // Get the start of the current month
        $endOfMonth = Carbon::now()->endOfMonth();     // Get the end of the current month
        if ($user) {
            $total = Joblist::where('employee_id', $user->id)
            ->where('job_status', '4')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->count();
        }
        return $total;
    }

}

function pendingJob()
{
    if (Auth::check()) {

        $user = Auth::user();
        $total = 0;
        $startOfMonth = Carbon::now()->startOfMonth(); // Get the start of the current month
        $endOfMonth = Carbon::now()->endOfMonth();     // Get the end of the current month
        if ($user) {
            $total = Joblist::where('employee_id', $user->id)
            ->where('job_status', '2')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->count();
        }
        return $total;
    }
}

function ExactJobCompletedTotalHour($jobID)
{
    if (Auth::check()) {

        $job = Joblist::find($jobID);
        $defaultTime = "00:00:00";
        $initialTime = Carbon::parse($defaultTime);
        foreach ($job->tasks as $task) {
            $exactTime = getHour($task->start_time, $task->end_time);
            if ($exactTime) {
                $time2 = Carbon::parse($exactTime);
                $initialTime->addHours($time2->hour)->addMinutes($time2->minute)->addSeconds($time2->second);
            }
        }
        return $initialTime->format('H:i:s');
    }

}


function getTotalHour($jobID)
{

    if (Auth::check()) {

        $defaultTime = "00:00:00";
        $initialTime = Carbon::parse($defaultTime);
        if (Auth::check()) {
            $job = Joblist::find($jobID);
            foreach ($job->tasks as $task) {
                $exactTime = getHour($task->start_time, $task->end_time);
                if ($exactTime) {
                    $time2 = Carbon::parse($exactTime);
                    $initialTime->addHours($time2->hour)->addMinutes($time2->minute)->addSeconds($time2->second);
                }
            }

            // if work hour less than 2
            if (role_name(Auth::user()->id) == 'Customer') {
                if ($initialTime->format('H') < 2) {
                    $initialTime = Carbon::parse('00:00:00');
                    $initialTime->addHours(2);
                }
            }
        }
        return $initialTime->format('H:i:s');
    }

}


function getTotalHourReadable($jobID)
{
    if (Auth::check()) {

        $time = getTotalHour($jobID);
        $initialTime = Carbon::parse($time);


        $readable = '';

        if ($initialTime->format('H') > 0) {
            $readable = '<b>'.$initialTime->format('g'). '</b>';
        }

        if ($initialTime->format('i') > 0) {
            $readable = $readable.'.<b>'.$initialTime->format('i').'</b>';
        }

        return $readable;
    }

}

function startedJobTime($jobID)
{

    if (Auth::check()) {

        $job = Joblist::find($jobID);
        $export = null;
        if ($job) {
            $task = $job->tasks()->first();
            if ($task) {
                if ($task->start_time && !$task->end_time) {
                    $export = $task->start_time;
                }
            }
        }
        return $export;
    }


}
function startDate($id)
{

    if (Auth::check()) {

        $date = '';
        $data = Joblist::find($id) ?? NULL;
        if ($data) {
            if ($data->checkin) {
                $date = $data->checkin->toDateString();
            } else {
                if ($data->job_date) {
                    $date = $data->job_date->toDateString();
                }
            }
        }

        return $date;
    }

}

function endDate($id)
{
    if (Auth::check()) {

        $date = '';
        $data = Joblist::find($id) ?? NULL;
        if ($data) {
            if ($data->checkout) {
                $date = $data->checkout->toDateString();
            } else {
                if ($data->job_date) {
                    $date = $data->job_date->toDateString();
                }
            }
        }

        return $date;
    }
}

function statusColor($id)
{
    if (Auth::check()) {

        $color = '';
        $data = Joblist::find($id) ?? NULL;
        if ($data) {
            if ($data->job_status == '1') { $color = 'blue'; }
            if ($data->job_status == '2') { $color = 'yellow'; }
            if ($data->job_status == '3') { $color = 'orange'; }
            if ($data->job_status == '4') { $color = 'green'; }
            if ($data->job_status == '5') { $color = 'red'; }
        }
        return $color;
    }
}

function status($id)
{

    if (Auth::check()) {

        $status = '';
        $data = Joblist::find($id) ?? NULL;
        if ($data) {
            if ($data->job_status == '1') { $status = 'Pending'; }
            if ($data->job_status == '2') { $status = 'Assigned'; }
            if ($data->job_status == '3') { $status = 'Working'; }
            if ($data->job_status == '4') { $status = 'Completed'; }
            if ($data->job_status == '5') { $status = 'Canceled'; }
        }
        return $status;
    }
}

function textColor($name)
{
    if (Auth::check()) {

        $color = "";
        if ($name) {
            if ($name == 'blue') { $color = "white"; }
            if ($name == 'yellow') { $color = "black"; }
            if ($name == 'orange') { $color = "black"; }
            if ($name == 'green') { $color = "white"; }
            if ($name == 'red') { $color = "white"; }
        }

        return $color;
    }

}

function employeeName($userID)
{
    if (Auth::check()) {

        $name = 'n/a';
        $user = User::find($userID) ?? NULL;
        if ($user) {
            if ($user->first_name) {
                $name = $user->first_name.' ';
            }
            if ($user->last_name) {
                $name = $name.$user->last_name;
            }
        }
        return $name;
    }
}

function employeeEmail($userID)
{

    if (Auth::check()) {

        $email = 'n/a';
        $user = User::find($userID) ?? NULL;
        if ($user) {
            if ($user->email) {
                $email = $user->email;
            }
        }
        return $email;
    }


}

function employeePhone($userID)
{

    if (Auth::check()) {

        $phone = 'n/a';
        $user = User::find($userID) ?? NULL;
        if ($user) {
            if ($user->phone) {
                $phone = $user->phone;
            }
        }
        return $phone;
    }
}

function employeeDetails($userID)
{
    $details='';
    if (employeeName($userID)) {
        $details = $details.employeeName($userID);
    }

    if (employeeEmail($userID)) {
        $details = $details.'<br />'.employeeEmail($userID);
    }

    if (employeePhone($userID)) {
        $details = $details.'<br />'.employeePhone($userID);
    }

    return $details;
}

function employeePhoto($userID)
{

    if (Auth::check()) {

        $photo = '';
        $user = User::find($userID) ?? NULL;
        if ($user) {

            $defaultPhoto = 'https://ui-avatars.com/api/?name='.urlencode($user->first_name.' '.$user->first_name).'&color=ffffff&background=000000';
            if ($user->photo) {
                if (file_exists(public_path('/').'storage/'.$user->photo)) {
                    $photo = asset('/storage').'/'.$user->photo;
                } else {
                    $photo = $defaultPhoto;
                }
            } else {
                $photo = $defaultPhoto;
            }
        }
        return $photo;
    }
}

function customerName($userID)
{

    if (Auth::check()) {

        $customer = 'n/a';
        $user = User::find($userID) ?? NULL;
        if ($user) {
            $customer = $user->first_name.' '.$user->last_name;
        }
        return $customer;
    }
}


function customerType($userID)
{

    if (Auth::check()) {

        $type = '';
        $user = User::find($userID) ?? NULL;
        if ($user) {
            $type = Str::lower($user->customer_type);
        }
        return $type;
    }
}

function customerEmail($userID)
{
    $email = 'n/a';
    $user = User::find($userID) ? User::find($userID) : NULL;
    if ($user) {
        $email = $user->email;
    }
    return $email;
}


function customerPhone($userID)
{
    if (Auth::check()) {

        $phone = 'n/a';
        $user = User::find($userID) ?? NULL;
        if ($user) {
            $phone = $user->phone;
        }
        return $phone;
    }
}


function customerBillingAddress($id)
{

    if (Auth::check()) {

        $generated = '';
        $address = Address::find($id) ?? NULL;
        if ($address) {

            if ($address->street) {
                $generated = $address->street;
            }

            if ($address->postal_code) {
                $generated = $generated.', '.$address->postal_code;
            }

            if ($address->city) {
                $generated = $generated.', '.$address->city;
            }

            if ($address->country) {
                $generated = $generated.', '.$address->country;
            }
        }
        return $generated;
    }
}


function OptionalProductPriceOfJoblist($jobID=null)
{
    if (Auth::check()) {
        $amount = 0;
        $job = Joblist::find($jobID);
        if ($job) {
            $products = json_decode($job->optional_product);
            $amount = Optionalproduct::whereIn('id', $products)->sum('add_on_price');
        }
        return doubleval($amount);
    }
}

function calculateTotalBillAmount($hoursWorked, $hourlyRate, $jobID=null)
{
    if (Auth::check()) {

        list($hours, $minutes, $seconds) = explode(':', $hoursWorked); // Split hours, minutes, and seconds from the input
        $totalHoursWorked = $hours + ($minutes / 60) + ($seconds / 3600); // Convert hours, minutes, and seconds to decimal hours
        $totalBillAmount = $totalHoursWorked * $hourlyRate; // Calculate the total bill amount
        $totalBillAmount = round($totalBillAmount, 2); // Round to two decimal places (cents)
        $totalBillAmount = $totalBillAmount + OptionalProductPriceOfJoblist($jobID);
        return $totalBillAmount;
    }
}


function calculateTaxUsingCustomerPrice($jobID=null)
{
    if (Auth::check()) {

        $total_tax_value = 0;
        $job = Joblist::find($jobID);
        if ($job) {
            $customer_price = calculateTotalBillAmount(getTotalHour($job->id), $job->hourly_rate, $jobID);
            $customer_price = doubleval($customer_price);

            $tax = globalTax();
            $tax = doubleval($tax);

            $reminder = $tax/100;
            $total_tax_value = $reminder*$customer_price;
        }
        return doubleval($total_tax_value);
    }
}

function currencySign($id=null)
{
    $currency = '';
    if (Auth::check()) {
        $setting = $id ? Setting::where('user_id',$id)->first() : Setting::where('user_id',1)->first();
        $currency = $setting ? $setting->currency : '';
    }
    return $currency;
}

function HourlyRateWithSign()
{
    if (Auth::check()) {

        $rate = '';
        $user = Auth::user();
        if ($user) {
            $setting = Auth::user()->setting;
            $rate = $setting ? $setting->hourly_rate.currencySign().'/h' : '';
        }
        return $rate;
    }
}

function HourlyRateInt()
{

    if (Auth::check()) {

        $rate = 0;
        $user = Auth::user();
        if ($user) {
            $setting = Auth::user()->setting;
            $rate = $setting ? doubleval($setting->hourly_rate) : 0;
        }
        return $rate;
    }
}

function totalEarning($userID)
{
    if (Auth::check()) {

        $amount = 0;
        $user = User::find($userID) ?? NULL;
        if ($user) {
            $jobs = Joblist::where('employee_id',$user->id)->where('job_status','4')->get();
            foreach ($jobs as $item) {
                $amount+=calculateTotalBillAmount(getTotalHour($item->id), doubleval(HourlyRateInt()), $item->id);
            }
        }
        return $amount;
    }
}

function showWithdraw($userID)
{

    if (Auth::check()) {

        $user = User::find($userID);
        $show = true;
        if ($user && $user->setting) {
            if (empty($user->setting['currency']) || $user->setting['currency'] == NULL) { $show = false; }
            if (empty($user->setting['bank']) || $user->setting['bank'] == NULL) { $show = false; }
            if (empty($user->setting['bic']) || $user->setting['bic'] == NULL) { $show = false; }
            if (empty($user->setting['iban']) || $user->setting['iban'] == NULL) { $show = false; }
            if (empty($user->setting['ust_idnr']) || $user->setting['ust_idnr'] == NULL) { $show = false; }
        }
        return $show;
    }

}

function checkPaymentDetails($userID)
{
    $response = false;
    if (Auth::check()) {
        $user = User::find($userID);
        if ($user) {
            if ($user->setting['currency']) { $response = true; } else { $response = false; }
            if ($user->setting['bank']) { $response = true; } else { $response = false; }
            if ($user->setting['bic']) { $response = true; } else { $response = false; }
            if ($user->setting['iban']) { $response = true; } else { $response = false; }
            if ($user->setting['ust_idnr']) { $response = true; } else { $response = false; }
        }
    }
    return $response;
}

function paymentDetails($userID)
{

    if (Auth::check()) {

        $user = User::find($userID);
        $data = [];
        if ($user && $user->setting) {
            $data[] = [
                'currency' => $user->setting['currency'],
                'bank'     => $user->setting['bank'],
                'bic'      => $user->setting['bic'],
                'iban'     => $user->setting['iban'],
                'ust_idnr' => $user->setting['ust_idnr'],
            ];
        }
        return json_encode($data);
    }
}

/* chat & conversation */
function lastMessage($recipient, $sender)
{

    if (Auth::check()) {

        $last_message = 'Last Message Not Found !';
        $last = Conversation::where('recipient_id', $recipient)->where('sender_id', $sender)->latest()->first();
        if ($last) {
            $last_message = Str::limit($last->content, 200);
        }
        return $last_message;
    }
}



function payment_method($id=NULL)
{

    if (Auth::check()) {

        $logo=null;
        $row = Paymentmethod::find($id);
        $default_name = $row ? $row->name : 'P';
        $defaultLogo = 'https://ui-avatars.com/api/?name='.urlencode($default_name).'&color=ffffff&background=000000';
        if ($row && $row->logo) {
            if (file_exists(public_path('/').'storage/'.$row->logo)) {
                $logo = asset('/public/storage').'/'.$row->logo;
            } else {
                $logo = $defaultLogo;
            }
        } else {
            $logo = $defaultLogo;
        }
        return $logo;
    }
}

function chatStandardFileFormat($name,$extension)
{

    if (Auth::check()) {

        $content = '';
        if ($name && $extension) {
            if ($extension == 'jpg') {
                $content = '<a href="' . ftpImage($name) . '" target="_blank"><img class="w-100" src="' . ftpImage($name) . '" /></a>';
            } elseif($extension == 'jpeg'){
                $content = '<a href="' . ftpImage($name) . '" target="_blank"><img class="w-100" src="' . ftpImage($name) . '" /></a>';
            } elseif($extension == 'png'){
                $content = '<a href="' . ftpImage($name) . '" target="_blank"><img class="w-100" src="' . ftpImage($name) . '" /></a>';
            } elseif($extension == 'pdf'){
                $content = '<a href="' . ftpImage($name) . '" target="_blank"><i class="far fa-file-pdf fa-2x"></i></a>';
            } elseif($extension == 'mp4'){
                $content = '<video width="400" controls><source src="' . ftpImage($name) . '" type="video/mp4"><source src="' . ftpImage($name) . '" type="video/ogg"></video>';
            } elseif($extension == 'avi'){
                $content = '<video width="400" controls><source src="' . ftpImage($name) . '" type="video/mp4"><source src="' . ftpImage($name) . '" type="video/ogg"></video>';
            } elseif($extension == 'mkv'){
                $content = '<video width="400" controls><source src="' . ftpImage($name) . '" type="video/mp4"><source src="' . ftpImage($name) . '" type="video/ogg"></video>';
            } elseif($extension == 'wmv'){
                $content = '<video width="400" controls><source src="' . ftpImage($name) . '" type="video/mp4"><source src="' . ftpImage($name) . '" type="video/ogg"></video>';
            } elseif($extension == 'mpeg'){
                $content = '<video width="400" controls><source src="' . ftpImage($name) . '" type="video/mp4"><source src="' . ftpImage($name) . '" type="video/ogg"></video>';
            } elseif($extension == 'mp3'){
                $content = '<audio controls><source src="' . ftpImage($name) . '" type="audio/ogg"><source src="' . ftpImage($name) . '" type="audio/mpeg"></audio>';
            } elseif($extension == 'ogv'){
                $content = '<audio controls><source src="' . ftpImage($name) . '" type="audio/ogg"><source src="' . ftpImage($name) . '" type="audio/mpeg"></audio>';
            } elseif($extension == 'txt'){
                $content = '<a href="' . ftpImage($name) . '" target="_blank"><i class="far fa-file-pdf fa-2x"></i></a>';
            } elseif($extension == 'xls'){
                $content = '<a href="' . ftpImage($name) . '" target="_blank"><i class="far fa-file-pdf fa-2x"></i></a>';
            } elseif($extension == 'xlsx'){
                $content = '<a href="' . ftpImage($name) . '" target="_blank"><i class="far fa-file-pdf fa-2x"></i></a>';
            } elseif($extension == 'docx'){
                $content = '<a href="' . ftpImage($name) . '" target="_blank"><i class="far fa-file-pdf fa-2x"></i></a>';
            } elseif($extension == 'doc'){
                $content = '<a href="' . ftpImage($name) . '" target="_blank"><i class="far fa-file-pdf fa-2x"></i></a>';
            } elseif($extension == 'pptx'){
                $content = '<a href="' . ftpImage($name) . '" target="_blank"><i class="far fa-file-pdf fa-2x"></i></a>';
            } elseif($extension == 'ppt'){
                $content = '<a href="' . ftpImage($name) . '" target="_blank"><i class="far fa-file-pdf fa-2x"></i></a>';
            }
        }
        return $content;
    }
}


function total_balance_on_header($id=NULL)
{

    if (Auth::check()) {
        $balance = 0;
        $user = User::find($id);
        if ($user) {
            if (role_name($id) == 'Administrator') {
                //
            }
            if (role_name($id) == 'Employee') {
                $balance = Emplyeetransaction::where('user_id',$id)->sum('amount');
            }
            if (role_name($id) == 'Customer') {
                $balance = Customertransaction::where('user_id',$id)->sum('amount');
            }
        }
        return doubleval($balance);
    }
}

function last_invoice_number()
{

    if (Auth::check()) {

        $number = 0;
        $invoice = Invoice::latest()->first();
        if ($invoice) {
            $number = $invoice->invoice_number;
        }
        return intval($number);
    }
}

function invoice_prefix($id)
{

    if (Auth::check()) {

        $prefix = '';
        $data = Setting::where('user_id', $id)->first();
        if ($data) {
            $prefix = $data->invoice_prefix ? $data->invoice_prefix : '';
        }
        return $prefix;
    }
}


function unpaid_invoice()
{
    if (Auth::check()) {

        $count = 0;
        if(role_name(Auth::user()->id) == 'Administrator'){
            $count = Invoice::where('status', 'unpaid')->count();
        }
        if (role_name(Auth::user()->id) == 'Customer') {
            $count = Invoice::where('user_id', Auth::user()->id)->where('status', 'unpaid')->count();
        }
        if (role_name(Auth::user()->id) == 'Employee') {
            $count = Invoice::where('user_id', Auth::user()->id)->where('status', 'unpaid')->count();
        }
        return $count;
    }
}

function paid_invoice()
{
    if (Auth::check()) {
        $count = 0;
        if(role_name(Auth::user()->id) == 'Administrator'){
            $count = Invoice::where('status', 'paid')->count();
        }
        if (role_name(Auth::user()->id) == 'Customer') {
            $count = Invoice::where('user_id', Auth::user()->id)->where('status', 'paid')->count();
        }
        if (role_name(Auth::user()->id) == 'Employee') {
            $count = Invoice::where('user_id', Auth::user()->id)->where('status', 'paid')->count();
        }
        return $count;
    }
}

function paid_withdraw()
{
    if (Auth::check()) {
        $count = 0;
        if(role_name(Auth::user()->id) == 'Administrator'){
            $count = Withdraw::where('status', 'paid')->count();
        }
        if (role_name(Auth::user()->id) == 'Employee') {
            $count = Withdraw::where('user_id', Auth::user()->id)->where('status', 'paid')->count();
        }
        return $count;
    }
}

function unpaid_withdraw()
{
    if (Auth::check()) {
        $count = 0;
        if(role_name(Auth::user()->id) == 'Administrator'){
            $count = Withdraw::where('status', 'unpaid')->count();
        }
        if (role_name(Auth::user()->id) == 'Employee') {
            $count = Withdraw::where('user_id', Auth::user()->id)->where('status', 'unpaid')->count();
        }
        return $count;
    }
}



function checkMinimum2Hours($jobID)
{
    if (Auth::check()) {

        $time = getTotalHour($jobID);
        $newtime = Carbon::parse($time);

        $readable = '';

        if ($newtime->format('H') < 2) {
            $initialTime = Carbon::parse("00:00:00");
            $newtime = $initialTime->addHours(2);

            if ($newtime->format('H') > 0) {
                $readable = '<b>'.$newtime->format('g'). '</b> ';
            }

            if ($newtime->format('i') > 0) {
                $readable = $readable.'.<b>'.$newtime->format('i').'</b>';
            }

            return $readable;
        } else {
            return getTotalHourReadable($jobID);
        }
    }
}

function checkMinimum2HoursPrice($jobID)
{

    if (Auth::check()) {

        $time = getTotalHour($jobID);
        $newtime = Carbon::parse($time);

        if ($newtime->format('H') < 2) {
            //
        } else {
            //
        }
    }
}


/* for dashboard cards */


function totalServices($from=null,$to=null)
{
    $count = 0;
    if (!$from) {
        if ($to) {
            $from = Carbon::parse($to)->subDays(30)->startOfDay();
        } else {
            $from = Carbon::now()->subDays(30)->startOfDay();
        }
    } else {
        $from = Carbon::parse($from)->startOfDay();
    }


    if (!$to) {
        $to = Carbon::now()->endOfDay();
    } else {
        $to = Carbon::parse($to)->endOfDay();
    }

    if (Auth::check()) {

        if (role_name(Auth::user()->id) == 'Administrator') {
            $count = Service::whereBetween('created_at', [$from, $to])->count();
        }

        if (role_name(Auth::user()->id) == 'Customer') {
            $count = Service::where('user_id', Auth::user()->id)->whereBetween('created_at', [$from, $to])->count();
        }
    }

    return $count;
}

function totalJobs($from=null,$to=null)
{
    $count = 0;
    if (!$from) {
        if ($to) {
            $from = Carbon::parse($to)->subDays(30)->startOfDay();
        } else {
            $from = Carbon::now()->subDays(30)->startOfDay();
        }
    } else {
        $from = Carbon::parse($from)->startOfDay();
    }


    if (!$to) {
        $to = Carbon::now()->endOfDay();
    } else {
        $to = Carbon::parse($to)->endOfDay();
    }

    $count = Joblist::whereBetween('job_date', [$from, $to])->count();
    return $count;
}

function totalMessages($from=null,$to=null)
{
    $count = 0;
    if (!$from) {
        if ($to) {
            $from = Carbon::parse($to)->subDays(30)->startOfDay();
        } else {
            $from = Carbon::now()->subDays(30)->startOfDay();
        }
    } else {
        $from = Carbon::parse($from)->startOfDay();
    }


    if (!$to) {
        $to = Carbon::now()->endOfDay();
    } else {
        $to = Carbon::parse($to)->endOfDay();
    }

    $count = Conversation::whereBetween('created_at', [$from, $to])->count();
    return $count;
}

function totalEmployeeHours($from=null,$to=null)
{
    $sum = 0;
    if (!$from) {
        if ($to) {
            $from = Carbon::parse($to)->subDays(30)->startOfDay();
        } else {
            $from = Carbon::now()->subDays(30)->startOfDay();
        }
    } else {
        $from = Carbon::parse($from)->startOfDay();
    }

    if (!$to) {
        $to = Carbon::now()->endOfDay();
    } else {
        $to = Carbon::parse($to)->endOfDay();
    }

    $sum = \App\Models\Joblist::whereBetween('created_at', [$from, $to])->sum('employee_hours');
    return $sum;
}

function totalEmployeePayments($from=null,$to=null)
{
    $sum = 0;
    if (!$from) {
        if ($to) {
            $from = Carbon::parse($to)->subDays(30)->startOfDay();
        } else {
            $from = Carbon::now()->subDays(30)->startOfDay();
        }
    } else {
        $from = Carbon::parse($from)->startOfDay();
    }


    if (!$to) {
        $to = Carbon::now()->endOfDay();
    } else {
        $to = Carbon::parse($to)->endOfDay();
    }

    $sum = \App\Models\Joblist::whereBetween('created_at', [$from, $to])->sum('employee_price');
    return $sum;
}

function totalCustomerPrice($from=null,$to=null)
{
    $sum = 0;
    if (!$from) {
        if ($to) {
            $from = Carbon::parse($to)->subDays(30)->startOfDay();
        } else {
            $from = Carbon::now()->subDays(30)->startOfDay();
        }
    } else {
        $from = Carbon::parse($from)->startOfDay();
    }

    if (!$to) {
        $to = Carbon::now()->endOfDay();
    } else {
        $to = Carbon::parse($to)->endOfDay();
    }

    $sum = \App\Models\Joblist::whereBetween('created_at', [$from, $to])->sum('customer_price');
    return $sum;
}

function totalCustomers($from=null,$to=null)
{
    $count = 0;
    if (!$from) {
        if ($to) {
            $from = Carbon::parse($to)->subDays(30)->startOfDay();
        } else {
            $from = Carbon::now()->subDays(30)->startOfDay();
        }
    } else {
        $from = Carbon::parse($from)->startOfDay();
    }


    if (!$to) {
        $to = Carbon::now()->endOfDay();
    } else {
        $to = Carbon::parse($to)->endOfDay();
    }

    $count = User::role('Customer')->whereBetween('created_at', [$from, $to])->count();
    return $count;
}

function totalEmployees($from=null,$to=null)
{
    $count = 0;
    if (!$from) {
        if ($to) {
            $from = Carbon::parse($to)->subDays(30)->startOfDay();
        } else {
            $from = Carbon::now()->subDays(30)->startOfDay();
        }
    } else {
        $from = Carbon::parse($from)->startOfDay();
    }


    if (!$to) {
        $to = Carbon::now()->endOfDay();
    } else {
        $to = Carbon::parse($to)->endOfDay();
    }

    $count = User::role('Employee')->whereBetween('created_at', [$from, $to])->count();
    return $count;
}

function totalEarnings($from=null,$to=null)
{
    $amount = 0;
    if (!$from) {
        if ($to) {
            $from = Carbon::parse($to)->subDays(30)->startOfDay();
        } else {
            $from = Carbon::now()->subDays(30)->startOfDay();
        }
    } else {
        $from = Carbon::parse($from)->startOfDay();
    }


    if (!$to) {
        $to = Carbon::now()->endOfDay();
    } else {
        $to = Carbon::parse($to)->endOfDay();
    }

    if (Auth::check()) {
        if (role_name(Auth::user()->id) == 'Administrator') {
            $amount = Emplyeetransaction::whereBetween('created_at', [$from, $to])->sum('amount');
        }
    }

    return $amount;
}

function totalInvoices($from=null,$to=null)
{
    $count = 0;
    if (!$from) {
        if ($to) {
            $from = Carbon::parse($to)->subDays(30)->startOfDay();
        } else {
            $from = Carbon::now()->subDays(30)->startOfDay();
        }
    } else {
        $from = Carbon::parse($from)->startOfDay();
    }


    if (!$to) {
        $to = Carbon::now()->endOfDay();
    } else {
        $to = Carbon::parse($to)->endOfDay();
    }


    if (Auth::check()) {

        if (role_name(Auth::user()->id) == 'Administrator') {
            $count = Invoice::whereBetween('date', [$from, $to])->count();
        }

        if (role_name(Auth::user()->id) == 'Customer') {
            $count = Invoice::where('user_id', Auth::user()->id)->whereBetween('date', [$from, $to])->count();
        }
    }

    return $count;
}

function totalPaid($from=null,$to=null)
{
    $amount = 0;
    if (!$from) {
        if ($to) {
            $from = Carbon::parse($to)->subDays(30)->startOfDay();
        } else {
            $from = Carbon::now()->subDays(30)->startOfDay();
        }
    } else {
        $from = Carbon::parse($from)->startOfDay();
    }


    if (!$to) {
        $to = Carbon::now()->endOfDay();
    } else {
        $to = Carbon::parse($to)->endOfDay();
    }


    if (Auth::check()) {

        if (role_name(Auth::user()->id) == 'Administrator') {
            $amount = Withdraw::where('status', 'paid')->whereBetween('updated_at', [$from, $to])->sum('amount');
        }

        if (role_name(Auth::user()->id) == 'Employee') {
            $amount = Withdraw::where('user_id', Auth::user()->id)->where('status', 'paid')->whereBetween('updated_at', [$from, $to])->sum('amount');
        }
    }

    return $amount;
}


function totalDeposit($from=null,$to=null)
{
    $amount = 0;
    if (!$from) {
        if ($to) {
            $from = Carbon::parse($to)->subDays(30)->startOfDay();
        } else {
            $from = Carbon::now()->subDays(30)->startOfDay();
        }
    } else {
        $from = Carbon::parse($from)->startOfDay();
    }


    if (!$to) {
        $to = Carbon::now()->endOfDay();
    } else {
        $to = Carbon::parse($to)->endOfDay();
    }


    if (Auth::check()) {

        if (role_name(Auth::user()->id) == 'Administrator') {
            $amount = Deposithistory::where('status', 'success')->whereBetween('updated_at', [$from, $to])->sum('amount');
        }

        if (role_name(Auth::user()->id) == 'Customer') {
            $amount = Deposithistory::where('user_id', Auth::user()->id)->where('status', 'success')->whereBetween('updated_at', [$from, $to])->sum('amount');
        }
    }

    return $amount;
}

function availableBalance($from=null,$to=null)
{
    $amount = 0;
    if (!$from) {
        if ($to) {
            $from = Carbon::parse($to)->subDays(30)->startOfDay();
        } else {
            $from = Carbon::now()->subDays(30)->startOfDay();
        }
    } else {
        $from = Carbon::parse($from)->startOfDay();
    }


    if (!$to) {
        $to = Carbon::now()->endOfDay();
    } else {
        $to = Carbon::parse($to)->endOfDay();
    }


    if (Auth::check()) {
        if (role_name(Auth::user()->id) == 'Customer') {
            $amount = Customertransaction::where('user_id', Auth::user()->id)->whereBetween('updated_at', [$from, $to])->sum('amount');
        }
    }

    return $amount;
}


function attachment_path($name = null)
{
    return $name ? storage_path('app/public/pdfs/') . $name : storage_path('app/public/pdfs/');
}

/* top tup helper */


function payment_details_reader($string, $amount)
{
    $string = Str::replace('amount', 'amount: '.$amount.' '.currencySign() , $string);
    $string = Str::replace('Amount', 'amount: '.$amount.' '.currencySign() , $string);
    return $string;
}


function checkUserPermission($string)
{
    $permission = 'no';
    if (Auth::check()) {
        $user = Auth::user();
        if ($user->hasPermissionTo($string)) {
            $permission = 'yes';
        }
    }
    return $permission;
}


function mapUsingLatLongOnTask($id, $type)
{
    $query = '';
    $data = Task::find($id);
    if ($data) {

        if ($type == 'start') {
            if ($data->start_latitude) {
                $query = 'https://www.google.com/maps?q='.$data->start_latitude.',';
            }
            if ($data->start_longitude) {
                $query = $query.$data->start_longitude;
            }
        }
        if ($type == 'end') {
            if ($data->end_latitude) {
                $query = 'https://www.google.com/maps?q='.$data->end_latitude.',';
            }
            if ($data->end_longitude) {
                $query = $query.$data->end_longitude;
            }
        }
    }
    return $query;
}


function customerPrice($jobID=null, $hour=0)
{

    if (Auth::check()) {
        $job = Joblist::find($jobID);
        if ($job) {
            $customer_hours = $hour;

            if (serviceUnit($job->service_id) == 'hour') {
                $customer_price = calculatePrice(servicePrice($job->service_id), $hour);
            } else {
                $customer_price = servicePrice($job->service_id)*doubleval($hour);
            }
            return $customer_price;
        }
    }
}

function calculatePrice($hourly_rate=0, $hour=0)
{
    if (Auth::check()) {
        if ($hourly_rate > 0 && $hour > 0) {

            $hourly_rate = doubleval($hourly_rate);
            $minutely_rate = $hourly_rate/60;

            $hour = $hour;
            $hour = strpos($hour,'.') !== false ? $hour : $hour.'.00' ;
            list($hours, $minutes) = explode('.', $hour);
            $hours = doubleval($hours);
            $hours_in_minutes = $hours * 60;
            $total_minutes = doubleval($minutes) + $hours_in_minutes;

            $total_amount = ($minutely_rate * $total_minutes);

            //dd($total_amount);

            return $total_amount;
        }
    }
}

function check_job_before_15minutes_end($jobID=NULL)
{
    $job = App\Models\Joblist::find($jobID);
    $response = false;
    if ($job) {
        $hour     = $job->total_task_hour;
        $checkout = $job->checkout;
        $job_date = $job->job_date;

        if($job_date){
            $scheduledTime = Carbon::parse($job_date)->addHours($hour);
            $currentTime   = Carbon::now();
            if ($scheduledTime->diffInMinutes($currentTime) <= 15 && $scheduledTime->greaterThan($currentTime)) {
                $response = true;
            } else {
                $response = false;
            }
        }
        if ($checkout) {
            $scheduledTime = Carbon::parse($checkout);
            $currentTime   = Carbon::now();
            if ($scheduledTime->diffInMinutes($currentTime) <= 15 && $scheduledTime->greaterThan($currentTime)) {
                $response = true;
            } else {
                $response = false;
            }
        }
    }

    return $response;
}

function filter_service_links_count($id=null)
{
    $data  = \App\Models\Service::find($id);
    $links = [];
    $count = 0;

    if ($data) {
        $files = $data->files ? json_decode($data->files) : [];
        if (count($files) > 0) {
            foreach ($files as $file) {
                if (isset($file->file)) {
                    $links[] = $file->file;
                }
            }
            $count = count($links);
        }
    }

    return $count;
}


function filter_service_links($id=null)
{
    $data  = \App\Models\Service::find($id);
    $links = [];
    if ($data) {
        $files = $data->files ? json_decode($data->files) : [];
        if (count($files) > 0) {
            foreach ($files as $file) {
                if (isset($file->file)) {
                    $links[] = [
                        'file' => $file->file,
                        'caption' => $file->caption,
                    ];
                }
            }
        }
    }


    return json_encode($links);
}

function filter_service_images_count($id)
{
    $data   = \App\Models\Service::find($id);
    $images = [];
    $count  = 0;

    if ($data) {
        $files = $data->files ? json_decode($data->files) : [];
        if ($files) {
            foreach ($files as $file) {
                if (Str::contains($file->file, ['.jpg', '.jpeg', '.png'])) {
                    if (Str::endsWith($file->file, ['.jpg', '.jpeg', '.png'])) {
                        $images[] = $file->file;
                    }
                }
            }
            $count =count($images);
        }
    }
    return count($images);
}

function filter_service_images($id)
{
    $data   = \App\Models\Service::find($id);
    $images = [];
    if ($data) {
        $files = $data->files ? json_decode($data->files) : [];
        if ($files) {
            foreach ($files as $file) {
                if (Str::contains($file->file, ['.jpg', '.jpeg', '.png'])) {
                    if (Str::endsWith($file->file, ['.jpg', '.jpeg', '.png'])) {
                        $images[] = $file->file;
                    }
                }
            }
        }
    }
    return json_encode($images);
}

function filter_service_videos_count($id)
{
    $data   = \App\Models\Service::find($id);
    $videos = [];
    if ($data) {
        $files = $data->files ? json_decode($data->files) : [];
        if ($files) {
            foreach ($files as $file) {
                if (Str::contains($file->file, ['.mp4', '.avi', '.mkv', '.mov', '.wmv', '.flv', '.webm', '.mpeg', '.mpg', '.3gp', '.m4v'])) {
                    if (Str::endsWith($file->file, ['.mp4', '.avi', '.mkv', '.mov', '.wmv', '.flv', '.webm', '.mpeg', '.mpg', '.3gp', '.m4v'])) {
                        $videos[] = $file->file;
                    }
                }
            }
        }
    }
    return count($videos);
}

function filter_service_videos($id)
{
    $data   = \App\Models\Service::find($id);
    $videos = [];
    if ($data) {
        $files = $data->files ? json_decode($data->files) : [];
        if ($files) {
            foreach ($files as $file) {
                if (Str::contains($file->file, ['.mp4', '.avi', '.mkv', '.mov', '.wmv', '.flv', '.webm', '.mpeg', '.mpg', '.3gp', '.m4v'])) {
                    if (Str::endsWith($file->file, ['.mp4', '.avi', '.mkv', '.mov', '.wmv', '.flv', '.webm', '.mpeg', '.mpg', '.3gp', '.m4v'])) {
                        $videos[] = $file->file;
                    }
                }
            }
        }
    }
    return json_encode($videos);
}

function filter_service_others_count($id)
{
    $data   = \App\Models\Service::find($id);
    $others = [];
    if ($data) {
        $files = $data->files ? json_decode($data->files) : [];
        if ($files) {
            foreach ($files as $file) {
                if (Str::contains($file->file, ['.jpg', '.jpeg', '.png','.mp4', '.avi', '.mkv', '.mov', '.wmv', '.flv', '.webm', '.mpeg', '.mpg', '.3gp', '.m4v'])==false) {
                    $others[] = $file->file;
                }
            }
        }
    }
    return count($others);
}

function filter_service_others($id)
{
    $data   = \App\Models\Service::find($id);
    $others = [];
    if ($data) {
        $files = $data->files ? json_decode($data->files) : [];
        if ($files) {
            foreach ($files as $file) {
                if (Str::contains($file, ['.jpg', '.jpeg', '.png','.mp4', '.avi', '.mkv', '.mov', '.wmv', '.flv', '.webm', '.mpeg', '.mpg', '.3gp', '.m4v'])==false) {
                    $others[] = $file;
                }
            }
        }
    }
    return json_encode($others);
}


function isBirthDaySession()
{
    return session()->has('birthday_modal_shown') ? false : true;
}


function journaLists($jobIds=[], $auth_type=null, $user_id=null)
{
    $jobs = \App\Models\Joblist::whereIn('id', $jobIds)->latest()->get();
    $merged_array = [];
    foreach ($jobs as $job) {
        $journals = json_decode($job->journals, true);
        if (!is_array($journals)) {
            continue;
        }
        if ($auth_type == 'Administrator') {
            foreach ($journals as &$journal) {
                $journal['service_name'] = serviceName($job->service_id);
                $journal['job_id'] = $job->id;
            }
            $merged_array = array_merge($merged_array, $journals);
        } else {
            $user_journals = array_filter($journals, function($journal) use ($user_id) {
                return $journal['user_id'] == $user_id;
            });
            foreach ($user_journals as &$journal) {
                $journal['service_name'] = serviceName($job->service_id);
                $journal['job_id'] = $job->id;
            }
            $merged_array = array_merge($merged_array, $user_journals);
        }
    }
    return $merged_array;
}


function ftpImage($name)
{
    $path = config('app.cdn_domain').'/';
    if ($name) {
        $path = $path.$name;
    }
    return $path;
}


function uploadFTP($file=null)
{
    $name = '';
    if ($file) {
        $name = Storage::disk('ftp')->put('uploads', $file);
        $name = ftpImage($name);
    }
    return $name;
}

function invoiceText($userId=null)
{
    $row  = \App\Models\User::find($userId);
    $text = '';
    if ($row) {
        $settings = $row->setting;
        if ($settings) {
            if ($settings->invoice_text) {
                $text = $settings->invoice_text;
            }
        }
    }
    return $text;
}

function invoice_trsaction_date($id=null)
{
    $row = \App\Models\Customertransaction::find($id);
    $date = '';
    if ($row) {
        $date = $row->date->toDateString();
    }
    return $date;
}

function invoice_trsaction_amount($id=null)
{
    $row = \App\Models\Customertransaction::find($id);
    $amount = 0;
    if ($row) {
        $amount = abs($row->amount);
    }
    return $amount;
}

function invoice_trsaction_remarks($id=null)
{
    $row = \App\Models\Customertransaction::find($id);
    $type = '';
    if ($row) {
        $type = $row->type;
    }
    return $type;
}


function viewServiceAddress($id=NULL)
{
    //$pendingitem->
    $values=[
        'address'     => '',
        'street'      => '',
        'postal_code' => '',
        'city'        => '',
        'country'     => '',
    ];
    $data = \App\Models\Service::find($id);
    if ($data) {
        $values = [
            'address'     => serviceAddress($id),
            'street'      => $data->street,
            'postal_code' => $data->postal_code,
            'city'        => $data->city,
            'country'     => $data->country,
        ];
    }
    return json_encode($values);
}

function balanceRemain($invoice_id=null, $type=null)
{
    $amount_unpaid = 0;

    if ($invoice_id) {
        $invoice       = \App\Models\Invoice::find($invoice_id);
        $total_price   = $invoice ? $invoice->total_price : 0;
        $total_paid    = $invoice ? abs(\App\Models\Customertransaction::where('invoice_id', $invoice_id)->sum('amount')) : 0;
        $amount_unpaid = round($total_price - $total_paid, 10);
    }
    return $amount_unpaid;
}
