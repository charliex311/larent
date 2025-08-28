<div>
    <div class="card">
        <div class="card-header border-bottom border-200 px-0">
            <div class="d-lg-flex justify-content-between">
                <!--div class="row flex-between-center gy-2 px-x1">
                    <div class="col-auto pe-0">
                        <h6 class="mb-0">Search</h6>
                    </div>
                    <div class="col-auto">
                        <form wire:submit.prevent="search">
                            <div class="input-group input-search-width">
                                <input class="form-control form-control-sm shadow-none" wire:model="search_key" type="search" placeholder="Search  by name" aria-label="search">
                                <button class="btn btn-sm btn-outline-secondary border-300 hover-border-secondary" type="submit">
                                    <span class="fa fa-search fs--1"></span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div-->
                <div class="border-bottom border-200 my-3"></div>
                <div class="d-flex align-items-center justify-content-between justify-content-lg-end px-x1">
                    <div class="d-flex align-items-center">
                        @can('pop_ups-add')
                        <button class="btn btn-falcon-default btn-sm mx-2" type="button" data-bs-toggle="modal" data-bs-target="#pop-modal">
                            <span class="fas fa-plus" data-fa-transform="shrink-3"></span>
                            <span class="d-sm-inline-block d-xxl-inline-block ms-1">Add</span>
                        </button>
                        @endcan
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
                            <th class="sort align-middle ps-2" data-sort="user">User</th>
                            <th class="sort align-middle ps-2" data-sort="role">Role</th>
                            <th class="sort align-middle ps-2" data-sort="title">Title</th>
                            <th class="sort align-middle ps-2" data-sort="image">Image</th>
                            <th class="sort align-middle ps-2" data-sort="status">Status</th>
                            <th class="sort align-middle text-end" data-sort="action">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="list" id="table-ticket-body">
                        @if(count($lists) == 0)
                        <tr>
                            <td colspan="5" class="text-center"><i>Not Found</i> <i class="fe fe-alert-triangle text-warning"></i></td>
                        </tr>
                        @endif

                        @php $counter=0; @endphp
                        @foreach($lists as $item)
                        <tr>
                            <td class="align-middle fs-0 py-1">{{$counter+=1}}</td>
                            <td class="align-middle title fs-0 py-1 text-capitalize">{{customerName($item->user_id)}}</td>
                            <td class="align-middle title fs-0 py-1 text-capitalize">{{$item->role?$item->role:'-'}}</td>
                            <td class="align-middle title fs-0 py-1 text-capitalize">{{$item->title}}</td>
                            <td class="align-middle title fs-0 py-1"> <img src="{{$item->image?asset('public/storage').'/'.$item->image:'-'}}" alt="" width="150"> </td>
                            <td class="align-middle title fs-0 py-1"> <span class="badge rounded-pill {{$item->status == 'active' ? 'bg-success' : 'bg-danger'}}">{{$item->status}}</span> </td>
                            <td class="align-middle action py-1 pe-1 text-end">
                                <div class="button-group">
                                    @can('pop_ups-edit')
                                    <button class="btn btn-falcon-primary btn-sm" data-bs-toggle="modal" data-bs-target="#pop-modal" wire:click="edit({{$item->id}})" type="button"><i class="fe fe-edit"></i></button>
                                    @endcan
                                    @can('pop_ups-delete')
                                    <button class="btn btn-falcon-danger btn-sm" type="button" onclick="return confirm('Are you sure you want to delete?') || event.stopImmediatePropagation()" wire:click="delete({{$item->id}})"><i class="fe fe-trash-2"></i></button>
                                    @endcan
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


    <!-- pop modal -->
    <div class="modal fade" id="pop-modal" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document" style="max-width: 500px">
            <form wire:submit.prevent="savechanges" class="modal-content position-relative">
                <div class="position-absolute top-0 end-0 mt-2 me-2 z-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close" type="button"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="rounded-top-3 py-3 ps-4 pe-6 bg-light">
                        <h4 class="mb-1" id="modalExampleDemoLabel"> {{$row ? 'Update' : 'Add'}} </h4>
                    </div>
                    <div class="p-4 pb-0">
                        
                        <div class="mb-3">
                            <label class="col-form-label" for="recipient-name">Title:</label>
                            <input class="form-control @error('title') is-invalid @enderror" id="recipient-name" type="text" wire:model="title" />
                            @error('title') <small class="text-danger"><b>{{$message}}</b></small> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label" for="message-text">Description:</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="message-text" wire:model="description" cols="30" rows="5"></textarea>
                            @error('description') <small class="text-danger"><b>{{$message}}</b></small> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="customFileSm">Image:</label>
                            <input class="form-control form-control-sm" id="customFileSm" type="file" wire:model="image" />
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label" for="message-text">User Role:</label>
                            <select class="form-select @error('role') is-invalid @enderror" aria-label="Default select example" wire:model.live="role">
                                <option value="">Select User Role</option>
                                @foreach($roles as $rolename)
                                <option value="{{$rolename->name}}">{{$rolename->name}}</option>
                                @endforeach
                            </select>
                            @error('role') <small class="text-danger"><b>{{$message}}</b></small> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label" for="message-text">Select User: {{$user_id}}</label>
                            <select class="form-select @error('user_id') is-invalid @enderror" aria-label="Default select example" wire:model="user_id">
                                <option value="">Select User</option>
                                @foreach($users as $user)
                                <option value="{{$user->id}}" @if($user_id == $user->id) selected="" @endif>{{customerName($user->id)}} ({{customerEmail($user->id).', '.customerPhone($user->id)}})</option>
                                @endforeach
                            </select>
                            @error('user_id') <small class="text-danger"><b>{{$message}}</b></small> @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label" for="customFileSm">Status:</label>
                            <select class="form-select @error('status') is-invalid @enderror" aria-label="Default select example" wire:model="status">
                                <option value="">Select Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">In-Active</option>
                            </select>
                        </div>
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submiy"> {{$row ? 'Save Changes' : 'Add'}} </button>
                </div>
            </form>
        </div>
    </div>


</div>
