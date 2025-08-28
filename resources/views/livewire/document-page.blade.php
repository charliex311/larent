<div>
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <div class="card overflow-hidden mt-3">
                <div class="card-header p-0 bg-light scrollbar-overlay">
                    <ul class="nav nav-tabs border-0 tab-tickets-status flex-nowrap" id="in-depth-chart-tab"
                        role="tablist">
                        <li class="nav-item text-nowrap" role="presentation">
                            <a href="/admin/settings" class="nav-link mb-0 d-flex align-items-center gap-2 py-3 px-x1 {{ Route::currentRouteName()=='settings'?'active':'' }}"  wire:navigate>
                                <span class="far fa-user-circle icon text-600"></span>
                                <h6 class="mb-0 text-600">Profile Settings</h6>
                            </a>
                        </li>
                        <li class="nav-item text-nowrap" role="presentation">
                            <a href="/admin/document-page" class="nav-link mb-0 d-flex align-items-center gap-2 py-3 px-x1 {{ Route::currentRouteName()=='document-page'?'active':'' }}" wire:navigate>
                                <span class="fas fa-envelope-open-text icon text-600"></span>
                                <h6 class="mb-0 text-600">Documents</h6>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card mt-3 mb-lg-0">
                <div class="card-header">
                  <h5 class="mb-0">Documents</h5>
                </div>
                <div class="card-body bg-light">
                    
                    @if(role_name(Auth::user()->id) != 'Administrator')
                    <a class="mb-4 d-block d-flex align-items-center justify-content-center" href="#education-form" data-bs-toggle="collapse" aria-expanded="false" aria-controls="education-form">
                        <span class="circle-dashed">
                            <span class="fas fa-plus"></span>
                        </span>
                        <span class="ms-3">Add New Document</span>
                    </a>

                    <div class="collapse" id="education-form" wire:ignore.self>
                        <form class="row justify-content-center border mx-4 py-5 shadow-sm bg-white" wire:submit.prevent="save">
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="file">Select File</label>
                                    <input class="form-control @error('myfile') is-invalid @enderror" id="file" type="file" wire:model="myfile" />
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label" for="type">Document Name</label>
                                    <input 
                                    class="form-control @error('type') is-invalid @enderror" 
                                    wire:model.defer="type" 
                                    id="type" 
                                    type="text" 
                                    placeholder="Enter Document Name" />
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary" type="submit">Upload</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    @endif

                    @if(count($lists) > 0)
                    <table class="table">
                        <thead>
                            <tr class="text-900">
                                <th>Document Preview</th>
                                @if(role_name(Auth::user()->id) != 'Employee')
                                <th class="text-center">Uploded By</th>
                                @endif
                                <th class="{{ role_name(Auth::user()->id) == 'Administrator' ? 'text-center' : 'text-end' }}">Upload Date</th>
                                @if(role_name(Auth::user()->id) == 'Administrator')
                                <th class="pe-x1 text-end" style="width: 8rem">Actions</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lists as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center position-relative">
                                        <img class="rounded-1 border border-200" src="{{$item->file}}" width="80" alt="">
                                        <div class="flex-1 ms-3">
                                            <h6 class="mb-1 fw-semi-bold text-nowrap">
                                                <a class="text-900 stretched-link" href="/admin/document-view-page?id={{$item->id}}" wire:navigate>{{$item->type}}</a>
                                            </h6>
                                            <p class="fw-semi-bold mb-0 text-500">
                                                @if($item->status == 1)
                                                <span class="badge rounded-pill bg-success">Approved</span>
                                                @elseif($item->status == 2)
                                                <span class="badge rounded-pill bg-danger">Rejected</span>
                                                @else
                                                <span class="badge rounded-pill bg-info">In-Review</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                @if(role_name(Auth::user()->id) != 'Employee')
                                <td class="align-middle text-center fw-semi-bold">{{fullName($item->user_id) .' ('.role_name($item->user_id).')'}}</td>
                                @endif
                                <td class="align-middle {{ role_name(Auth::user()->id) == 'Administrator' ? 'text-center' : 'text-end' }} fw-semi-bold">{{ parseDateTimeForHumans($item->created_at) }}</td>
                                @if(role_name(Auth::user()->id) == 'Administrator')
                                <td class="align-middle text-end pe-x1 ">
                                    <div class="btn-group">
                                        <button class="btn btn-success btn-sm" type="button" wire:click="approve({{$item->id}})">Approve</button>
                                        <button class="btn btn-danger btn-sm" type="button" wire:click="reject({{$item->id}})">Reject</button>
                                    </div>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>