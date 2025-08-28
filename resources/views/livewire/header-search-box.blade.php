<div>
    <li class="nav-item">
        <div class="search-box" data-list='{"valueNames":["title"]}'>
            <form class="position-relative" data-bs-toggle="search" data-bs-display="static">
                <input class="form-control search-input fuzzy-search" wire:model.live="name" type="search" placeholder="Search..." aria-label="Search" />
                <span class="fas fa-search search-box-icon"></span>
            </form>
            <div class="btn-close-falcon-container position-absolute end-0 top-50 translate-middle shadow-none" data-bs-dismiss="search">
                <button class="btn btn-link btn-close-falcon p-0" aria-label="Close"></button>
            </div>
            <div class="dropdown-menu border font-base start-0 mt-2 py-0 overflow-hidden w-100" wire:ignore.self>
                <div class="scrollbar list py-3" style="max-height: 24rem;">
                    
                    <h6 class="dropdown-header fw-medium text-uppercase px-x1 fs--2 pt-0 pb-2">Users {{$name}}</h6>


                    @foreach($lists as $c)
                    
                    <a class="dropdown-item px-x1 py-2" href="/admin/add-user?id={{$c->id}}&&type={{role_name($c->id)}}">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-l status-online me-2">
                            <img class="rounded-circle" src="{{ employeePhoto($c->id) }}" alt="" />

                            </div>
                            <div class="flex-1">
                            <h6 class="mb-1 title fs-0"> {{ Str::ucfirst(employeeName($c->id)) }} <span class="badge rounded-pill bg-info">{{role_name($c->id)}}</span> </h6>
                            <p class="fs--2 mb-0 d-flex">
                                <span class="badge rounded-pill bg-primary">{{employeePhone($c->id)}}</span>
                                <span class="badge rounded-pill bg-success mx-1">{{employeeEmail($c->id)}}</span>
                            </p>
                            </div>
                        </div>
                    </a>

                    <hr class="text-200 dark__text-900">
                    @endforeach

                </div>
                <div class="text-center mt-n3">
                    <p class="fallback fw-bold fs-1 d-none">No Result Found.</p>
                </div>
            </div>
        </div>
    </li>
</div>
