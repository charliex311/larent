<div>
<div class="row justify-content-between align-items-center mb-2">
    <div class="col-md"></div>
    <div class="col-auto">
        <a href="/admin/invoices" class="btn btn-primary btn-sm me-1 mb-2 mb-sm-0">Back</a>
    </div>
</div>
    <div class="card mb-3 shadow-sm">
        <div class="card-header">
            <div class="row justify-content-between align-items-center">
                <div class="col-md">
                    <h5 class="mb-2 mb-md-0">Invocie Number : </h5>
                </div>
                <div class="col-auto">
                    <button class="btn btn-info btn-sm me-1 mb-2 mb-sm-0" id="addPaymentModal" wire:click="resetFields">Add</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive" wire:ignore>
                <table class="table table-sm table-bordered fs--1">
                    <tbody>
                        <tr>
                            <th>Customer:</th>
                            <th><strong>{{$customer_name}}</strong></th>
                            <th>Date:</th>
                            <th><strong>{{$customer_date}}</strong></th>
                        </tr>
                        <tr>
                            <th>Total Price:</th>
                            <th><strong>{{$total_price}}</strong></th>
                            <th>Remaining Price:</th>
                            <th><strong>{{$remaining_balance}}</strong></th>
                        </tr>
                    </tbody>
                </table>
            </div>

            <h5 class="mb-2 mb-md-0 pb-2">Transactions</h5>

            <div class="table-responsive">
                <table class="table table-sm table-bordered fs--1">
                    <tbody>
                        <tr class="bg-light">
                            <th>Nr.</th>
                            <th class="text-center">Date</th>
                            <th class="text-end">Price</th>
                            <th class="text-center">Remarks</th>
                            <th class="text-end">Actions</th>
                        </tr>
                        @if(count($transactions) == 0)
                        <tr>
                            <td colspan="5" class="text-center bg-light"> <small> <i class="fe fe-alert-circle"></i> Data Not Found! </small> </td>
                        </tr>
                        @endif
                        @foreach($transactions as $item)
                        <tr>
                            <td>{{$item->id}}</td>
                            <td class="text-center">{{$item->date->toDateString()}}</td>
                            <td class="text-end">{{abs($item->amount).' '.currencySign(1)}}</td>
                            <td class="text-center">{{$item->type}}</td>
                            <td class="text-end">
                                <button class="btn btn-sm btn-primary text-white btn-circle bg-primary edit" 
                                data-id="{{ $item->id }}" 
                                data-date="{{ invoice_trsaction_date($item->id) }}" 
                                data-amount="{{ invoice_trsaction_amount($item->id) }}" 
                                data-remarks="{{ invoice_trsaction_remarks($item->id) }}" 
                                type="button">
                                    <i class="fe fe-edit-2"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger text-white btn-circle bg-danger" 
                                type="button" onclick="return confirm('Are you sure you want to delete?') || event.stopImmediatePropagation()" 
                                wire:click="delete({{$item->id}})">
                                    <i class="fe fe-x"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- add payment modal -->
    <div class="modal" id="add-payment" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <form class="modal-dialog" role="document" style="max-width: 500px" wire:submit.prevent="makePaymentNow">
            <div class="modal-content position-relative" >
                <div class="position-absolute top-0 end-0 mt-2 me-2 z-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" 
                    data-bs-dismiss="modal" aria-label="Close" type="button"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="rounded-top-3 py-3 ps-4 pe-6 bg-light">
                        <h4 class="mb-1" id="modalExampleDemoLabel"> Add Invoice Payment </h4>
                    </div>
                    <div class="p-4 pb-0">
                        
                        <div class="mb-3">
                            <label class="col-form-label" for="date">Date:</label>
                            <input class="form-control" id="date" type="date" wire:model="date" required />
                            @error('date') <span class="error">{{ $message }}</span> @enderror 
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label" for="amount">Amount:</label>
                            <input class="form-control" id="amount" wire:model="amount"
                            placeholder="Enter Amount" type="text" required
                            oninput="this.value = this.value.match(/^\d+(\.\d{0,4})?/)?.[0] || '';" 
                            step="0.0001" />
                            @error('amount') <span class="error">{{ $message }}</span> @enderror 
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label" for="remarks">Remarks:</label>
                            <textarea wire:model="remarks" id="remarks" class="form-control" cols="30" rows="3" placeholder="Enter Remarks"></textarea>
                            @error('remarks') <span class="text-danger">{{ $message }}</span> @enderror 
                        </div>
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit"> Pay </button>
                </div>
            </div>
        </form>
    </div>

    @push('js')
    <script>
        $(document).on('click', '#addPaymentModal', function(){
            @this.set('transaction_id', '');
            $('#add-payment').modal('show');
        });
        $(document).on('click', '.edit', function(){
            @this.set('transaction_id', $(this).data('id'));
            @this.set('date', $(this).data('date'));
            @this.set('amount', $(this).data('amount'));
            @this.set('remarks', $(this).data('remarks'));
            $('#add-payment').modal('show');
        });
    </script>
    @endpush
</div>
