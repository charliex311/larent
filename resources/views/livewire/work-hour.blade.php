<div>


    @push('css')
    <link rel="stylesheet" href="{{ config('app.cdn_root') }}/public/loader-5.css" data-navigate-once>
    @endpush

    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <div class="card mt-1 shadow-sm">
                
                <div class="card-header border-bottom border-200 px-0">
                    <div class="d-lg-flex justify-content-between">
                        <div class="row flex-between-center gy-2 px-x1">
                            <div class="col-auto pe-0">
                                <h6 class="mb-0">Completed Jobs</h6>
                            </div>
                            <div class="col-auto"></div>
                        </div>
                        <div class="border-bottom border-200 my-3"></div>
                        <div class="d-flex align-items-center justify-content-between justify-content-lg-end px-x1">
                        @if(role_name(Auth::user()->id) == 'Administrator')
                            <form wire:submit.prevent="search" class="d-flex align-items-center">

                                <!-- filter by start date -->
                                <div class="row gx-2">
                                    <div class="col-auto"><small>Filter by: </small></div>
                                    <div class="col-auto">
                                        <input type="date" wire:model="from" value="" class="form-control" id="start-date">
                                    </div>
                                </div>

                                <!-- filter by end date -->
                                <div class="row gx-2">
                                    <div class="col-auto"></div>
                                    <div class="col-auto">
                                        <input type="date" wire:model="to" value="" class="form-control" id="end-date">
                                    </div>
                                </div>

                                <!-- filter by customer-->
                                <div class="row gx-2">
                                    <div class="col-auto"></div>
                                    <div class="col-auto">
                                        <select id="customer_filter" wire:model="customer" class="form-select">
                                            <option value="">Customer</option>
                                            @foreach($customers as $cusitem)
                                            <option value="{{$cusitem->id}}">{{fullName($cusitem->id)}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- filter by service-->
                                <div class="row gx-2">
                                    <div class="col-auto"></div>
                                    <div class="col-auto">
                                        <select id="service_filter" wire:model="service" class="form-select">
                                            <option value="">Service</option>
                                            @foreach($services as $seritem)
                                            <option value="{{$seritem->id}}">{{$seritem->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- filter by Employee-->
                                <div class="row gx-2">
                                    <div class="col-auto"></div>
                                    <div class="col-auto">
                                        <select id="employee_filter" wire:model="employee" class="form-select">
                                            <option value="">Employee</option>
                                            @foreach($employees as $emitem)
                                            <option value="{{$emitem->id}}">{{fullName($emitem->id)}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <button class="btn btn-falcon-primary mx-1" type="submit"><i class="fe fe-search fs--1"></i></button>

                            </form>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="table-responsive scrollbar" wire:ignore>
                        <table class="table table-sm mb-0 fs--1 table-view-tickets" id="jobLists" >
                            <thead class="text-800 bg-light" >
                                <tr>
                                    <th class="py-2 fs-0 pe-2">ID</th>
                                    @can('work-column-customer-name')<th class="py-2 fs-0 pe-2">Customer</th>@endcan
                                    @can('work-column-service-name')<th class="sort align-middle ps-2" data-sort="service_name">Service</th>@endcan
                                    @can('work-column-employee-name')<th class="sort align-middle ps-2" data-sort="employee">Employee</th>@endcan
                                    @can('work-column-message')<th class="sort align-middle ps-2" data-sort="message">Message</th>@endcan
                                    @can('work-column-files')<th class="sort align-middle ps-2" data-sort="files">Files</th>@endcan
                                    @can('work-column-date')<th class="sort align-middle ps-2" data-sort="date">Date</th>@endcan
                                    @can('work-column-start-time')<th class="sort align-middle ps-2" data-sort="start_time">Start Time</th>@endcan
                                    @can('work-column-stop-time')<th class="sort align-middle ps-2" data-sort="stop_time">Stop Time</th>@endcan
                                    @can('work-column-service-price')<th class="sort align-middle ps-2" data-sort="service_price">Service Price</th>@endcan
                                    @can('work-column-employee-hours')<th class="sort align-middle ps-2" data-sort="employee_hours">Employee Hours</th>@endcan
                                    @can('work-column-employee-price')<th class="sort align-middle ps-2" data-sort="employee_price">Employee Price</th>@endcan
                                    @can('work-column-customer-hours')<th class="sort align-middle ps-2" data-sort="customer_hours">Customer Hours</th>@endcan
                                    @can('work-column-customer-price')<th class="sort align-middle ps-2" data-sort="customer_price">Customer Price</th>@endcan
                                    @can('work-column-total-price')<th class="sort align-middle ps-2" data-sort="total_price">Total Price</th>@endcan
                                    @can('work-column-status')<th class="sort align-middle ps-2 text-end" data-sort="status">Status</th>@endcan
                                </tr>
                            </thead>
                            <tbody class="list" id="table-ticket-body">
                                @php
                                    $total_employee_hours = 0;
                                    $total_employee_price = 0;
                                    $total_customer_hours = 0;
                                    $total_customer_price = 0;
                                    $totalPrice           = 0;
                                @endphp

                                @foreach($lists as $keys => $item)

                                @php
                                    $total_employee_hours += doubleval($editrows[$keys]['employee_hours']);
                                    $total_employee_price += doubleval($editrows[$keys]['employee_price']);
                                    $total_customer_hours += doubleval($editrows[$keys]['customer_hours']);
                                    $total_customer_price += doubleval($editrows[$keys]['customer_price']);
                                    $totalPrice           += doubleval($editrows[$keys]['total_price']);

                                @endphp
                                <tr wire:key="{{ $item->id }}">
                                    <td class="align-middle fs-0 py-1">{{$item->id}}</td>
                                    @can('work-column-customer-name')
                                    <td class="align-middle fs-0 py-1">{{customerName($item->user_id)}}</td>
                                    @endcan
                                    @can('work-column-service-name')
                                    <td class="align-middle service_name py-1 pe-1">
                                        {{$item->service_id ? $item->service['title'] : ''}}
                                        @if(role_name(Auth::user()->id) == 'Administrator')
                                        {!! '<br /> <a href="https://maps.google.com/?q='.serviceAddress($item->service_id).'" target="_blank" class="badge rounded-pill bg-info">'.serviceAddress($item->service_id).'</a>'!!}
                                        @endif
                                    </td>
                                    @endcan
                                    @can('work-column-employee-name')
                                    <td class="align-middle employee py-1 pe-1">{{ employeeName($item->employee_id) }}</td>
                                    @endcan
                                    @can('work-column-message')
                                    <td class="align-middle message py-1 pe-1">
                                        <textarea class="form-control fs--1" cols="10" rows="2" 
                                        style="width:200px;" wire:model="editrows.{{$keys}}.employee_message" 
                                        @if(Auth::user()->hasPermissionTo('work-edit-message')) wire:change="updateChangedMessage({{$keys}},{{$item->id}})" @else readonly @endif></textarea>
                                    </td>
                                    @endcan
                                    @can('work-column-files')
                                    <td class="align-middle files py-1 pe-1">
                                        @foreach($item->taskfiles()->pluck('filename') as $eachfile)
                                        @php $extention = pathinfo($eachfile, PATHINFO_EXTENSION); @endphp
                                        <a target="_blank" href="{{$eachfile}}" class="text-upercase">
                                            <small>{!! $extention ? $extention : '<span class="fe fe-alert-circle"></span>' !!}</small>
                                        </a><br>
                                        @endforeach
                                    </td>
                                    @endcan
                                    @can('work-column-date')
                                    <td class="align-middle date py-1 pe-1">
                                        @if($item->job_date)
                                        <span class="badge bg-primary text-center fs-0">{{$item->job_date->format('d-m-Y')}}</span>
                                        @else
                                            @if($item->checkin)
                                            <span class="badge bg-primary text-center fs-0">{{$item->checkin->format('d-m-Y')}}</span>
                                            @endif
                                        @endif
                                    </td>
                                    @endcan
                                    @can('work-column-start-time')
                                    <td class="align-middle start_time py-1 pe-1">
                                        <div class="d-flex justify-between">
                                            @if($item->tasks()->first() && $item->tasks()->first()->start_time)
                                            <input type="time" wire:model="editrows.{{$keys}}.start_time" 
                                            @if(Auth::user()->hasPermissionTo('work-edit-start-time')) wire:change.debounce.1300ms="startEndTimeTrigger({{$keys}},{{$item->id}}) @else readonly @endif" id="" class="form-control">
                                            <a href="{{mapUsingLatLongOnTask($item->tasks()->first()->id,'start')}}" 
                                            target="_blank" class="nav-link px-1"><i class="fe fe-map-pin text-success fs-3"></i></a>
                                            @else
                                            <span class="border border-1 border-dark border-dotted p-1">n/a</span>
                                            @endif
                                        </div>
                                    </td>
                                    @endcan
                                    @can('work-column-stop-time')
                                    <td class="align-middle stop_time py-1 pe-1">
                                        <div class="d-flex justify-between">
                                            @if($item->tasks()->first() && $item->tasks()->first()->end_time)
                                            <input type="time" wire:model="editrows.{{$keys}}.end_time" 
                                            @if(Auth::user()->hasPermissionTo('work-edit-stop-time')) wire:change.debounce.1300ms="startEndTimeTrigger({{$keys}},{{$item->id}}) @else readonly @endif" id="" class="form-control">
                                            <a href="{{mapUsingLatLongOnTask($item->tasks()->first()->id,'end')}}" 
                                            target="_blank" class="nav-link px-1"><i class="fe fe-map-pin text-success fs-3"></i></a>
                                            @else
                                            <span class="border border-1 border-dark border-dotted p-1">n/a</span>
                                            @endif
                                        </div>
                                    </td>
                                    @endcan
                                    @can('work-column-service-price')
                                    <td class="align-middle service_price py-1 pe-1">
                                        <div class="search-box" style="width: 120px">
                                            <div class="position-relative">
                                                <input class="form-control" type="text" value="{{$item->service_price}}" readonly />
                                                <span class="search-box-icon text-dark" style="right: 0.9rem !important;left: inherit;">
                                                    <span class="fas fa-euro-sign"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    @endcan
                                    @can('work-column-employee-hours')
                                    <td class="align-middle employee_hours py-1 pe-1">
                                        <div class="search-box" style="width: 100px">
                                            <div class="position-relative">
                                                <input type="number" step="any" min="0" wire:model="editrows.{{$keys}}.employee_hours" 
                                                @if(Auth::user()->hasPermissionTo('work-edit-employee-hours')) wire:change.debounce.1300ms="employeeHoursTrigger({{$keys}},{{$item->id}}) @else readonly @endif" class="form-control noscroll" />
                                                <span class="search-box-icon text-dark" style="right: 0.9rem !important;left: inherit;"><strong>h</strong></span>
                                            </div>
                                        </div>
                                    </td>
                                    @endcan
                                    @can('work-column-employee-price')
                                    <td class="align-middle employee_price py-1 pe-1">
                                        <div class="search-box" style="width: 100px">
                                            <div class="position-relative">
                                                <input class="form-control" type="text" wire:model="editrows.{{$keys}}.employee_price" readonly />
                                                <span class="search-box-icon text-dark" style="right: 0.9rem !important;left: inherit;">
                                                    <span class="fas fa-euro-sign"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    @endcan
                                    @can('work-column-customer-hours')
                                    <td class="align-middle customer_hours py-1 pe-4 ">
                                        <div class="search-box" style="width: 100px">
                                            <div class="position-relative">
                                                <input type="number" step="any" min="0" wire:model="editrows.{{$keys}}.customer_hours" 
                                                @if(Auth::user()->hasPermissionTo('work-edit-customer-hours')) wire:change.debounce.1300ms="customerHoursTrigger({{$keys}},{{$item->id}}) @else readonly @endif" class="form-control noscroll" />
                                                <span class="search-box-icon text-dark" style="right: 0.9rem !important;left: inherit;"><strong>h</strong></span>
                                            </div>
                                        </div>
                                    </td>
                                    @endcan
                                    @can('work-column-customer-price')
                                    <td class="align-middle customer_price py-1 pe-4 ">
                                        <div class="search-box" style="width: 120px">
                                            <div class="position-relative">
                                                <input class="form-control" type="text" wire:model="editrows.{{$keys}}.customer_price" readonly />
                                                <span class="search-box-icon text-dark" style="right: 0.9rem !important;left: inherit;">
                                                    <span class="fas fa-euro-sign"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    @endcan
                                    @can('work-column-total-price')
                                    <td class="align-middle total_price py-1 pe-4 ">
                                        <div class="search-box" style="width: 120px">
                                            <div class="position-relative">
                                                <input class="form-control" type="text" wire:model="editrows.{{$keys}}.total_price" readonly />
                                                <span class="search-box-icon text-dark" style="right: 0.9rem !important;left: inherit;">
                                                    <span class="fas fa-euro-sign"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    @endcan
                                    @can('work-column-status')
                                    <td class="align-middle status py-1 pe-4 text-end">
                                        <span class="badge rounded-pill {{'bg-status-'.statusColor($item->id)}} {{'text-'.textColor(statusColor($item->id))}}">{{status($item->id)}}</span>
                                    </td>
                                    @endcan
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="py-2 fs-0 pe-2"></th>
                                    @can('work-column-customer-name')<th class="py-2 fs-0 pe-2"></th>@endcan
                                    @can('work-column-service-name')<th class="py-2 fs-0 pe-2"></th>@endcan
                                    @can('work-column-employee-name')<th class="py-2 fs-0 pe-2"></th>@endcan
                                    @can('work-column-message')<th class="py-2 fs-0 pe-2"></th>@endcan
                                    @can('work-column-files')<th class="py-2 fs-0 pe-2"></th>@endcan
                                    @can('work-column-date')<th class="py-2 fs-0 pe-2"></th>@endcan
                                    @can('work-column-start-time')<th class="py-2 fs-0 pe-2"></th>@endcan
                                    @can('work-column-stop-time')<th class="py-2 fs-0 pe-2"></th>@endcan
                                    @can('work-column-service-price')<th class="py-2 fs-0 pe-2"></th>@endcan
                                    @can('work-column-employee-hours')<th class="py-2 fs-0 pe-2 text-danger"><b>{{ '= '.number_format($total_employee_hours, 2).' h' }}</b></th>@endcan
                                    @can('work-column-employee-price')<th class="py-2 fs-0 pe-2 text-danger"><b>{{ '= '.number_format($total_employee_price, 2).' €' }}</b></th>@endcan
                                    @can('work-column-customer-hours')<th class="py-2 fs-0 pe-2 text-danger"><b>{{ '= '.number_format($total_customer_hours, 2).' h' }}</b></th>@endcan
                                    @can('work-column-customer-price')<th class="py-2 fs-0 pe-2 text-danger"><b>{{ '= '.number_format($total_customer_price, 2).' €' }}</b></th>@endcan
                                    @can('work-column-total-price')<th class="py-2 fs-0 pe-2 text-danger"><b>{{ '= '.number_format($totalPrice, 2).' €' }}</b></th>@endcan
                                    @can('work-column-status')<th class="py-2 fs-0 pe-2"></th>@endcan
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>


            </div>
        </div>
    </div>



    @push('js')
    <script src="{{ config('app.cdn_root') }}/public/vendors/datatables.net/jquery.dataTables.min.js" defer></script>
    <script src="{{ config('app.cdn_root') }}/public/vendors/datatables.net-bs5/dataTables.bootstrap5.min.js" defer></script>
    <script data-navigate-track >
        document.addEventListener('livewire:init', () => {
            new DataTable('#jobLists', {
                order: [[0, 'desc']]
            });
        });
    </script>

    <script>
        document.addEventListener("wheel", function(event) {
            if (document.activeElement.type === "number" &&
                document.activeElement.classList.contains("noscroll")) {
                document.activeElement.blur();
            }
        });
    </script>
    @endpush
</div>