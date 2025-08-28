<div>
    <div class="card">
        <div class="card-header border-bottom border-200 px-0">
            <div class="d-lg-flex justify-content-between">
                <div class="row flex-between-center gy-2 px-x1">
                    <div class="col-auto pe-0">
                        <h6 class="mb-0">Search</h6>
                    </div>
                    <div class="col-auto">
                        <form>
                        <div class="input-group input-search-width">
                            <input class="form-control form-control-sm shadow-none" type="search" placeholder="Search ..." aria-label="search">
                            <button class="btn btn-sm btn-outline-secondary border-300 hover-border-secondary">
                                <span class="fa fa-search fs--1"></span>
                            </button>
                        </div>
                        </form>
                    </div>
                </div>
                <div class="border-bottom border-200 my-3"></div>
                <div class="d-flex align-items-center justify-content-between justify-content-lg-end px-x1"></div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive scrollbar">
                <table class="table table-sm mb-0 fs--1 table-view-tickets">
                    <thead class="text-800 bg-light">
                        <tr>
                            <th class="py-2 fs-0 pe-2">ID</th>
                            <th class="sort align-middle ps-2" data-sort="name">Name</th>
                            <th class="sort align-middle ps-2" data-sort="phone">Phone</th>
                            <th class="sort align-middle ps-2" data-sort="email">Email</th>
                            <th class="sort align-middle ps-2" data-sort="due_amount">Due Amount</th>
                            <th class="sort align-middle ps-2" data-sort="last_invoice_date">Last Invoice Date</th>
                            <th class="sort align-middle text-end" data-sort="actions">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="list" id="table-ticket-body">
                        @php $counter=0; @endphp
                        @foreach($users as $user)
                        <tr>
                            <td class="align-middle fs-0 py-1">{{$counter+=0}}</td>
                            <td class="align-middle name py-1 pe-4">{{fullName($user->id)}}</td>
                            <td class="align-middle phone py-1 pe-4">{{ customerPhone($user->id) }}</td>
                            <td class="align-middle email py-1 pe-4">{{ customerEmail($user->id) }}</td>
                            <td class="align-middle subject py-1 pe-4">{{ $user->customertransactions[0]->total_amount }}</td>
                            <td class="align-middle subject py-1 pe-4"></td>
                            <td class="align-middle subject py-1 pe-4 text-end"></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            <div class="row align-items-center">
                <div class="col"><strong>Showing {{ $users->firstItem() }} - {{ $users->lastItem() }} of {{ $users->total() }}</strong></div>
                <div class="col-auto d-flex">{{ $users->links() }}</div>
            </div>
        </div>
    </div>
</div>
