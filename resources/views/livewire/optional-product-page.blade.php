<div>
    <div class="row mt-3">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <div class="card mt-1 shadow-sm">

                <div class="card-header border-bottom border-200 px-0">
                    <div class="d-lg-flex justify-content-between">
                        <div class="row flex-between-center gy-2 px-x1">
                            <div class="col-auto pe-0">
                                <h6 class="mb-0">Search</h6>
                            </div>
                            <div class="col-auto">
                                <form wire:submit.prevent="search">
                                    <div class="input-group input-search-width">
                                        <input class="form-control form-control-sm shadow-none" type="search" wire:model.defer="name"  placeholder="Search  by name" aria-label="search">
                                        <button class="btn btn-sm btn-outline-secondary border-300 hover-border-secondary">
                                            <span class="fa fa-search fs--1"></span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="border-bottom border-200 my-3"></div>
                        <div class="d-flex align-items-center justify-content-between justify-content-lg-end px-x1">
                            <div class="d-flex align-items-center">
                                @can('optional-add')
                                <a href="{{ route('add-optional-product') }}" class="btn btn-falcon-primary btn-sm me-1 mb-1" wire:navigate>
                                    <span class="fe fe-plus-circle me-1" ></span> Add New
                                </a>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive scrollbar">
                        <table class="table table-sm mb-0 fs--1 table-view-tickets">
                            <thead class="text-800 bg-light">
                                <tr class="bg-light">
                                    <th class="py-2 fs-0 pe-2">ID</th>
                                    <th class="sort align-middle ps-2" data-sort="icon">Icon</th>
                                    <th class="sort align-middle ps-2" data-sort="name">Name</th>
                                    <th class="sort align-middle ps-2" data-sort="price">Price</th>
                                    <th class="sort align-middle ps-2" data-sort="status">Status</th>
                                    <th class="sort align-middle ps-2" data-sort="created_at">Created Date</th>
                                    <th class="sort align-middle ps-2" data-sort="updated_at">Last Modified</th>
                                    <th class="sort align-middle text-end" data-sort="actions">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="list" id="table-ticket-body">
                                @if(count($lists) == 0)
                                <tr>
                                    <td colspan="8" class="text-center"><i>Not Found</i> <i class="fe fe-alert-triangle text-warning"></i></td>
                                </tr>
                                @endif
                                @foreach($lists as $item)
                                <tr>
                                    <td class="align-middle fs-0 py-1">{{$item->id}}</td>
                                    <td class="align-middle icon py-1 pe-1">
                                        @if($item->icon)
                                        <img 
                                        class="img-fluid" 
                                        src="{{$item->icon}}" 
                                        data-bs-toggle="tooltip" 
                                        data-bs-placement="top" 
                                        title="{{ $item->name }}" 
                                        alt="{{ $item->name }}" 
                                        width="56">
                                        @endif
                                    </td>
                                    <td class="align-middle name py-1 pe-1">{{ $item->name }}</td>
                                    <td class="align-middle price py-1 pe-1">{{ priceFormat($item->currency, $item->add_on_price) }}</td>
                                    <td class="align-middle status py-1 pe-1">
                                        {!! $item->status == 1 ? '<span class="badge rounded-pill bg-success">Active</span>' : '<span class="badge rounded-pill bg-danger">Inactive</span>' !!}
                                    </td>
                                    <td class="align-middle created_at py-1 pe-1"> <span class="badge rounded-pill badge-subtle-primary">{{ systemFormattedDateTime($item->created_at) }}</span> </td>
                                    <td class="align-middle updated_at py-1 pe-1"> <span class="badge rounded-pill badge-subtle-primary">{{systemFormattedDateTime($item->updated_at) }}</span> </td>
                                    <td class="align-middle actions py-1 pe-1 text-end">
                                        <div class="btn-group" role="group">
                                            @can('optional-edit')
                                            <a class="btn btn-falcon-primary rounded btn-sm" href="/admin/edit-optional-product?id={{$item->id}}"><span class="fe fe-edit-3"></span></a>
                                            @endcan
                                            @can('optional-delete')
                                            <button 
                                            class="btn btn-falcon-danger rounded btn-sm" 
                                            type="button" 
                                            onclick="return confirm('Are you sure you want to delete?') || event.stopImmediatePropagation()" 
                                            wire:click="delete({{$item->id}})" style="margin-left: 5px;"><span class="fe fe-trash-2"></span></button>
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
        </div>
    </div>
</div>
