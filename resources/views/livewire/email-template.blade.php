<div>
    <div class="row mt-3">
        <div class="col-sm-12 col-md-12 col-xl-12">
            <div class="card mt-1">
                <div class="card-header border-bottom border-200 px-0">
                    <div class="d-lg-flex justify-content-between">
                        <div class="row flex-between-center gy-2 px-x1">
                            <div class="col-auto pe-0">
                                <h6 class="mb-0">Search</h6>
                            </div>
                            <div class="col-auto">
                                <form wire:submit.prevent="search">
                                    <div class="input-group input-search-width">
                                        <input class="form-control form-control-sm shadow-none" type="search" placeholder="Search ..." aria-label="search" wire:model="title" />
                                        <button class="btn btn-sm btn-outline-secondary border-300 hover-border-secondary" type="submit">
                                            <span class="fa fa-search fs--1"></span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="border-bottom border-200 my-3"></div>
                        <div class="d-flex align-items-center justify-content-between justify-content-lg-end px-x1">
                            @can('email-add')
                            <a href="{{route('add-template')}}" class="btn btn-falcon-primary btn-sm me-1 mb-1" >
                                <span class="fe fe-plus-circle me-1"></span> Add New Template
                            </a>
                            @endcan
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive scrollbar">
                        <table class="table table-sm mb-0 fs--1 table-view-tickets">
                            <thead class="text-800 bg-light">
                                <tr>
                                    <th scope="py-2 fs-0 pe-2">ID</th>
                                    <th class="sort align-middle ps-2" data-sort="title">Title</th>
                                    <th class="sort align-middle ps-2" data-sort="type">Type</th>
                                    <th class="sort align-middle ps-2" data-sort="created_modified">Created Date</th>
                                    <th class="sort align-middle ps-2" data-sort="last_modified">Last Modified	</th>
                                    <th class="sort align-middle text-end" data-sort="actions">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="list" id="table-ticket-body">

                                @if(count($templates) == 0)
                                <tr>
                                    <td colspan="6" class="text-center py-2">Not Found <i class="fe fe-alert-triangle text-warning"></i> </td>
                                </tr>
                                @endif

                                @foreach($templates as $item)
                                <tr>
                                    <td class="align-middle fs-0 py-1">{{ $item->id }}</td>
                                    <td class="align-middle subject py-1 pe-4">{{ $item->name }}</td>
                                    <td class="align-middle subject py-1 pe-4 text-capitalize">{{ Str::replace('_',' ',$item->type) }}</td>
                                    <td class="align-middle subject py-1 pe-4">{{ systemFormattedDateTime($item->created_at) }}</td>
                                    <td class="align-middle subject py-1 pe-4">{{ systemFormattedDateTime($item->created_at) }}</td>
                                    <td class="align-middle subject py-1 pe-4 text-end">
                                        <div class="dropdown font-sans-serif position-static">
                                            <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal"
                                                type="button" data-bs-toggle="dropdown" data-boundary="window"
                                                aria-haspopup="true" aria-expanded="false"><span
                                                    class="fas fa-ellipsis-h fs--1"></span></button>
                                            <div class="dropdown-menu dropdown-menu-end border py-0">
                                                <div class="py-2">
                                                    @can('email-edit')
                                                    <a class="dropdown-item" href="/admin/add-template?id={{$item->id}}" >Edit</a>
                                                    @endcan
                                                    @can('email-delete')
                                                    <a class="dropdown-item text-danger" href="#!" wire:click="delete({{$item->id}})" >Delete</a>
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
        </div>
    </div>
</div>