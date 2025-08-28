<div>
    <div>
        @include('backend.users-tabs')
        <div class="row mt-4">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="card shadow-sm">
                    <div class="card-header border-bottom border-200 px-0">
                        <div class="d-lg-flex justify-content-between">
                            <div class="row flex-between-center gy-2 px-x1">
                                <div class="col-auto pe-0">
                                    <h6 class="mb-0">Search</h6>
                                </div>
                                <div class="col-auto">
                                    <div class="input-group input-search-width">
                                        <input class="form-control form-control-sm shadow-none" type="search" wire:model.live="keyword" placeholder="Search  by name" aria-label="search">
                                        <button type="button" wire:click="search" class="btn btn-sm btn-outline-secondary border-300 hover-border-secondary">
                                            <span class="fa fa-search fs--1"></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto"><h3>{{ $row ? '('.fullName($row->id).')' : ''}}</h3></div>
                            <div class="d-flex align-items-center justify-content-between justify-content-lg-end px-x1">
                                <form wire:submit.prevent="addService">
                                    <div class="input-group">
                                        <select class="form-select" id="" wire:model="service_id">
                                            <option value="">Select</option>
                                            @foreach($services as $ser_item)
                                            <option value="{{$ser_item->id}}">{{$ser_item->title}}</option>
                                            @endforeach
                                        </select>
                                        <button class="btn btn-sm btn-outline-secondary border-300 hover-border-secondary">
                                            Submit
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive scrollbar">
                            <table class="table table-sm mb-0 fs--1 table-view-tickets">
                                <thead class="text-800 bg-light">
                                    <tr>
                                        <th class="py-2 fs-0 pe-2">S#</th>
                                        <th class="sort align-middle ps-2" data-sort="name">Name</th>
                                        <th class="sort align-middle ps-2" data-sort="unit">Unit</th>
                                        <th class="sort align-middle ps-2" data-sort="price">Price</th>
                                        <th class="sort align-middle ps-2" data-sort="tax">Tax</th>
                                        <th class="sort align-middle ps-2" data-sort="total_price">Total Price</th>
                                        <th class="sort align-middle ps-2" data-sort="contact_person">Contact Person</th>
                                        <th class="sort align-middle text-end" data-sort="action">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="list" id="table-ticket-body">
                                    @foreach($lists as $item)
                                    <tr class="btn-reveal-trigger">
                                        <td class="align-middle fs-0 py-1">{{ $item->id }}</td>
                                        <td class="align-middle subject py-1 pe-1">{{ $item->title }}</td>
                                        <td class="align-middle subject py-1 pe-1">{{ $item->unit }}</td>
                                        <td class="align-middle subject py-1 pe-1">
                                            <span class="badge rounded-pill badge-subtle-primary">{{ priceFormat($item->currency, $item->price) }}</span>
                                        </td>
                                        <td class="align-middle subject py-1 pe-1">
                                            <span class="badge rounded-pill badge-subtle-warning">{{ $item->tax.'%' }}</span>
                                        </td>
                                        <td class="align-middle subject py-1 pe-1">
                                            <span class="badge rounded-pill badge-subtle-success">{{ priceFormat($item->currency, $item->total_price) }}</span>
                                        </td>
                                        <td class="align-middle subject py-1 pe-1"> {{ $item->secondarycontact_id ? contactPersonName($item->secondarycontact_id) : 'N/A' }} </td>
                                        <td class="align-middle subject py-1 pe-1 text-end">
                                            <div class="dropdown font-sans-serif position-static">
                                                <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false"><span class="fas fa-ellipsis-h fs--1"></span></button>
                                                <div class="dropdown-menu dropdown-menu-end border py-0">
                                                    <div class="py-2">
                                                        
                                                        <a class="dropdown-item fs-1" href="#!" data-bs-toggle="modal" data-bs-target="#addContactPerson" wire:click="selectedRow({{$item->id}})">
                                                            <span class="fe fe-edit-3"></span> Add/Edit Contact Person
                                                        </a>

                                                        <a class="dropdown-item fs-1" href="#!" onclick="return confirm('Are you sure you want to delete?') || event.stopImmediatePropagation()" wire:click="delete({{$item->id}})">
                                                            <span class="fe fe-trash"></span> Delete
                                                        </a>
                                                        
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
                            <div class="col">{{ $lists->links() }}</div>
                            <div class="col-auto d-flex"><strong>Showing {{ $lists->firstItem() }} - {{ $lists->lastItem() }} of {{ $lists->total() }}</strong></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- modal -->

        <div class="modal fade" id="addContactPerson" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog" role="document" style="max-width: 500px">
                <div class="modal-content position-relative">
                    <div class="position-absolute top-0 end-0 mt-2 me-2 z-1">
                        <button type="button" class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0">
                        <div class="rounded-top-3 py-3 ps-4 pe-6 bg-light">
                            <h4 class="mb-1" id="modalExampleDemoLabel">Add/Edit Contact Person</h4>
                        </div>
                        <div class="p-4">
                            <label for="person"><b>Contact Person :</b></label>
                            <select wire:model="person_id" id="person" class="form-select @error('person_id') is-invalid @enderror">
                                <option value="">Select</option>
                                @foreach($contact_persons as $person_item)
                                <option value="{{$person_item->id}}">{{$person_item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-primary" type="button" wire:click="setContactPerson"> Add </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
