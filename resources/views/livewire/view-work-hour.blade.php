<div>
    <nav style="--falcon-breadcrumb-divider: '»';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/dashboard" wire:navigate>Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Viewing the Job Tasks</li>
        </ol>
    </nav>

    <div class="row mt-4 g-1">
        <div class="col-sm-12 col-md-6 col-lg-6">
            <div class="card">
                <div class="card-header"></div>
                <div class="card-body">
                    <table class="table table-sm table-bordered">
                        <tbody>
                        <tr class="bg-light py-3">
                            <td colspan="2" class="text-center"> <h5><b>Job Details</b></h5> </td>
                        </tr>
                        <tr>
                            <td>Job Title</td>
                            <td>{{$job->service ? $job->service['title'] : 'n/a'}}</td>
                        </tr>
                        <tr>
                            <td>Address </td>
                            <td>{{$job->job_address}}</td>
                        </tr>
                        @if($job->checkin)
                        <tr>
                            <td>Checkin </td>
                            <td>{{$job->checkin}}</td>
                        </tr>
                        <tr>
                            <td>Checkout</td>
                            <td>{{$job->checkout}}</td>
                        </tr>
                        @else
                        <tr>
                            <td>Job Date</td>
                            <td>{{$job->job_date}}</td>
                        </tr>
                        @endif
                        <tr>
                            <td>Need to Work(Hours)</td>
                            <td>{{parseTimeForHumans($job->total_task_hour.':00:00')}}</td>
                        </tr>
                        <tr>
                            <td>Recurrence Type</td>
                            <td>{{$job->recurrence_type}}</td>
                        </tr>
                        <tr>
                            <td>Number of People</td>
                            <td>{{$job->number_of_people ? $job->number_of_people : '-'}}</td>
                        </tr>
                        <tr>
                            <td>Code From The Door</td>
                            <td>{{$job->code_from_the_door ? $job->code_from_the_door : '-'}}</td>
                        </tr>
                        <tr>
                            <td>Job Notes</td>
                            <td>{{$job->job_notes ? $job->job_notes : '-'}}</td>
                        </tr>
                        <tr>
                            <td>Job Status</td>
                            <td><span class="badge rounded-pill {{'bg-status-'.statusColor($job->id)}} {{'text-'.textColor(statusColor($job->id))}}">{{status($job->id)}}</span></td>
                        </tr>
                        <tr>
                            <td>Message:</td>
                            <td>{{$job->employee_message}}</td>
                        </tr>
                        @if(role_name(Auth::user()->id) != 'Employee')
                        <tr class="bg-light">
                            <td colspan="2" class="text-center"> <h5><b>Employeer</b></h5> </td>
                        </tr>
                        <tr>
                            <td>Employee Name</td>
                            <td>{{employeeName($job->employee_id)}}</td>
                        </tr>
                        <tr>
                            <td>Employee Email</td>
                            <td>{{employeeEmail($job->employee_id)}}</td>
                        </tr>
                        <tr>
                            <td>Employee Phone</td>
                            <td>{{employeePhone($job->employee_id)}}</td>
                        </tr>
                        @endif
                        <tr class="bg-light">
                            <td colspan="2" class="text-center"> <h5><b>Customer</b></h5> </td>
                        </tr>
                        <tr>
                            <td>Customer Name</td>
                            <td>{{customerName($job->user_id)}}</td>
                        </tr>
                        @if(role_name(Auth::user()->id) != 'Employee')
                        <tr>
                            <td>Customer Email</td>
                            <td>{{customerEmail($job->user_id)}}</td>
                        </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-6">
            <div class="card">
                <div class="card-header"><h4 class="text-muted">All Tasks</h4></div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr class="btn-reveal-trigger bg-light">
                                    <th scope="col">ID</th>
                                    <th scope="col" class="text-center">Start Time</th>
                                    <th scope="col" class="text-center">End Time</th>
                                    <th scope="col" class="text-end">Total Worked</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $counter=0; @endphp
                                @foreach($tasks as $task)
                                <tr>
                                    <td>{{$counter+=1}}</td>
                                    <td class="text-center">{{parseTimeForHumans($task->start_time)}}</td>
                                    <td class="text-center">{{$task->end_time ? parseTimeForHumans($task->end_time) : 'working...'}}</td>
                                    <td class="text-end">{{getHour($task->start_time, $task->end_time)}}</td>
                                </tr>
                                @endforeach
                                <tr class="btn-reveal-trigger bg-light">
                                    <td colspan="3" class="text-end">Total Worked</td>
                                    <td class="text-end">{{$job ? getTotalHour($job->id) : 'n/a'}}</td>
                                </tr>
                                <tr class="btn-reveal-trigger bg-success text-white">
                                    <td colspan="3" class="text-end">Total Income</td>
                                    <td class="text-end">{{calculateTotalBillAmount(getTotalHour($job->id), $job->hourly_rate, $job->id).''.$job->currency}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
