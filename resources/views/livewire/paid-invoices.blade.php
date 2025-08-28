<div>
    <div class="row mt-3">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <div class="card mt-1">
                <div class="card-header border-bottom border-200 px-0">
                    <div class="d-lg-flex justify-content-between">
                        <div class="row flex-between-center gy-2 px-x1">
                            <div class="col-auto pe-0">
                                <h6 class="mb-0"><b>All Invoices (<span class="text-success">Paid</span>)</b></h6>
                            </div>
                            <div class="col-auto"></div>
                        </div>
                        <div class="border-bottom border-200 my-3"></div>
                        <div class="d-flex align-items-center justify-content-between justify-content-lg-end px-x1"></div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive scrollbar">
                        <table class="table table-sm mb-0 fs--1 table-view-tickets" id="myTable">
                            <thead class="text-800 bg-light">
                                <tr>
                                    <th class="py-2 pe-2">S#</th>
                                    <th class="sort align-middle ps-2" data-sort="invoice">Invoice#</th>
                                    <th class="sort align-middle ps-2" data-sort="name">Name</th>
                                    <th class="sort align-middle ps-2" data-sort="date">Date</th>
                                    <th class="sort align-middle ps-2" data-sort="price">Price</th>
                                    <th class="sort align-middle ps-2" data-sort="tax">Tax</th>
                                    <th class="sort align-middle ps-2" data-sort="total_price">Total Price</th>
                                    <th class="sort align-middle ps-2" data-sort="remaining">Remaining Price</th>
                                    <th class="sort align-middle ps-2" data-sort="created_at">Created Date</th>
                                    <th class="sort align-middle ps-2" data-sort="last_modified">Last Modified</th>
                                    <th class="sort align-middle ps-2 text-end" data-sort="actions">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="list" id="table-ticket-body">
                                @php $counter=0; @endphp
                                @foreach($lists as $item)
                                <tr>
                                    <td class="align-middle fs-0 py-1">{{ $counter+=1 }}</td>
                                    <td class="align-middle subject py-1 pe-4">{{ $item->invoice_number }}</td>
                                    <td class="align-middle subject py-1 pe-4">{{ fullName($item->user_id) }}</td>
                                    <td class="align-middle subject py-1 pe-4">{{ parseDateOnly($item->date) }}</td>
                                    <td class="align-middle subject py-1 pe-4">{{ $item->total_customer_price.' '.currencySign() }}</td>
                                    <td class="align-middle subject py-1 pe-4">{{ $item->total_tax.' '.currencySign() }}</td>
                                    <td class="align-middle subject py-1 pe-4">{{ $item->total_price.' '.currencySign() }}</td>
                                    <td class="align-middle subject py-1 pe-4">-</td>
                                    <td class="align-middle subject py-1 pe-4">{{ parseDateTime($item->created_at) }}</td>
                                    <td class="align-middle subject py-1 pe-4">{{ parseDateTime($item->updated_at) }}</td>
                                    <td class="align-middle subject py-1 pe-4 text-end">
                                        <div class="btn-group gap-2">
                                            <a href="/admin/view-invoice?id={{$item->id}}" class="btn btn-sm btn-falcon-primary rounded shadow-sm"><i class="far fa-file-pdf"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @if(gettype($lists) == 'array')
                @if(count($lists) > 0)
                <div class="card-footer">
                    <div class="row align-items-center">
                        <div class="col"><strong>Showing {{ $lists->firstItem() }} - {{ $lists->lastItem() }} of {{ $lists->total() }}</strong></div>
                        <div class="col-auto d-flex">{{ $lists->links() }}</div>
                    </div>
                </div>
                @endif
                @endif
            </div>
        </div>
    </div>
</div>