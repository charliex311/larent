<div>

    @if(role_name(Auth::user()->id) == 'Customer')

    <div class="row mt-4 g-1">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <div class="card shadow-sm">
                <div class="card-header border-bottom border-200 px-0">
                    <div class="d-lg-flex justify-content-between">
                        <div class="row flex-between-center gy-2 px-x1">
                            <div class="col-auto pe-0">
                                <h6 class="mb-0">Billing History </h6>
                            </div>
                            <div class="col-auto"></div>
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
                                    <th class="py-1 fs-0 pe-1">ID</th>
                                    <th class="sort align-middle ps-1">Date</th>
                                    <th class="sort align-middle ps-1" data-sort="amount">Amount</th>
                                    <th class="sort align-middle ps-1" data-sort="type">Purpose</th>
                                    <th class="sort align-middle ps-1" data-sort="transaction_id">Transaction ID</th>
                                    <th class="sort align-middle ps-1 text-end" data-sort="status">Status</th>
                                </tr>
                            </thead>
                            <tbody class="list" id="table-ticket-body">
                                @php $counter=0; @endphp
                                @foreach($lists as $record)
                                <tr>
                                    <td class="align-middle fs-0 py-1">{{ $counter+=1 }}</td>
                                    <td class="align-middle date fs-0 py-1">{{ parseDateTimeForHumans($record->created_at) }}</td>
                                    <td class="align-middle amount py-1 pe-2">
                                        <span class="badge rounded-pill @if($record->amount > 0) bg-success @else bg-danger @endif">
                                            @if($record->status != 'success' && $record->deposit)
                                            {{ $record->deposit['amount'].' '.currencySign() }}
                                            @else
                                            {{$record->amount.' '.currencySign()}}
                                            @endif
                                        </span>
                                    </td>
                                    <td class="align-middle type py-1 pe-2 text-capitalize">{{$record->type}}</td>
                                    <td class="align-middle transaction_id py-1 pe-2 text-capitalize">{{$record->transaction_id}}</td>
                                    <td class="align-middle status py-1 pe-2 text-end">
                                        <span class="badge text-capitalize rounded-pill @if($record->status == 'pending') bg-primary @elseif($record->status == 'success') bg-success @else bg-danger @endif">{{Str::replace('_','-',$record->status)}}</span>
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
    
    @elseif(role_name(Auth::user()->id) == 'Employee')
    <div class="row mt-4 g-1">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <div class="card"
                style="box-shadow: 0 4px 8px 0 rgb(146 140 175);transition: 0.3s;border: 1px solid #ffefef;">
                <div class="card-body">
                    <div class="col-md-4 offset-md-4">
                        <div style="border: 1px solid #000;border-radius:12px;" class="card m-4 text-center">
                            <div class="card-body">
                                <div class="media">
                                    <div class="media-body overflow-hidden">
                                        <p class="text-truncate font-size-14 mb-2 text-center">Your Remaining Income</p>
                                        <h4 class="mb-0">{{$total_amount.' '.currencySign()}}</h4>
                                    </div>
                                    <div class="text-primary">
                                        <i class="ri-exchange-dollar-fill font-size-40"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center my-3">
                        @if($total_amount > 0)

                            @if(checkPaymentDetails(Auth::user()->id))
                            <button 
                            onclick="return confirm('Are you sure you want to Withdraw?') || event.stopImmediatePropagation()" 
                            wire:click="makeWithdraw({{$total_amount}})"
                            class="btn btn-primary text-center" 
                            type="button">Withdraw</button>
                            @else
                            <div class="alert alert-info border-2 d-flex align-items-center" role="alert">
                                <div class="bg-info me-3 icon-item"><span class="fas fa-info-circle text-white fs-3"></span></div>
                                <p class="mb-0 flex-1">Please Talk with Support to Update Your Billing Information!</p>
                            </div>
                            @endif
                        @endif
                    </div>

                    <div class="progress">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                            aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                    </div>

                    <br>
                    <p class="card-title-desc text-center">From our Payments Department you can see all your payment
                        histroy
                    </p>

                    <div class="table-responsive scrollbar">
                        <table class="table table-sm mb-0 fs--1 table-view-tickets" id="example">
                            <thead class="text-800 bg-light">
                                <tr>
                                    <th class="py-2 fs-0 pe-2">Date</th>
                                    <th class="sort align-middle ps-2" data-sort="amount">Amount</th>
                                    <th class="sort align-middle ps-2" data-sort="method">Method</th>
                                    <th class="sort align-middle ps-2" data-sort="details">Payment Details</th>
                                    <th class="sort align-middle ps-2" data-sort="cycle">Payment Cycle</th>
                                    <th class="sort align-middle text-end" data-sort="status">Status</th>
                                </tr>
                            </thead>

                            <tbody class="list" id="table-ticket-body">
                                @foreach($withdraws as $withdraw)
                                <tr>
                                    <td class="align-middle fs-0 py-1">{{ parseDateTimeForHumans($withdraw->created_at) }}</td>
                                    <td class="align-middle subject py-1 pe-1">{{ $withdraw->amount.' '.currencySign() }}</td>
                                    <td class="align-middle subject py-1 pe-1">Bank</td>
                                    <td class="align-middle subject py-1 pe-1">
                                        <span class="badge bg-light">
                                            <table class="table p-0 m-0 table-sm">
                                                <tbody>
                                                    @foreach(json_decode($withdraw->payment_details) as $infos)
                                                        @foreach($infos as $infokey => $info)
                                                            @if($infokey != 'currency')
                                                            <tr class="text-dark p-0 m-0 text-capitalize">
                                                                <td class="p-0 m-0 text-left">{{$infokey}}</td>
                                                                <td class="text-end p-0 m-0">{{$info ? $info : "-"}}</td>
                                                            </tr>
                                                            @endif
                                                        @endforeach
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </span>
                                    </td>
                                    <td class="align-middle subject py-1 pe-1"><span class="badge rounded-pill bg-primary">On Request</span></td>
                                    <td class="align-middle subject py-1 pe-1 text-end"><span class="badge rounded-pill {{ $withdraw->status == 'paid' ? 'bg-success' : 'bg-danger'}} ">{{ $withdraw->status == 'paid' ? 'Paid' : 'In-Review'}}</span></td>
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
    @endif
    
</div>