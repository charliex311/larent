<div>
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg">
            <div class="card mt-1">
                <div class="card-header border-bottom border-200 px-0">
                    <div class="d-lg-flex justify-content-between">
                        <div class="row flex-between-center gy-2 px-x1">
                            <div class="col-auto"><h4>Inactive Services</h4></div>
                            <div class="col-auto"></div>
                        </div>
                        <div class="border-bottom border-200 my-3"></div>
                        <div class="d-flex align-items-center justify-content-between justify-content-lg-end px-x1">
                            

                            <div class="row gx-2">
                                <div class="col-auto"></div>
                                <div class="col-auto">
                                    <select class="form-select form-select-sm" aria-label="Bulk actions" wire:model.live="perpage">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                        <option value="500">500</option>
                                        <option value="1000">1000</option>
                                    </select>
                                </div>
                            </div>

                            <div class="bg-300 mx-3 d-none d-lg-block" style="width:1px; height:29px"></div>

                            <div class="d-flex align-items-center">
                                <!-- filter by unit -->
                                <div class="row gx-2">
                                    <div class="col-auto"><small>Sort by: </small></div>
                                    <div class="col-auto">
                                        <select class="form-select form-select-sm" aria-label="Bulk actions" wire:model.live="unit">
                                            <option value="">Unit</option>
                                            @foreach(allServiceUnits() as $unititem)
                                            <option value="{{$unititem}}">{{$unititem}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- filter by regularity -->
                                <div class="row gx-2">
                                    <div class="col-auto"></div>
                                    <div class="col-auto">
                                        <select class="form-select form-select-sm" aria-label="Bulk actions" wire:model.live="regularity">
                                            <option value="">Regularity</option>
                                            <option value="regular">Regular</option>
                                            <option value="sunday">Sunday</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- filter by Speciality-->
                                <div class="row gx-2">
                                    <div class="col-auto"></div>
                                    <div class="col-auto">
                                        <select class="form-select form-select-sm" aria-label="Bulk actions" wire:model.live="speciality">
                                            <option value="">Speciality</option>
                                            <option value="normal">Normal</option>
                                            <option value="special">Special</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive scrollbar">
                        <table class="table table-sm mb-0 fs--1 table-view-tickets">
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
                                    <th class="sort align-middle ps-2" data-sort="status">Status</th>
                                    <th class="sort align-middle ps-2" data-sort="created_at">Created Date</th>
                                    <th class="sort align-middle ps-2" data-sort="last_modified">Last Modified</th>
                                    <th class="sort align-middle text-end" data-sort="action">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="list" id="table-ticket-body">
                                @if(count($lists) == 0)
                                <tr>
                                    <td colspan="13" class="text-center"><i>Not Found</i> <i class="fe fe-alert-triangle text-warning"></i></td>
                                </tr>
                                @endif
                                @foreach($lists as $item)
                                <tr class="btn-reveal-trigger">
                                    <td class="align-middle fs-0 py-1">{{ $item->id }}</td>
                                    <td class="align-middle title py-1 pe-1">{{ $item->title }}</td>
                                    <td class="align-middle unit py-1 pe-1" class="text-center">{{ $item->unit }}</td>
                                    <td class="align-middle price py-1 pe-1" class="text-center"> <span class="badge rounded-pill badge-subtle-primary">{{ priceFormat($item->currency, $item->price) }}</span> </td>
                                    <td class="align-middle tax py-1 pe-1" class="text-center"> <span class="badge rounded-pill badge-subtle-warning">{{ $item->tax.'%' }}</span> </td>
                                    <td class="align-middle tax_value py-1 pe-1" class="text-center"> <span class="badge rounded-pill badge-subtle-info">{{ priceFormat($item->currency, $item->tax_value) }}</span> </td>
                                    <td class="align-middle total_price py-1 pe-1" class="text-center"> <span class="badge rounded-pill badge-subtle-success">{{ priceFormat($item->currency, $item->total_price) }}</span> </td>
                                    <td class="align-middle regularity py-1 pe-1" class="text-center text-capitalize">
                                        {!! $item->regularity == 'regular' ? '<span class="badge rounded-pill bg-primary">'.$item->regularity.'</span>' : '<span class="badge rounded-pill bg-secondary">'.$item->regularity.'</span>' !!}
                                    </td>
                                    <td class="align-middle speciality py-1 pe-1" class="text-center text-capitalize">
                                        {!! $item->speciality == 'normal' ? '<span class="badge rounded-pill bg-info">'.$item->speciality.'</span>' : '<span class="badge rounded-pill bg-success">'.$item->speciality.'</span>' !!}
                                    </td>
                                    <td class="align-middle address py-1 pe-1" class="text-center">
                                        <button class="btn btn-falcon-primary btn-sm" data-bs-toggle="modal" data-bs-target="#viewAddress" type="button" wire:click.prefetch="viewAddress({{$item->id}})">
                                            <span class="fe fe-map"></span> &nbsp;View
                                        </button>
                                    </td>
                                    <td class="align-middle status py-1 pe-1" class="text-center">
                                        @if($item->status == 0)
                                        <span class="badge rounded-pill bg-warning">{{ 'Pending' }}</span>
                                        @elseif($item->status == 1)
                                        <span class="badge rounded-pill bg-success">{{ 'Active' }}</span>
                                        @elseif($item->status == 2)
                                        <span class="badge rounded-pill bg-primary">{{ 'Inactive' }}</span>
                                        @endif
                                    </td>
                                    <td class="align-middle created_at py-1 pe-1" class="text-center"><span class="badge rounded-pill badge-subtle-primary">{{ systemFormattedDateTime($item->created_at) }}</span> </td>
                                    <td class="align-middle last_modified py-1 pe-1" class="text-center"><span class="badge rounded-pill badge-subtle-primary">{{ systemFormattedDateTime($item->updated_at) }}</span> </td>
                                    <td class="align-middle action py-1 pe-1 text-end" class="text-end">
                                        <div class="dropdown font-sans-serif position-static">
                                            <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false"><span class="fas fa-ellipsis-h fs--1"></span></button>
                                            <div class="dropdown-menu dropdown-menu-end border py-0">
                                            <div class="py-2">
                                                @can('service-edit')
                                                <a class="dropdown-item fs-1" href="/admin/edit-service?id={{$item->id}}"> <span class="fe fe-edit"></span> Edit</a>
                                                @endcan
    
                                                @if($item->status == 0)
                                                <a class="dropdown-item fs-1 bg-success text-white" href="#!" wire:click="markActive({{$item->id}})">
                                                    <span class="fe fe-toggle-right"></span> 
                                                    Mark as Active
                                                </a>
                                                @elseif($item->status == 1)
                                                <a class="dropdown-item fs-1 bg-info text-white" href="#!" wire:click="markPending({{$item->id}})">
                                                    <span class="fe fe-toggle-right"></span> 
                                                    Mark as Pending
                                                </a>
                                                <a class="dropdown-item fs-1 bg-danger text-white" href="#!" wire:click="markInactive({{$item->id}})">
                                                    <span class="fe fe-toggle-right"></span> 
                                                    Mark as Inactive
                                                </a>
                                                @elseif($item->status == 2)
                                                <a class="dropdown-item fs-1" href="#!" wire:click="markPending({{$item->id}})">
                                                    <span class="fe fe-toggle-right"></span> 
                                                    Mark as Pending
                                                </a>
                                                <a class="dropdown-item fs-1" href="#!" wire:click="markActive({{$item->id}})">
                                                    <span class="fe fe-toggle-right"></span> 
                                                    Mark as Active
                                                </a>
                                                @endif
                                                <a class="dropdown-item fs-1 {{ $item->regularity == 'regular' ? 'bg-secondary text-white' : 'bg-primary text-white' }}" href="#!" wire:click="changeRegularity({{$item->id}})">
                                                    <span class="fe fe-toggle-right"></span> 
                                                    Mark as {{ $item->regularity == 'regular' ? 'Sunday' : 'Regular' }}
                                                </a>
                                                <a class="dropdown-item fs-1 {{ $item->speciality == 'normal' ? 'bg-success text-white' : 'bg-info text-white' }}" href="#!" wire:click="changeSpeciality({{$item->id}})">
                                                    <span class="fe fe-toggle-right"></span> 
                                                    Mark as {{ $item->speciality == 'normal' ? 'Special' : 'normal' }}
                                                </a>
                                                @can('service-delete')
                                                <a class="dropdown-item fs-1 text-danger" href="#!" onclick="return confirm('Are you sure you want to delete?') || event.stopImmediatePropagation()" wire:click="deleteItem({{$item->id}})"> <span class="fe fe-trash-2 fs-1"></span> Delete</a>
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
                <div class="card-footer">
                    <div class="row align-items-center">
                        <div class="col"><strong>Showing {{ $lists->firstItem() }} - {{ $lists->lastItem() }} of {{ $lists->total() }}</strong></div>
                        <div class="col-auto d-flex">{{ $lists->links() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- view address -->

    <div class="modal fade" id="viewAddress" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
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
                        @if($row)
                        <tr>
                            <td colspan="2">
                                <a href="https://maps.google.com/?q={{ serviceAddress($row->id) }}" target="_blank" class="fs-1">View On Google Map</a>
                            </td>
                        </tr>
                        <tr>
                            <td>Street</td>
                            <td>{{ $row->street ?? 'n/a' }}</td>
                        </tr>
                        <tr>
                            <td>Postal Code</td>
                            <td>{{ $row->postal_code ?? 'n/a' }}</td>
                        </tr>
                        <tr>
                            <td>City</td>
                            <td>{{ $row->city ?? 'n/a' }}</td>
                        </tr>
                        <tr>
                            <td>Country</td>
                            <td>{{ $row->country ?? 'n/a' }}</td>
                        </tr>
                        @else
                        <tr>
                            <td colspan="2" class="text-center"><i>Not Available</i></td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>

</div>
