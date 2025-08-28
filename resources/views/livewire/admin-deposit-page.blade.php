<div>
    <div class="card shadow-sm">
        <div class="card-header border-bottom border-200 px-0">
            <div class="d-lg-flex justify-content-between">
                <div class="row flex-between-center gy-2 px-x1">
                    <div class="col-auto pe-0">
                        <h6 class="mb-0">Deposit History</h6>
                    </div>
                    <div class="col-auto"></div>
                </div>
                <div class="border-bottom border-200 my-3"></div>
                <div class="d-flex align-items-center justify-content-between justify-content-lg-end px-x1">
                    <div class="d-flex align-items-center">
                        <!--button class="btn btn-falcon-default btn-sm mx-2" type="button">
                            <span class="fas fa-plus" data-fa-transform="shrink-3"></span>
                            <span class="d-sm-inline-block d-xxl-inline-block ms-1">New</span>
                        </button-->
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive scrollbar">
                <table class="table table-sm mb-0 fs--1 table-view-tickets">
                    <thead class="text-800 bg-light">
                        <tr>
                            <th class="py-2 fs-0 pe-1">ID</th>
                            <th class="sort align-middle ps-1" data-sort="customer">Customer</th>
                            <th class="sort align-middle ps-1" data-sort="amount">Amount</th>
                            <th class="sort align-middle ps-1" data-sort="payment">Payment Method</th>
                            <th class="sort align-middle ps-1" data-sort="transaction">Transaction ID</th>
                            <th class="sort align-middle ps-1" data-sort="date">Date</th>
                            <th class="sort align-middle ps-1" data-sort="notes">Notes</th>
                            <th class="sort align-middle ps-1" data-sort="status">Status</th>
                            <th class="sort align-middle text-end" data-sort="actions">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="list" id="table-ticket-body">
                        @php $counter=0; @endphp
                        @foreach($lists as $item)
                        <tr>
                            <td class="align-middle fs-0 py-1">{{$counter+=1}}</td>
                            <td class="align-middle customer py-1 pe-1">{{employeeName($item->user_id)}}</td>
                            <td class="align-middle amount py-1 pe-1"> <span class="badge rounded-pill @if($item->status == 'pending') bg-primary @elseif($item->status == 'success') bg-success @else bg-danger @endif">{{$item->amount.' '.currencySign()}}</span> </td>
                            <td class="align-middle payment py-1 pe-1">{{$item->payment_method}}</td>
                            <td class="align-middle transaction py-1 pe-1">{{$item->payment_details}}</td>
                            <td class="align-middle date py-1 pe-1">{{ parseDateTimeForHumans($item->created_at) }}</td>
                            <td class="align-middle notes py-1 pe-1">{{$item->notes}}</td>
                            <td class="align-middle status py-1 pe-1 text-capitalize">
                                <span class="badge rounded-pill @if($item->status == 'pending') bg-primary @elseif($item->status == 'success') bg-success @else bg-danger @endif">{{$item->status}}</span>
                            </td>
                            <td class="align-middle actions py-2 pe-4 text-end">
                                <div class="btn-group gap-2">

                                    @if($item->status == 'reject' || $item->status == 'pending')
                                    
                                    <a 
                                    href="javascript::void(0);" 
                                    class="btn btn-sm rounded btn-falcon-primary" 
                                    onclick="return confirm('Are you sure you want to Approve This?') || event.stopImmediatePropagation()"
                                    wire:click="approve({{$item->id}})">Approve</a>

                                    @endif

                                    @if($item->status == 'success' || $item->status == 'pending')

                                    <a 
                                    href="javascript::void(0);" 
                                    class="btn btn-sm rounded btn-falcon-danger" 
                                    onclick="return confirm('Are you sure you want to Reject This?') || event.stopImmediatePropagation()"
                                    wire:click="reject({{$item->id}})">Reject</a>

                                    @endif
                                    
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