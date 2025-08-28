<div>
    <div class="row mt-3">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <div class="card mt-1">
                <div class="card-header border-bottom border-200 ">
                    <div class="row flex-between-center">
                        <div class="col-auto"><b>All Invoices (<span class="text-danger">Unpaid</span>)</b></div>
                        <div class="col-auto">
                            @can('invoices-add')
                            <a href="{{route('add-invoice')}}" class="btn btn-info btn-sm me-1 mb-1"><span class="fe fe-plus-circle"></span> Add New Invoice</a>
                            @endcan
                        </div>
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
                                    <td class="align-middle subject py-1">{{ $item->invoice_number }}</td>
                                    <td class="align-middle subject py-1">{{ fullName($item->user_id) }}</td>
                                    <td class="align-middle subject py-1">{{ parseDateOnly($item->date) }}</td>
                                    <td class="align-middle subject py-1">{{ $item->total_customer_price.' '.currencySign() }}</td>
                                    <td class="align-middle subject py-1">{{ $item->total_tax.' '.currencySign() }}</td>
                                    <td class="align-middle subject py-1">{{ $item->total_price.' '.currencySign() }}</td>
                                    <td class="align-middle subject py-1">-</td>
                                    <td class="align-middle subject py-1">{{ parseDateTime($item->created_at) }}</td>
                                    <td class="align-middle subject py-1">{{ parseDateTime($item->updated_at) }}</td>
                                    <td class="align-middle subject py-1 text-end">
                                        <div class="btn-group gap-2">
                                            <!-- <button class="btn btn-sm btn-falcon-primary rounded shadow-sm"><i class="fe fe-upload"></i></button> -->
                                            @if(role_name(Auth::user()->id) == 'Administrator')
                                            @can('invoices-edit')
                                            <a href="/admin/add-new-invoice?id={{$item->id}}" class="btn btn-sm btn-falcon-primary rounded shadow-sm"><i class="fe fe-edit-3"></i></a>
                                            @endcan
                                            @endif
                                            <a href="/admin/view-invoice?id={{$item->id}}" class="btn btn-sm btn-falcon-primary rounded shadow-sm"><i class="far fa-file-pdf"></i></a>
                                            @if(role_name(Auth::user()->id) == 'Administrator')
                                            @can('invoices-invoice-sent_to_email')
                                            <button class="btn btn-sm btn-falcon-primary rounded shadow-sm" data-bs-toggle="modal" data-bs-target="#send-mail" wire:click="selectedCustomer({{$item->id}})"><i class="fe fe-mail"></i></button>
                                            @endcan
                                            @can('invoices-delete')
                                            <button onclick="return confirm('Are you sure you want to delete?') || event.stopImmediatePropagation()" wire:click="deleteInvoice({{$item->id}})" class="btn btn-sm btn-falcon-danger rounded shadow-sm"><i class="fe fe-trash-2"></i></button>
                                            @endcan
                                            @endif
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


    <!-- send mail modal -->
    @can('invoices-invoice-sent_to_email')
    <div class="modal fade" id="send-mail" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px">
            <form wire:submit.prevent="sendMail" class="modal-content position-relative">
                <div class="position-absolute top-0 end-0 mt-2 me-2 z-1">
                    <button type="button" class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="rounded-top-3 py-3 ps-4 pe-6 bg-light">
                    <h4 class="mb-1" id="modalExampleDemoLabel">Send Mail </h4>
                    </div>
                    <div class="p-4 pb-0">
                        
                        <div class="mb-3">
                            <label class="col-form-label" for="template">Select Template</label>
                            <select wire:model.live="template" id="template" class="form-control text-capitalize @error('template') is-invalid @enderror">
                                <option value="">Select</option>
                                @foreach($templates as $titem)
                                <option value="{{$titem->id}}">{{Str::replace('_',' ', $titem->type)}}</option>
                                @endforeach
                            </select>
                        </div>

                        @if($body)
                        <div class="border px-3 mb-5">
                            <p>{!! $body !!}</p>
                        </div>
                        @endif
                        
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit"> Send </button>
                </div>
            </form>
        </div>
    </div>
    @endcan
</div>