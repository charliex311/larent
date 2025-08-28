<div>

    @push('css')
    <link rel="stylesheet" href="{{ config('app.cdn_root') }}/public/loader-5.css" data-navigate-once>
    @endpush

    <!-- Active Services -->

    <div class="card mb-5 shadow-sm">
        <div class="card-header border-bottom border-200 px-0">
            <div class="d-lg-flex justify-content-between">
                <div class="row flex-between-center gy-2 px-x1">
                    <div class="col-auto pe-0"><h4 class="mb-0 text-muted">Active Services</h4></div>
                    <div class="col-auto"></div>
                </div>
                <div class="border-bottom border-200 my-3"></div>
                <div class="d-flex align-acitems-center justify-content-between justify-content-lg-end px-x1">
                    @can('service-add')
                    <a class="btn btn-falcon-primary btn-sm me-1 mb-1" href="{{ route('add-services') }}">
                        <span class="fe fe-plus-circle"></span> Add Service
                    </a>
                    @endcan
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive scrollbar">
                <table class="table table-sm mb-0 fs--1 table-view-tickets data-table" id="activeService">
                    <thead class="text-800 bg-light">
                        <tr>
                            <th class="py-2 fs-0 pe-2">ID</th>
                            <th class="sort align-middle ps-2" data-sort="title">Title</th>
                            <th class="sort align-middle ps-2" data-sort="unit">Unit</th>
                            <th class="sort align-middle ps-2" data-sort="price">Price</th>
                            <th class="sort align-middle ps-2" data-sort="tax">Tax</th>
                            <th class="sort align-middle ps-2" data-sort="tax_value">Tax Value</th>
                            <th class="sort align-middle ps-2" data-sort="total_price">Total Price</th>
                            <th class="sort align-middle ps-2" data-sort="regularity">Regular/Sunday</th>
                            <th class="sort align-middle ps-2" data-sort="speciality">Normal/Special</th>
                            <th class="sort align-middle ps-2" data-sort="address">Address</th>
                            <th class="sort align-middle text-end" data-sort="action">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="list" id="table-ticket-body">
                        @foreach($active_services as $activitem)
                        <tr class="btn-reveal-trigger">
                            <td class="align-middle fs-0 py-1">{{ $activitem->id }}</td>
                            <td class="align-middle title py-1 pe-1">
                                <div class="d-flex g-2">
                                    <span class="px-2"> {{ $activitem->title }} </span>
                                    @if(filter_service_links_count($activitem->id))
                                    <a href="javascript:void(0);" class="text-primary open-links-modal" data-files="{{ filter_service_links($activitem->id) }}"><i class="fas fa-folder"></i></a>
                                    @endif
                                </div>
                            </td>
                            <td class="align-middle unit py-1 pe-1" class="text-center">{{ $activitem->unit }}</td>
                            <td class="align-middle price py-1 pe-1" class="text-center"> <span class="badge rounded-pill badge-subtle-primary">{{ priceFormat($activitem->currency, $activitem->price) }}</span> </td>
                            <td class="align-middle tax py-1 pe-1" class="text-center"> <span class="badge rounded-pill badge-subtle-warning">{{ $activitem->tax.'%' }}</span> </td>
                            <td class="align-middle tax_value py-1 pe-1" class="text-center"> <span class="badge rounded-pill badge-subtle-info">{{ priceFormat($activitem->currency, $activitem->tax_value) }}</span> </td>
                            <td class="align-middle total_price py-1 pe-1" class="text-center"> <span class="badge rounded-pill badge-subtle-success">{{ priceFormat($activitem->currency, $activitem->total_price) }}</span> </td>
                            <td class="align-middle regularity py-1 pe-1" class="text-center text-capitalize">
                                {!! $activitem->regularity == 'regular' ? '<span class="badge rounded-pill bg-primary">'.$activitem->regularity.'</span>' : '<span class="badge rounded-pill bg-secondary">'.$activitem->regularity.'</span>' !!}
                            </td>
                            <td class="align-middle speciality py-1 pe-1" class="text-center text-capitalize">
                                {!! $activitem->speciality == 'normal' ? '<span class="badge rounded-pill bg-info">'.$activitem->speciality.'</span>' : '<span class="badge rounded-pill bg-success">'.$activitem->speciality.'</span>' !!}
                            </td>
                            <td class="align-middle address py-1 pe-1" class="text-center">
                                <button class="btn btn-falcon-primary btn-sm view-address" type="button" data-view-address="{{viewServiceAddress($activitem->id)}}">
                                    <span class="fe fe-map"></span> &nbsp;View
                                </button>
                            </td>
                            <td class="align-middle action py-1 pe-1 text-end" class="text-end">
                                <div class="dropdown font-sans-serif position-static">
                                    <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false"><span class="fas fa-ellipsis-h fs--1"></span></button>
                                    <div class="dropdown-menu dropdown-menu-end border py-0">
                                    <div class="py-2">
                                        @can('service-edit')
                                        <a class="dropdown-item fs-1" href="/admin/edit-service?id={{$activitem->id}}"> <span class="fe fe-edit"></span> Edit</a>
                                        @endcan

                                        @if($activitem->status == 0)
                                        <a class="dropdown-item fs-1 bg-success text-white" href="#!" wire:click="markActive({{$activitem->id}})">
                                            <span class="fe fe-toggle-right"></span> 
                                            Mark as Active
                                        </a>
                                        @elseif($activitem->status == 1)
                                        <a class="dropdown-item fs-1 bg-info text-white" href="#!" wire:click="markPending({{$activitem->id}})">
                                            <span class="fe fe-toggle-right"></span> 
                                            Mark as Pending
                                        </a>
                                        <a class="dropdown-item fs-1 bg-danger text-white" href="#!" wire:click="markInactive({{$activitem->id}})">
                                            <span class="fe fe-toggle-right"></span> 
                                            Mark as Inactive
                                        </a>
                                        @elseif($activitem->status == 2)
                                        <a class="dropdown-item fs-1" href="#!" wire:click="markPending({{$activitem->id}})">
                                            <span class="fe fe-toggle-right"></span> 
                                            Mark as Pending
                                        </a>
                                        <a class="dropdown-item fs-1" href="#!" wire:click="markActive({{$activitem->id}})">
                                            <span class="fe fe-toggle-right"></span> 
                                            Mark as Active
                                        </a>
                                        @endif
                                        <a class="dropdown-item fs-1 {{ $activitem->regularity == 'regular' ? 'bg-secondary text-white' : 'bg-primary text-white' }}" href="#!" wire:click="changeRegularity({{$activitem->id}})">
                                            <span class="fe fe-toggle-right"></span> 
                                            Mark as {{ $activitem->regularity == 'regular' ? 'Sunday' : 'Regular' }}
                                        </a>
                                        <a class="dropdown-item fs-1 {{ $activitem->speciality == 'normal' ? 'bg-success text-white' : 'bg-info text-white' }}" href="#!" wire:click="changeSpeciality({{$activitem->id}})">
                                            <span class="fe fe-toggle-right"></span> 
                                            Mark as {{ $activitem->speciality == 'normal' ? 'Special' : 'normal' }}
                                        </a>
                                        @can('service-delete')
                                        <a class="dropdown-item fs-1 text-danger" href="#!" onclick="return confirm('Are you sure you want to delete?') || event.stopImmediatePropagation()" wire:click="deleteItem({{$activitem->id}})"> <span class="fe fe-trash-2 fs-1"></span> Delete</a>
                                        @endcan
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

    <!-- Inactive Services -->

    <div class="card mb-5 shadow-sm">
        <div class="card-header border-bottom border-200 px-0">
            <div class="d-lg-flex justify-content-between">
                <div class="row flex-between-center gy-2 px-x1">
                    <div class="col-auto pe-0"><h4 class="mb-0 text-muted">Inactive Services</h4></div>
                    <div class="col-auto"></div>
                </div>
                <div class="border-bottom border-200 my-3"></div>
                <div class="d-flex align-acitems-center justify-content-between justify-content-lg-end px-x1">
                   
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive scrollbar">
                <table class="table table-sm mb-0 fs--1 table-view-tickets" id="inactiveService">
                    <thead class="text-800 bg-light">
                        <tr>
                            <th class="py-2 fs-0 pe-2">ID</th>
                            <th class="sort align-middle ps-2" data-sort="title">Title</th>
                            <th class="sort align-middle ps-2" data-sort="unit">Unit</th>
                            <th class="sort align-middle ps-2" data-sort="price">Price</th>
                            <th class="sort align-middle ps-2" data-sort="tax">Tax</th>
                            <th class="sort align-middle ps-2" data-sort="tax_value">Tax Value</th>
                            <th class="sort align-middle ps-2" data-sort="total_price">Total Price</th>
                            <th class="sort align-middle ps-2" data-sort="regularity">Regular/Sunday</th>
                            <th class="sort align-middle ps-2" data-sort="speciality">Normal/Special</th>
                            <th class="sort align-middle ps-2" data-sort="address">Address</th>
                            <th class="sort align-middle text-end" data-sort="action">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="list" id="table-ticket-body">
                        @foreach($inactive_services as $inactitem)
                        <tr class="btn-reveal-trigger">
                            <td class="align-middle fs-0 py-1">{{ $inactitem->id }}</td>
                            <td class="align-middle title py-1 pe-1">
                                <div class="d-flex g-2">
                                    <span class="px-2"> {{ $inactitem->title }} </span>
                                    @if(filter_service_links_count($inactitem->id))
                                    <a href="javascript:void(0);" class="text-primary open-links-modal" data-files="{{ filter_service_links($inactitem->id) }}"><i class="fas fa-folder"></i></a>
                                    @endif
                                </div>
                            </td>
                            <td class="align-middle unit py-1 pe-1" class="text-center">{{ $inactitem->unit }}</td>
                            <td class="align-middle price py-1 pe-1" class="text-center"> <span class="badge rounded-pill badge-subtle-primary">{{ priceFormat($inactitem->currency, $inactitem->price) }}</span> </td>
                            <td class="align-middle tax py-1 pe-1" class="text-center"> <span class="badge rounded-pill badge-subtle-warning">{{ $inactitem->tax.'%' }}</span> </td>
                            <td class="align-middle tax_value py-1 pe-1" class="text-center"> <span class="badge rounded-pill badge-subtle-info">{{ priceFormat($inactitem->currency, $inactitem->tax_value) }}</span> </td>
                            <td class="align-middle total_price py-1 pe-1" class="text-center"> <span class="badge rounded-pill badge-subtle-success">{{ priceFormat($inactitem->currency, $inactitem->total_price) }}</span> </td>
                            <td class="align-middle regularity py-1 pe-1" class="text-center text-capitalize">
                                {!! $inactitem->regularity == 'regular' ? '<span class="badge rounded-pill bg-primary">'.$inactitem->regularity.'</span>' : '<span class="badge rounded-pill bg-secondary">'.$inactitem->regularity.'</span>' !!}
                            </td>
                            <td class="align-middle speciality py-1 pe-1" class="text-center text-capitalize">
                                {!! $inactitem->speciality == 'normal' ? '<span class="badge rounded-pill bg-info">'.$inactitem->speciality.'</span>' : '<span class="badge rounded-pill bg-success">'.$inactitem->speciality.'</span>' !!}
                            </td>
                            <td class="align-middle address py-1 pe-1" class="text-center">
                                <button class="btn btn-falcon-primary btn-sm view-address" type="button" data-view-address="{{viewServiceAddress($inactitem->id)}}">
                                    <span class="fe fe-map"></span> &nbsp;View
                                </button>
                            </td>
                            <td class="align-middle action py-1 pe-1 text-end" class="text-end">
                                <div class="dropdown font-sans-serif position-static">
                                    <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false"><span class="fas fa-ellipsis-h fs--1"></span></button>
                                    <div class="dropdown-menu dropdown-menu-end border py-0">
                                    <div class="py-2">
                                        @can('service-edit')
                                        <a class="dropdown-item fs-1" href="/admin/edit-service?id={{$inactitem->id}}"> <span class="fe fe-edit"></span> Edit</a>
                                        @endcan

                                        @if($inactitem->status == 0)
                                        <a class="dropdown-item fs-1 bg-success text-white" href="#!" wire:click="markActive({{$inactitem->id}})">
                                            <span class="fe fe-toggle-right"></span> 
                                            Mark as Active
                                        </a>
                                        @elseif($inactitem->status == 1)
                                        <a class="dropdown-item fs-1 bg-info text-white" href="#!" wire:click="markPending({{$inactitem->id}})">
                                            <span class="fe fe-toggle-right"></span> 
                                            Mark as Pending
                                        </a>
                                        <a class="dropdown-item fs-1 bg-danger text-white" href="#!" wire:click="markInactive({{$inactitem->id}})">
                                            <span class="fe fe-toggle-right"></span> 
                                            Mark as Inactive
                                        </a>
                                        @elseif($inactitem->status == 2)
                                        <a class="dropdown-item fs-1" href="#!" wire:click="markPending({{$inactitem->id}})">
                                            <span class="fe fe-toggle-right"></span> 
                                            Mark as Pending
                                        </a>
                                        <a class="dropdown-item fs-1" href="#!" wire:click="markActive({{$inactitem->id}})">
                                            <span class="fe fe-toggle-right"></span> 
                                            Mark as Active
                                        </a>
                                        @endif
                                        <a class="dropdown-item fs-1 {{ $inactitem->regularity == 'regular' ? 'bg-secondary text-white' : 'bg-primary text-white' }}" href="#!" wire:click="changeRegularity({{$inactitem->id}})">
                                            <span class="fe fe-toggle-right"></span> 
                                            Mark as {{ $inactitem->regularity == 'regular' ? 'Sunday' : 'Regular' }}
                                        </a>
                                        <a class="dropdown-item fs-1 {{ $inactitem->speciality == 'normal' ? 'bg-success text-white' : 'bg-info text-white' }}" href="#!" wire:click="changeSpeciality({{$inactitem->id}})">
                                            <span class="fe fe-toggle-right"></span> 
                                            Mark as {{ $inactitem->speciality == 'normal' ? 'Special' : 'normal' }}
                                        </a>
                                        @can('service-delete')
                                        <a class="dropdown-item fs-1 text-danger" href="#!" onclick="return confirm('Are you sure you want to delete?') || event.stopImmediatePropagation()" wire:click="deleteItem({{$inactitem->id}})"> <span class="fe fe-trash-2 fs-1"></span> Delete</a>
                                        @endcan
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

    <!-- Pending Services -->

    <div class="card mb-5 shadow-sm">
        <div class="card-header border-bottom border-200 px-0">
            <div class="d-lg-flex justify-content-between">
                <div class="row flex-between-center gy-2 px-x1">
                    <div class="col-auto pe-0"><h4 class="mb-0 text-muted">Pending Services</h4></div>
                    <div class="col-auto"></div>
                </div>
                <div class="border-bottom border-200 my-3"></div>
                <div class="d-flex align-acitems-center justify-content-between justify-content-lg-end px-x1"></div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive scrollbar">
                <table class="table table-sm mb-0 fs--1 table-view-tickets" id="pendingService">
                    <thead class="text-800 bg-light">
                        <tr>
                            <th class="py-2 fs-0 pe-2">ID</th>
                            <th class="sort align-middle ps-2" data-sort="title">Title</th>
                            <th class="sort align-middle ps-2" data-sort="unit">Unit</th>
                            <th class="sort align-middle ps-2" data-sort="price">Price</th>
                            <th class="sort align-middle ps-2" data-sort="tax">Tax</th>
                            <th class="sort align-middle ps-2" data-sort="tax_value">Tax Value</th>
                            <th class="sort align-middle ps-2" data-sort="total_price">Total Price</th>
                            <th class="sort align-middle ps-2" data-sort="regularity">Regular/Sunday</th>
                            <th class="sort align-middle ps-2" data-sort="speciality">Normal/Special</th>
                            <th class="sort align-middle ps-2" data-sort="address">Address</th>
                            <th class="sort align-middle text-end" data-sort="action">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="list" id="table-ticket-body">
                        @foreach($pending_services as $pendingitem)
                        <tr class="btn-reveal-trigger">
                            <td class="align-middle fs-0 py-1">{{ $pendingitem->id }}</td>
                            <td class="align-middle title py-1 pe-1">
                                <div class="d-flex g-2">
                                    <span class="px-2"> {{ $pendingitem->title }} </span>
                                    @if(filter_service_links_count($pendingitem->id))
                                    <a href="javascript:void(0);" class="text-primary open-links-modal" data-files="{{ filter_service_links($pendingitem->id) }}"><i class="fas fa-folder"></i></a>
                                    @endif
                                </div>
                            </td>
                            <td class="align-middle unit py-1 pe-1" class="text-center">{{ $pendingitem->unit }}</td>
                            <td class="align-middle price py-1 pe-1" class="text-center"> <span class="badge rounded-pill badge-subtle-primary">{{ priceFormat($pendingitem->currency, $pendingitem->price) }}</span> </td>
                            <td class="align-middle tax py-1 pe-1" class="text-center"> <span class="badge rounded-pill badge-subtle-warning">{{ $pendingitem->tax.'%' }}</span> </td>
                            <td class="align-middle tax_value py-1 pe-1" class="text-center"> <span class="badge rounded-pill badge-subtle-info">{{ priceFormat($pendingitem->currency, $pendingitem->tax_value) }}</span> </td>
                            <td class="align-middle total_price py-1 pe-1" class="text-center"> <span class="badge rounded-pill badge-subtle-success">{{ priceFormat($pendingitem->currency, $pendingitem->total_price) }}</span> </td>
                            <td class="align-middle regularity py-1 pe-1" class="text-center text-capitalize">
                                {!! $pendingitem->regularity == 'regular' ? '<span class="badge rounded-pill bg-primary">'.$pendingitem->regularity.'</span>' : '<span class="badge rounded-pill bg-secondary">'.$pendingitem->regularity.'</span>' !!}
                            </td>
                            <td class="align-middle speciality py-1 pe-1" class="text-center text-capitalize">
                                {!! $pendingitem->speciality == 'normal' ? '<span class="badge rounded-pill bg-info">'.$pendingitem->speciality.'</span>' : '<span class="badge rounded-pill bg-success">'.$pendingitem->speciality.'</span>' !!}
                            </td>
                            <td class="align-middle address py-1 pe-1" class="text-center">
                                <button class="btn btn-falcon-primary btn-sm view-address" type="button" data-view-address="{{viewServiceAddress($pendingitem->id)}}">
                                    <span class="fe fe-map"></span> &nbsp;View
                                </button>
                            </td>
                            <td class="align-middle action py-1 pe-1 text-end" class="text-end">
                                <div class="dropdown font-sans-serif position-static">
                                    <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false"><span class="fas fa-ellipsis-h fs--1"></span></button>
                                    <div class="dropdown-menu dropdown-menu-end border py-0">
                                    <div class="py-2">
                                        @can('service-edit')
                                        <a class="dropdown-item fs-1" href="/admin/edit-service?id={{$pendingitem->id}}"> <span class="fe fe-edit"></span> Edit</a>
                                        @endcan

                                        @if($pendingitem->status == 0)
                                        <a class="dropdown-item fs-1 bg-success text-white" href="#!" wire:click="markActive({{$pendingitem->id}})">
                                            <span class="fe fe-toggle-right"></span> 
                                            Mark as Active
                                        </a>
                                        @elseif($pendingitem->status == 1)
                                        <a class="dropdown-item fs-1 bg-info text-white" href="#!" wire:click="markPending({{$pendingitem->id}})">
                                            <span class="fe fe-toggle-right"></span> 
                                            Mark as Pending
                                        </a>
                                        <a class="dropdown-item fs-1 bg-danger text-white" href="#!" wire:click="markInactive({{$pendingitem->id}})">
                                            <span class="fe fe-toggle-right"></span> 
                                            Mark as Inactive
                                        </a>
                                        @elseif($pendingitem->status == 2)
                                        <a class="dropdown-item fs-1" href="#!" wire:click="markPending({{$pendingitem->id}})">
                                            <span class="fe fe-toggle-right"></span> 
                                            Mark as Pending
                                        </a>
                                        <a class="dropdown-item fs-1" href="#!" wire:click="markActive({{$pendingitem->id}})">
                                            <span class="fe fe-toggle-right"></span> 
                                            Mark as Active
                                        </a>
                                        @endif
                                        <a class="dropdown-item fs-1 {{ $pendingitem->regularity == 'regular' ? 'bg-secondary text-white' : 'bg-primary text-white' }}" href="#!" wire:click="changeRegularity({{$pendingitem->id}})">
                                            <span class="fe fe-toggle-right"></span> 
                                            Mark as {{ $pendingitem->regularity == 'regular' ? 'Sunday' : 'Regular' }}
                                        </a>
                                        <a class="dropdown-item fs-1 {{ $pendingitem->speciality == 'normal' ? 'bg-success text-white' : 'bg-info text-white' }}" href="#!" wire:click="changeSpeciality({{$pendingitem->id}})">
                                            <span class="fe fe-toggle-right"></span> 
                                            Mark as {{ $pendingitem->speciality == 'normal' ? 'Special' : 'normal' }}
                                        </a>
                                        @can('service-delete')
                                        <a class="dropdown-item fs-1 text-danger" href="#!" onclick="return confirm('Are you sure you want to delete?') || event.stopImmediatePropagation()" wire:click="deleteItem({{$pendingitem->id}})"> <span class="fe fe-trash-2 fs-1"></span> Delete</a>
                                        @endcan
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

    <!-- view address -->

    <div class="modal" id="viewAddress" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px">
            <div class="modal-content position-relative">
            <div class="position-absolute top-0 end-0 mt-2 me-2 z-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="rounded-top-3 py-3 ps-4 pe-6 bg-light">
                    <h4 class="mb-1" id="modalExampleDemoLabel">View Details</h4>
                </div>
                <div class="p-0 pb-0">
                    <table class="table table-sm ">
                        <tr>
                            <td colspan="2" class="text-center border py-3 text-uppercase">
                                <a href="" target="_blank" class="fs-1" id="google_map_view">View On Google Map</a>
                            </td>
                        </tr>
                        <tr>
                            <td>Street</td>
                            <td id="street_view"></td>
                        </tr>
                        <tr>
                            <td>Postal Code</td>
                            <td id="postal_code_view"></td>
                        </tr>
                        <tr>
                            <td>City</td>
                            <td id="city_view"></td>
                        </tr>
                        <tr>
                            <td>Country</td>
                            <td id="country_view"></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>


    <!-- links preview modal -->
    <div class="modal" id="links-preview-modal" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog " role="document" style="max-width: 500px">
            <div class="modal-content position-relative">
                <div class="position-absolute top-0 end-0 mt-2 me-2 z-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base close-and-emplty" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-3">
                    <div id="linksPreview" class="pt-5"></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary close-and-emplty" type="button" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- videos preview modal -->
    <div class="modal fade" id="videos-preview-modal" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px">
            <div class="modal-content position-relative">
                <div class="position-absolute top-0 end-0 mt-2 me-2 z-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base close-and-emplty" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body mt-0">
                    <div id="videoPreview"></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary close-and-emplty" type="button" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- others preview modal -->
    <div class="modal fade" id="others-preview-modal" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px">
            <div class="modal-content position-relative">
                <div class="position-absolute top-0 end-0 mt-2 me-2 z-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base close-and-emplty" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body mt-0">
                    <h4>Others File:</h4>
                    <div id="otherPreview"></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary close-and-emplty" type="button" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    @push('js')
    <script src="{{ config('app.cdn_root') }}/public/vendors/datatables.net/jquery.dataTables.min.js"></script>
    <script src="{{ config('app.cdn_root') }}/public/vendors/datatables.net-bs5/dataTables.bootstrap5.min.js"></script>

    <script>
        document.addEventListener('livewire:init', () => {
            initializeTables(); // Initialize DataTables when Livewire loads
        });

        $(document).ready(function() {
            initializeTables(); // Initialize DataTables when the document is ready
        });

        function initializeTables() {
            // Destroy and reinitialize activeService table
            if ($.fn.DataTable.isDataTable('#activeService')) {
                $('#activeService').DataTable().destroy();
            }
            var activeServiceTable = $('#activeService').DataTable({
                order: [[1, 'asc']],
                drawCallback: function() {
                    initModals();
                }
            });

            // Destroy and reinitialize inactiveService table
            if ($.fn.DataTable.isDataTable('#inactiveService')) {
                $('#inactiveService').DataTable().destroy();
            }
            var inactiveServiceTable = $('#inactiveService').DataTable({
                order: [[1, 'asc']],
                drawCallback: function() {
                    initModals();
                }
            });

            // Destroy and reinitialize pendingService table
            if ($.fn.DataTable.isDataTable('#pendingService')) {
                $('#pendingService').DataTable().destroy();
            }
            var pendingServiceTable = $('#pendingService').DataTable({
                order: [[1, 'asc']],
                drawCallback: function() {
                    initModals();
                }
            });
        }

        // Function to initialize modals
        function initModals() {
            // links modal
            $('.open-links-modal').click(function() {
                var filelinksArray = $(this).data('files'); // Fetch the data attribute
                $('#linksPreview').html(''); // Clear the previous content

                var list = '<ul class="list-group">';

                filelinksArray.forEach(function(item) {

                    let fileName = item.file.replace('https://la-cloud.b-cdn.net/uploads/', '');

                    list += `<li class="list-group-item">
                                <a href="${item.file}" target="_blank">${fileName}</a>
                                <br><small>${item.caption}</small>
                            </li>`;
                });

                list += '</ul>';

                $('#linksPreview').html(list);

                $('#links-preview-modal').modal('show'); // Show the modal
            });

            
            // Image modal
            $('.open-image-modal').click(function() {
                var filesArray = $(this).data('files');
                $('#imagePreview').html('');
                filesArray.forEach(function(file) {
                    $('#imagePreview').append('<img src="' + file + '" alt="Image" style="max-width: 100%; margin: 10px 5px; border: 1px solid #222;"><br>');
                });
                $('#images-preview-modal').modal('show');
            });

            // Video modal
            $('.open-video-modal').click(function() {
                var filesArray2 = $(this).data('files2');
                $('#videoPreview').html('');
                filesArray2.forEach(function(file2) {
                    $('#videoPreview').append(
                        '<video width="100%" controls style="margin: 10px 0;">' +
                        '<source src="' + file2 + '" type="video/mp4">' +
                        'Your browser does not support the video tag.' +
                        '</video><br>'
                    );
                });
                $('#videos-preview-modal').modal('show');
            });

            // Other modal
            $('.open-others-modal').click(function() {
                var filesArray3 = $(this).data('files3');
                $('#otherPreview').html('');

                // Create an unordered list
                var list = '<ul class="list-group">';
                var removalStringData = '{{ config("app.cdn_domain") . "/uploads/" }}';

                filesArray3.forEach(function(file3) {
                    var url = file3;
                    var filename = url.replace(removalStringData, "");
                    list += '<li class="list-group-item">' +
                        '<a href="' + file3 + '" target="_blank" class="text-primary">' +
                        filename +
                        '</a>' +
                        '</li>';
                });

                // Close the ul tag
                list += '</ul>';

                // Append the list to the modal body (or your desired location)
                $('#otherPreview').append(list);

                $('#others-preview-modal').modal('show');
            });
        }

        // Clear modal content on close
        $('.close-and-emplty').click(function() {
            $('#linksPreview').html('');
            $('#videoPreview').html('');
            $('#otherPreview').html('');
        });

        
    </script>

    <script>
        $(document).on('click', '.view-address', function() {
            var address = $(this).data('view-address');
            var map = 'https://maps.google.com/?q=' + address.address;
            $('#google_map_view').attr('href', map);
            $('#street_view').text(address.street);
            $('#postal_code_view').text(address.postal_code);
            $('#city_view').text(address.city);
            $('#country_view').text(address.country);

            $('#viewAddress').modal('show');
        });
    </script>
    @endpush
</div>
