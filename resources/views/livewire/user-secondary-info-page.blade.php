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
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#addEditSecodaryModal" class="btn btn-falcon-primary btn-sm"><i class="fe fe-plus-circle"></i> Add</button>
                                    <a href="/admin/users?id={{$usrid}}&&type={{$role}}" class="btn btn-primary btn-sm">Back</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive scrollbar">
                                <table class="table table-sm mb-0 fs--1 table-view-tickets">
                                    <thead class="text-800 bg-light">
                                        <tr>
                                            <th class="py-2 fs-0 pe-2">Email</th>
                                            <th class="sort align-middle ps-2" data-sort="phone">Phone</th>
                                            <th class="sort align-middle text-end" data-sort="agent">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list" id="table-ticket-body">
                                        @foreach($lists as $item)
                                        <tr>
                                            <td class="align-middle fs-0 py-1">{{$item->email}}</td>
                                            <td class="align-middle subject py-1 pe-1">{{$item->phone}}</td>
                                            <td class="align-middle subject py-1 pe-1 text-end">
                                                <div class="btn-group g-2">
                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#addEditSecodaryModal" wire:click="edit({{$item->id}})" class="btn btn-sm btn-falcon-primary rounded"><i class="fe fe-edit-3"></i></button>
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
        <div class="modal" id="addEditSecodaryModal" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" wire:ignore.self>
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
                                    <label class="col-form-label" for="email">Email :</label>
                                    <input class="form-control @error('email') is-invalid @enderror" id="email" wire:model="email" type="email" placeholder="Email" />
                                </div>
                                <div class="mb-3">
                                    <label class="col-form-label" for="phone">Phone :</label>
                                    <input class="form-control @error('phonr') is-invalid @enderror" id="phone" type="text" wire:model="phone" placeholder="Phone" />
                                </div>
                                
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                            <button class="btn btn-primary" wire:click="saveChanges" type="button"> {{ $info ? 'Save Changes' : 'Save' }} </button>
                        </div>
                        

                </div>
            </div>
        </div>


    </div>
</div>