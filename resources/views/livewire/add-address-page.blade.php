<div>
    <div>
        @include('backend.users-tabs')

        <div class="row mt-4">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <form wire:submit.prevent="saveChanges">
                    <div class="card mb-2 shadow-sm">
                        <div class="card-header">
                            <div class="d-lg-flex justify-content-between">
                                <div class="col-auto"><b>{{$row ? 'Update ' : 'Add New '}} {{$role}}</b></div>
                                <div class="col-auto"><h3>{{ $row ? '('.fullName($row->id).')' : ''}}</h3></div>
                                <div class="col-auto">
                                    <button type="button" data-bs-toggle="modal" 
                                    data-bs-target="#addEditAddressModal" 
                                    wire:click="cleanFields" 
                                    class="btn btn-falcon-primary btn-sm"><i class="fe fe-plus-circle"></i> Add</button>

                                    <a href="/admin/users?type={{$role}}" class="btn btn-primary btn-sm">Back</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive scrollbar">
                                <table class="table table-sm mb-0 fs--1 table-view-tickets">
                                    <thead class="text-800 bg-light">
                                        <tr>
                                            <th class="py-2 fs-0 pe-2">Address</th>
                                            <th class="sort align-middle ps-2" data-sort="phone">Address For</th>
                                            <th class="sort align-middle text-end" data-sort="agent">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list" id="table-ticket-body">
                                        @foreach($lists as $item)
                                        <tr>
                                            <td class="align-middle fs-0 py-1">
                                                {{$item->street}}, {{$item->postal_code}}, {{$item->city}} , {{$item->country}}
                                            </td>
                                            <td class="align-middle subject py-1 pe-1">{{$item->address_for}}</td>
                                            <td class="align-middle subject py-1 pe-1 text-end">
                                                <div class="btn-group g-2">
                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#addEditAddressModal" wire:click="edit({{$item->id}})" class="btn btn-sm btn-falcon-primary rounded"><i class="fe fe-edit-3"></i></button>
                                                    <button type="button" class="btn btn-sm btn-falcon-danger rounded" onclick="return confirm('Are you sure you want to delete?') || event.stopImmediatePropagation()" wire:click="delete({{$item->id}})"><i class="fe fe-trash"></i></button>
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
        </div>


        <!-- add edit modal -->
        <div class="modal fade" id="addEditAddressModal" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content position-relative">
                    <div class="position-absolute top-0 end-0 mt-2 me-2 z-1">
                        <button type="button" class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0">
                        <div class="rounded-top-3 py-3 ps-4 pe-6 bg-light">
                            <h4 class="mb-1" id="modalExampleDemoLabel">{{ $info ? 'Edit' : 'Add New' }}</h4>
                        </div>
                        <div class="p-4 pb-0">
                            <div class="mb-3">
                                <label class="col-form-label" for="street">Street :</label>
                                <input class="form-control @error('street') is-invalid @enderror" id="street" wire:model="street" type="text" placeholder="street" />
                            </div>
                            <div class="mb-3">
                                <label class="col-form-label" for="postal_code">Postal Code :</label>
                                <input class="form-control @error('postal_code') is-invalid @enderror" id="postal_code" type="text" wire:model="postal_code" placeholder="postal_code" />
                            </div>
                            <div class="mb-3">
                                <label class="col-form-label" for="city">City :</label>
                                <input class="form-control @error('city') is-invalid @enderror" id="city" type="text" wire:model="city" placeholder="city" />
                            </div>
                            <div class="mb-3">
                                <label class="col-form-label" for="country">Country :</label>
                                <input class="form-control @error('country') is-invalid @enderror" id="country" type="text" wire:model="country" placeholder="country" />
                            </div>
                            <div class="mb-3">
                                <label class="col-form-label" for="phone">Address for :</label>
                                <select wire:model="address_for" id="address_for" class="form-select @error('address_for') is-invalid @enderror">
                                    <option value="">Select</option>
                                    <option value="location">Location</option>
                                    <option value="Billing Address">Billing Address</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-primary" type="button" wire:click="saveChanges"> {{ $info ? 'Save Changes' : 'Save' }} </button>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
