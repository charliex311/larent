<div>
    <form wire:submit.prevent="generate">
    <div class="card">
        <div class="card-header border-bottom border-200 px-0">
            <div class="d-lg-flex justify-content-between">
                <div class="row flex-between-center gy-2 px-x1">
                    <div class="col-auto pe-0"><h5 class="mb-0 text-muted"> <b>Add New Invoice</b> </h5></div>
                    <div class="col-auto"></div>
                </div>
                <div class="border-bottom border-200 my-3"></div>
                <div class="d-flex align-items-center justify-content-between justify-content-lg-end px-x1">
                    <div class="d-flex align-items-center">
                        <a href="/admin/invoices" class="btn btn-info btn-sm me-1 mb-1">Back</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body bg-light">
            <div class="row">
                <div class="col-lg-6 pe-lg-2">
                    <div class="mb-3">
                        <label for=""><b>Select Customer</b></label>
                        <select class="form-select form-select-lg @error('customer') is-invalid @enderror" id="customer" size="1" wire:model.live="customer" >
                            <option value="">Select Customer</option>
                            @foreach($customers as $cus)
                            <option value="{{ $cus->id }}">{{$cus->first_name.' '.$cus->last_name}} {{$cus->customer_type == 'host' ? ' ('.$cus->customer_type.')' : '('.$cus->customer_type.')'}}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('customer') <small><strong class="text-danger">{{$message}}</strong></small> @enderror
                </div>
                <div class="col-lg-6 pe-lg-2">
                    <div class="mb-3">
                        <label for="billing_address"><b>Customer Address</b></label>
                        <textarea wire:model="billing_address" id="billing_address" class="form-control @error('billing_address') is-invalid @enderror" cols="30" rows="2"></textarea>
                        @error('billing_address') <small><strong class="text-danger">{{$message}}</strong></small> @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 pe-lg-2">
                    <label for="current_date"><b>Date</b></label>
                    <input type="date" wire:model="current_date" id="current_date" class="form-control @error('current_date') is-invalid @enderror" />
                    @error('current_date') <small><strong class="text-danger">{{$message}}</strong></small> @enderror
                </div>
                <div class="col-lg-3 pe-lg-2">
                    <div class="mb-3">
                        <label for="invoice_number"><b>Invoice Number</b></label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">{{ $invoice_prefix }}</span>
                            <input class="form-control bg-light @error('random_invoice_number') is-invalid @enderror" type="text" value="{{$random_invoice_number}}" id="invoice_number" readonly />
                        </div>
                        @error('random_invoice_number') <small><strong class="text-danger">{{$message}}</strong></small> @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 pe-lg-2">
                    <label for="start_date"><b>Start Date</b></label>
                    <input type="date" wire:model.live="start_date" id="start_date" class="form-control rounded @error('start_date') is-invalid @enderror" />
                    @error('start_date') <small><strong class="text-danger">{{$message}}</strong></small> @enderror
                </div>
                <div class="col-lg-3 pe-lg-2">
                    <label for="end_date"><b>End Date</b></label>
                    <input type="date" wire:model.live="end_date" id="end_date" class="form-control rounded @error('end_date') is-invalid @enderror" />
                    @error('end_date') <small><strong class="text-danger">{{$message}}</strong></small> @enderror
                </div>
                <div class="col-lg-1 pe-lg-2">
                </div>
            </div>
        </div>
        <div class="card-body p-0 bg-light">
            <div class="table-responsive scrollbar">
                <table class="table table-sm fs--1 table-view-tickets">
                    <thead class="text-800 bg-white">
                        <tr>
                            <th class="py-2 fs-0 pe-2">Nr.</th>
                            <th class="sort text-center ps-2" data-sort="service">Service</th>
                            <th class="sort text-center ps-2" data-sort="date">Date</th>
                            <th class="sort text-center ps-2" data-sort="unit">Unit</th>
                            <th class="sort text-center ps-2" data-sort="customer_hour">Customer Hour</th>
                            <th class="sort text-center ps-2" data-sort="service_price">Service Price</th>
                            <th class="sort text-center ps-2" data-sort="customer_price">Customer Price</th>
                            <th class="sort ps-2 text-end" data-sort="tax">Tax</th>
                        </tr>
                    </thead>
                    <tbody class="list" id="table-ticket-body">
                        @php $counter = 0;  @endphp
                        @foreach($jobs as $job)
                        <tr>
                            <td class="fs-0 py-1">{{ $counter+=1; }}</td>
                            <td class="text-center service fs-0 py-1">{{ serviceName($job->service_id) }}</td>
                            <td class="text-center date fs-0 py-1">{{ parseDateOnly($job->job_date) }}</td>
                            <td class="text-center unit fs-0 py-1">hour</td>
                            <td class="text-center customer_hour fs-0 py-1">{!! getTotalHourReadable($job->id) !!}</td>
                            <td class="text-center service_price fs-0 py-1">{{ servicePrice($job->service_id).' '.serviceCurrency($job->service_id) }}</td>
                            <td class="text-center customer_price fs-0 py-1">{{ calculateTotalBillAmount(getTotalHour($job->id), $job->hourly_rate, $job->id).' '.$currency }}</td>
                            <td class="align-middle tax fs-0 py-1 text-end">{{ calculateTaxUsingCustomerPrice($job->id) . ' ' . $job->currency . ' ('. globalTax() .'%)' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="7" class="text-end">Total Customer Price : </th>
                            <th class="text-end">{{$total_customer_price . ' ' . $currency}} </th>
                        </tr>
                        <tr>
                            <th colspan="7" class="text-end">Total Tax ({{globalTax().'%'}}) : </th>
                            <th class="text-end">{{$total_tax . ' ' . $currency}}</th>
                        </tr>
                        <tr>
                            <th colspan="7" class="text-end">Total Price : </th>
                            <th class="text-end">{{$total_price . ' ' . $currency}}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="card-footer text-end">
            <button class="btn btn-primary" type="submit"> {{ $invoice ? 'Update Invoice' : 'Generate Invoice' }} </button>
        </div>
    </div>
    </form>


    @push('js')
    <script>
        var choicesInit = function choicesInit() {
            if (window.Choices) {
                var elements = document.querySelectorAll('.js-choice');
                elements.forEach(function(item) {
                    var userOptions = utils.getData(item, 'options');
                    var choices = new window.Choices(item, _objectSpread({
                        itemSelectText: ''
                    }, userOptions));

                    var needsValidation = document.querySelectorAll('.needs-validation');
                    needsValidation.forEach(function(validationItem) {
                        var selectFormValidation = function selectFormValidation() {
                            validationItem.querySelectorAll('.choices').forEach(function(
                                choicesItem) {
                                var singleSelect = choicesItem.querySelector(
                                    '.choices__list--single');
                                var multipleSelect = choicesItem.querySelector(
                                    '.choices__list--multiple');
                                if (choicesItem.querySelector('[required]')) {
                                    if (singleSelect) {
                                        var _singleSelect$querySe;
                                        if (((_singleSelect$querySe = singleSelect
                                                    .querySelector(
                                                        '.choices__item--selectable')) ===
                                                null || _singleSelect$querySe === void 0 ?
                                                void 0 : _singleSelect$querySe.getAttribute(
                                                    'data-value')) !== '') {
                                            choicesItem.classList.remove('invalid');
                                            choicesItem.classList.add('valid');
                                        } else {
                                            choicesItem.classList.remove('valid');
                                            choicesItem.classList.add('invalid');
                                        }
                                    }
                                    //----- for multiple select only ----------
                                    if (multipleSelect) {
                                        if (choicesItem.getElementsByTagName('option')
                                            .length) {
                                            choicesItem.classList.remove('invalid');
                                            choicesItem.classList.add('valid');
                                        } else {
                                            choicesItem.classList.remove('valid');
                                            choicesItem.classList.add('invalid');
                                        }
                                    }

                                    //------ select end ---------------
                                }
                            });
                        };

                        validationItem.addEventListener('submit', function() {
                            selectFormValidation();
                        });
                        item.addEventListener('change', function() {
                            selectFormValidation();
                        });
                    });
                    return choices;
                });
            }
        };
        docReady(choicesInit);
    </script>
    @endpush
</div>
