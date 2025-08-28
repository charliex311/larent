<div>
    <div class="card">
        <div class="card-header border-bottom border-200 px-0">
            <div class="d-lg-flex justify-content-between">
                <div class="row flex-between-center gy-2 px-x1">
                    <div class="col-auto pe-0">
                        <h6 class="mb-0">All Withdraw (<span class="text-danger">Unpaid</span>)</h6>
                    </div>
                    <div class="col-auto"></div>
                </div>
                <div class="border-bottom border-200 my-3"></div>
                <div class="d-flex align-items-center justify-content-between justify-content-lg-end px-x1">
                    <!-- <div class="bg-300 mx-3 d-none d-lg-block" style="width:1px; height:29px"></div> -->
                    <!-- <div class="d-flex align-items-center"></div> -->
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive scrollbar">
                <table class="table table-sm mb-0 fs--1 table-view-tickets">
                    <thead class="text-800 bg-light">
                        <tr>
                            <th class="py-2 fs-0 pe-2">ID</th>
                            <th class="sort align-middle ps-2" data-sort="date">Employee Details</th>
                            <th class="sort align-middle ps-2" data-sort="date">Date</th>
                            <th class="sort align-middle ps-2" data-sort="amount">Amount</th>
                            <th class="sort align-middle ps-2" data-sort="method">Method</th>
                            <th class="sort align-middle ps-2" data-sort="payment_details">Payment Details</th>
                            <th class="sort align-middle ps-2" data-sort="status">Status</th>
                            <th class="sort align-middle text-end" data-sort="actions">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="list" id="table-ticket-body">
                        @if(count($lists) == 0)
                        <tr>
                            <td colspan="7" class="text-center">Not Found <i class="fe fe-alert-triangle text-warning"></i></td>
                        </tr>
                        @endif
                        @foreach($lists as $item)
                        <tr>
                            <td class="align-middle fs-0 py-2">{{$item->id}}</td>
                            <td class="align-middle subject py-1 pe-2">{!! employeeDetails($item->user_id) !!}</td>
                            <td class="align-middle subject py-1 pe-2">{{ parseDateTimeForHumans($item->created_at) }}</td>
                            <td class="align-middle subject py-1 pe-2">{{ $item->amount.' '.currencySign() }}</td>
                            <td class="align-middle subject py-1 pe-2">Bank</td>
                            <td class="align-middle subject py-1 pe-2">
                                @foreach(json_decode($item->payment_details) as $infos)
                                    @foreach($infos as $infokey => $info)
                                        @if($infokey != 'currency')
                                        <span class="text-capitalize">{{$infokey}}</span> : {{$info ? $info : "-"}} <br>
                                        @endif
                                    @endforeach
                                @endforeach
                            </td>
                            <td class="align-middle subject py-1 pe-2">
                                <span class="badge rounded-pill bg-primary">{{$item->status}}</span>
                            </td>
                            <td class="align-middle subject py-1 pe-2 text-end">
                                <div class="btn-group gap-2">
                                    <button type="button" class="btn btn-falcon-primary rounded btn-sm" onclick="return confirm('Are you sure you want to Approved?') || event.stopImmediatePropagation()" wire:click="approveNow({{$item->id}})">Approve</button>
                                    <button type="button" class="btn btn-falcon-danger rounded btn-sm" onclick="return confirm('Are you sure you want to Reject?') || event.stopImmediatePropagation()" wire:click="rejectNow({{$item->id}})">Reject</button>
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
