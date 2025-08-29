<div>

    @push('css')
    <link rel="stylesheet" href="{{ config('app.cdn_root') }}/public/loader-5.css" data-navigate-once>
    @endpush

    <div class="row mt-4">
        <div class="col-sm-12 col-md-12 col-lg-12">

            <div class="card mb-5 shadow-sm">
                <div class="card-header border-bottom border-200 px-0">
                    <div class="d-lg-flex justify-content-between">
                        <div class="row flex-between-center gy-2 px-x1">
                            <div class="col-auto pe-0">
                                <h4 class="mb-0 text-muted">Active {{$rolename}}</h4>
                            </div>
                            <div class="col-auto"></div>
                        </div>
                        <div class="border-bottom border-200 my-3"></div>
                        <div class="d-flex align-items-center justify-content-between justify-content-lg-end px-x1">

                            <div class="row flex-between-center">
                                <div class="col-auto pe-0">
                                    <h6 class="mb-0"></h6>
                                </div>
                                <div class="col-auto">

                                </div>
                            </div>
                            <div class="bg-300 mx-3 d-none d-lg-block" style="width:1px; height:29px"></div>
                            <div class="d-flex align-items-center">
                                @can('users-add')
                                <a href="/admin/add-user?type={{$rolename}}" class="btn btn-falcon-primary btn-sm me-1 mb-1" wire:navigate>
                                    <span class="fe fe-plus-circle"></span> Add New {{$rolename}}
                                </a>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm" id="activeUser">
                            <thead>
                                <tr class="btn-reveal-trigger bg-light">
                                    <th scope="col">ID</th>
                                    <th scope="col" class="text-center">Name</th>
                                    <th scope="col" class="text-center">Phone</th>
                                    <th scope="col" class="text-center">Email</th>
                                    @if($rolename == 'Employee')
                                    <th scope="col" class="text-center">Tariff</th>
                                    @endif
                                    <th scope="col" class="text-center">Type</th>
                                    <th scope="col" class="text-center">Role</th>
                                    <th scope="col" class="text-center">Status</th>
                                    <th scope="col" class="text-center">Created Date</th>
                                    <th scope="col" class="text-center">Last Modified</th>
                                    <th class="text-end" scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($active_users as $item)
                                <tr class="btn-reveal-trigger">
                                    <td>{{ $item->id }}</td>
                                    <td class="text-center">{{ fullName($item->id) }}</td>
                                    <td class="text-center">{{ $item->phone }}</td>
                                    <td class="text-center">{{ $item->email }}</td>
                                    @if($rolename == 'Employee')
                                    <td class="text-center">{{ $item->setting ? $item->setting->hourly_rate.$item->setting->currency : '' }}</td>
                                    @endif
                                    <td class="text-center"> <span class="badge rounded-pill bg-primary"> {{ $item->customer_type ? $item->customer_type : 'n/a' }}</span> </td>
                                    <td class="text-center"> <span class="badge rounded-pill bg-success">{{ role_name($item->id) }}</span> </td>
                                    <td class="text-center">{!! user_status($item->id) =='Inactive' ? '<span class="badge rounded-pill bg-danger">Inactive</span>' : '<span class="badge rounded-pill bg-success">Active</span>' !!}</td>
                                    <td class="text-center"><span class="badge rounded-pill badge-subtle-info">{{ systemFormattedDateTime($item->created_at) }}</span></td>
                                    <td class="text-center"><span class="badge rounded-pill badge-subtle-info">{{ systemFormattedDateTime($item->updated_at) }}</span></td>
                                    <td class="text-end">
                                        <div class="dropdown font-sans-serif position-static">
                                            <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal"
                                                type="button" data-bs-toggle="dropdown" data-boundary="window"
                                                aria-haspopup="true" aria-expanded="false"><span
                                                    class="fas fa-ellipsis-h fs--1"></span></button>
                                            <div class="dropdown-menu dropdown-menu-end border py-0">
                                                <div class="py-2">
                                                    @can('users-edit')
                                                    <a class="dropdown-item" href="/admin/add-user?id={{$item->id}}&&type={{Str::ucfirst($rolename)}}" wire:navigate> <span class="fe fe-edit"></span> View/Edit</a>
                                                    @endcan
                                                    @can('users-delete')
                                                        @if(role_name($item->id) != 'Administrator')
                                                        <a class="dropdown-item" href="#!" wire:click="changeStatus({{$item->id}})"> <span class="fe fe-trash-2 "></span> Delete</a>
                                                        @endif
                                                    @endcan

                                                    <a class="dropdown-item text-warning" href="/admin/impersonate/{{$item->id}}?type={{Str::ucfirst($rolename)}}" > <span class="fe fe-lock"></span> Auto Login </a>

                                                    @if(role_name($item->id) != 'Administrator')
                                                    <a class="dropdown-item" href="#!" wire:click="changeStatus({{$item->id}})">
                                                        <span class="fe fe-slash"></span> Mark as {{user_status($item->id) == 'Inactive' ? 'Active' : 'Inactive'}}
                                                    </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card mb-5 shadow-sm">
                <div class="card-header border-bottom border-200 px-0">
                    <div class="d-lg-flex justify-content-between">
                        <div class="row flex-between-center gy-2 px-x1">
                            <div class="col-auto pe-0">
                                <h4 class="mb-0 text-muted">Inactive {{$rolename}}</h4>
                            </div>
                            <div class="col-auto"></div>
                        </div>
                        <div class="border-bottom border-200 my-3"></div>
                        <div class="d-flex align-items-center justify-content-between justify-content-lg-end px-x1">
                            <div class="row flex-between-center gy-2 px-x1">
                                <div class="col-auto pe-0">
                                    <h6 class="mb-0"></h6>
                                </div>
                                <div class="col-auto">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm" id="inactiveUser">
                            <thead>
                                <tr class="btn-reveal-trigger bg-light">
                                    <th scope="col">ID</th>
                                    <th scope="col" class="text-center">Name</th>
                                    <th scope="col" class="text-center">Phone</th>
                                    <th scope="col" class="text-center">Email</th>
                                    @if($rolename == 'Employee')
                                    <th scope="col" class="text-center">Tariff</th>
                                    @endif
                                    <th scope="col" class="text-center">Type</th>
                                    <th scope="col" class="text-center">Role</th>
                                    <th scope="col" class="text-center">Status</th>
                                    <th scope="col" class="text-center">Created Date</th>
                                    <th scope="col" class="text-center">Last Modified</th>
                                    <th class="text-end" scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($inactive_users as $inactitem)
                                <tr class="btn-reveal-trigger">
                                    <td>{{ $inactitem->id }}</td>
                                    <td class="text-center">{{ $inactitem->first_name.' '.$inactitem->last_name }}</td>
                                    <td class="text-center">{{ $inactitem->phone }}</td>
                                    <td class="text-center">{{ $inactitem->email }}</td>
                                    @if($rolename == 'Employee')
                                    <td class="text-center">{{ $inactitem->setting ? $inactitem->setting->hourly_rate.$inactitem->setting->currency : '' }}</td>
                                    @endif
                                    <td class="text-center"> <span class="badge rounded-pill bg-primary"> {{ $inactitem->customer_type ? $inactitem->customer_type : 'n/a' }}</span> </td>
                                    <td class="text-center"> <span class="badge rounded-pill bg-success">{{ role_name($inactitem->id) }}</span> </td>
                                    <td class="text-center">{!! user_status($inactitem->id) =='Inactive' ? '<span class="badge rounded-pill bg-danger">Inactive</span>' : '<span class="badge rounded-pill bg-success">Active</span>' !!}</td>
                                    <td class="text-center"><span class="badge rounded-pill badge-subtle-info">{{ systemFormattedDateTime($inactitem->created_at) }}</span></td>
                                    <td class="text-center"><span class="badge rounded-pill badge-subtle-info">{{ systemFormattedDateTime($inactitem->updated_at) }}</span></td>
                                    <td class="text-end">
                                        <div class="dropdown font-sans-serif position-static">
                                            <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal"
                                                type="button" data-bs-toggle="dropdown" data-boundary="window"
                                                aria-haspopup="true" aria-expanded="false"><span
                                                    class="fas fa-ellipsis-h fs--1"></span></button>
                                            <div class="dropdown-menu dropdown-menu-end border py-0">
                                                <div class="py-2">
                                                    @can('users-edit')
                                                    <a class="dropdown-item" href="/admin/add-user?id={{$inactitem->id}}&&type={{Str::ucfirst($rolename)}}" wire:navigate> <span class="fe fe-edit"></span> View/Edit</a>
                                                    @endcan
                                                    @can('users-delete')
                                                        @if(role_name($inactitem->id) != 'Administrator')
                                                        <a class="dropdown-item" href="#!" wire:click="changeStatus({{$inactitem->id}})"> <span class="fe fe-trash-2 "></span> Delete</a>
                                                        @endif
                                                    @endcan
                                                    <a class="dropdown-item text-warning" href="#!" > <span class="fe fe-lock"></span> Auto Login</a>
                                                    @if(role_name($inactitem->id) != 'Administrator')
                                                    <a class="dropdown-item" href="#!" wire:click="changeStatus({{$inactitem->id}})">
                                                        <span class="fe fe-slash"></span> Mark as {{user_status($inactitem->id) == 'Inactive' ? 'Active' : 'Inactive'}}
                                                    </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>


    @push('js')
    <script src="{{ config('app.cdn_root') }}/public/vendors/datatables.net/jquery.dataTables.min.js"></script>
    <script src="{{ config('app.cdn_root') }}/public/vendors/datatables.net-bs5/dataTables.bootstrap5.min.js"></script>

    <script>
        new DataTable('#activeUser');
        new DataTable('#inactiveUser');
    </script>
    @endpush
</div>
