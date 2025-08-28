<div>
    <div class="row mt-4">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <form wire:submit.prevent="saveChanges">
                <div class="card shadow-sm">
                    <div class="card-header bg-light"><h4>Create</h4></div>
                    <div class="card-body row justify-content-start">
                        <div class="col-sm-12 col-md-12 col-lg-12">
                            
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div  wire:ignore>
                                        <label class="fs-0" for="customer"><b>Customer</b></label>
                                        <select class="form-select form-select-lg js-choice" id="customer" size="1" wire:model.live="customer" >
                                            <option >...</option>
                                            @foreach($customers as $cus)
                                            <option value="{{ $cus->id }}">{{$cus->first_name.' '.$cus->last_name}} {{$cus->customer_type == 'host' ? ' ('.$cus->customer_type.')' : '('.$cus->customer_type.')'}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('customer') <small class="text-danger"><b>{{$message}}</b></small> @enderror
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <label class="form-label fs-0" for="employee"><b>Employee:</b></label>
                                    <div wire:ignore>
                                        <select class="form-select form-select-lg js-choice" id="employee" size="1" wire:model="employee">
                                            <option >...</option>
                                            @foreach($employees as $emp)
                                            <option value="{{$emp->id}}">{{ employeeName($emp->id) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('employee') <small class="text-danger"><b>{{$message}}</b></small> @enderror
                                </div>
                            </div>

                            <div class="row mt-2" wire:ignore.self>                            
                                @php $serviceNumber=0; @endphp
                                @if(count($servicesArray) != 0)
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    @foreach($servicesArray as $key0 => $titem0)
                                    <div class="p-5 border mb-1">
                                        <div class="row flex-between-center mb-3">
                                            <div class="col-auto"><span class="badge rounded-pill bg-primary fs-0">Service No: {{ $serviceNumber+=1 }}</span></div>
                                            <div class="col-auto"><button class="btn-close btn-close-dark text-danger" type="button" aria-label="Close" wire:click="removeFromServicesArray({{$key0}})"></button></div>
                                        </div>
                                        <div class="row mb-2" x-show="$wire.customer_type === 'host'" >
                                            <div class="col-sm-12 col-md-6 col-lg-6" id="">
                                                <label class="fs-0" for="checkIn"><b>Check-In</b></label>

                                                <div class="input-group">
                                                    <input 
                                                    class="form-control @error('servicesArray.' . $key0 . '.checkin') is-invalid @enderror" 
                                                    id="checkIn" 
                                                    type="datetime-local" 
                                                    placeholder="hh:mm dd/mm/yyyy"
                                                    wire:model="servicesArray.{{$key0}}.checkin" style="z-index: 0;" />
                                                </div>
                                                
                                                @error('checkin') <small class="text-danger"><b>{{$message}}</b></small> @enderror
                                            </div>
                                            <div class="col-sm-12 col-md-6 col-lg-6" >
                                                <label class="fs-0" for="checkOut"><b>Check-Out</b></label>
                                                <div class="input-group">
                                                    <input 
                                                    class="form-control @error('servicesArray.' . $key0 . '.checkout') is-invalid @enderror" 
                                                    id="checkOut" 
                                                    type="datetime-local" 
                                                    wire:model="servicesArray.{{$key0}}.checkout" 
                                                    placeholder="hh:mm dd/mm/yyyy" style="z-index: 0;" />
                                                </div>
                                                @error('checkout') <small class="text-danger"><b>{{$message}}</b></small> @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-2" x-show="$wire.customer_type != 'host'" >
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <label class="fs-0" for="job_date"><b>Job Date</b></label>
                                                <div class="input-group">
                                                    <input 
                                                        class="form-control @error('servicesArray.' . $key0 . '.job_date') is-invalid @enderror" 
                                                        id="job_date" 
                                                        type="datetime-local" 
                                                        placeholder="hh:mm dd/mm/yyyy"
                                                        wire:model.live="servicesArray.{{$key0}}.job_date" style="z-index: 0;" />
                                                    @error('checkout') <small class="text-danger"><b>{{$message}}</b></small> @enderror
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                @if(getDateName($servicesArray[$key0]['job_date']))
                                                <div class="card" style="margin-top: 25px;width: 45%;">
                                                    <div class="bg-holder d-none d-lg-block bg-card" style="background-image:url({{ asset('public/assets/img/icons/spot-illustrations/corner-4.png')}});"></div>
                                                    <div class="card-body position-relative p-2">
                                                    <div class="row">
                                                        <div class="col-lg-8"><h2 class="fs-1 text-capitalize">{{getDateName($servicesArray[$key0]['job_date'])}}</h2></div>
                                                    </div>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <label for="" class="fs-0"><b>Service Name</b></label>
                                                    <select 
                                                    class="form-control @error('servicesArray.' . $key0 . '.service_id') is-invalid @enderror" 
                                                    id="service_id" 
                                                    wire:model.live="servicesArray.{{$key0}}.service_id" 
                                                    wire:change="updateAddress({{$key0}})">
                                                        <option value="">Select Service</option>
                                                        @if(count($services) > 0)
                                                            @php $dayName = getDateName($servicesArray[$key0]['job_date']); @endphp
                                                            @foreach( $dayName == 'sunday' ? $services->where('regularity', 'sunday') : $services->where('regularity', '!=', 'sunday') as $serv)
                                                            <option value="{{$serv->id}}">{{$serv->title.' ('.$serv->regularity.')'}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <label for="" class="fs-0"><b>Address</b></label>
                                                    <select 
                                                    wire:model="servicesArray.{{$key0}}.job_address" 
                                                    class="form-control form-control-lg fs-0 @error('servicesArray.' . $key0 . '.job_address') is-invalid @enderror" 
                                                    id="">
                                                        <option value=""></option>
                                                        @isset($this->servicesArray[$key0]['service_id'])
                                                            @foreach($addresses as $addressdata)
                                                                <option value="{{ $addressdata[0]['address'] }}">
                                                                    <span class="text-capitalize">{{$addressdata[0]['address_for'].' : '.$addressdata[0]['address']}}</span>
                                                                </option>
                                                            @endforeach
                                                        @endisset
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <label class="fs-0" for=""><b>Total Task Hours:</b></label>
                                                <input 
                                                type="number" 
                                                step="any" 
                                                wire:model="servicesArray.{{$key0}}.total_task_hour" 
                                                id="total_task_hour" 
                                                class="form-control @error('servicesArray.' . $key0 . '.total_task_hour') is-invalid @enderror" 
                                                placeholder="Enter Hours">
                                                @error('total_task_hour') <small class="text-danger"><b>{{$message}}</b></small> @enderror
                                            </div>
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <label class="fs-0" for="recurrence-type"><b>Recurrence type:</b></label>
                                                <select id="recurrence-type" class="form-control @error('servicesArray.' . $key0 . '.recurrence_type') is-invalid @enderror" wire:model="servicesArray.{{$key0}}.recurrence_type">
                                                    <option value="none">None</option>
                                                    <option value="one time">One Time</option>
                                                    <option value="daily">Daily</option>
                                                    <option value="weekly">Weekly</option>
                                                    <option value="monthly">Monthly</option>
                                                    <option value="yearly">Yearly</option>
                                                </select>
                                                @error('recurrence_type') <small class="text-danger"><b>{{$message}}</b></small> @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <label class="form-label fs-0"><b>Number of People:</b></label>
                                                <input type="text" wire:model="servicesArray.{{$key0}}.number_of_people" placeholder="Enter Number of People" class="form-control /">
                                                @error('number_of_people') <small class="text-danger"><b>{{$message}}</b></small> @enderror
                                            </div>
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <label class="form-label fs-0"><b>Code from the door:</b></label>
                                                <input type="text" wire:model="servicesArray.{{$key0}}.code_from_the_door" placeholder="Enter Code from the door" class="form-control" />
                                                @error('code_from_the_door') <small class="text-danger"><b>{{$message}}</b></small> @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <label for="job_notes"><b>Job Notes</b></label>
                                                <textarea 
                                                wire:model="servicesArray.{{$key0}}.job_notes" 
                                                placeholder="Enter Job Notes"
                                                id="job_notes" 
                                                cols="30" 
                                                rows="3" 
                                                class="form-control"></textarea>
                                            </div>
                                        </div>
                                        
                                        @foreach($optionalproducts as $oppro)
                                        <div class="form-check form-check-inline" style="margin-right: 0px">
                                            <input 
                                            class="form-check-input" 
                                            id="inlineCheckbox{{$key0}}{{$oppro->id}}" 
                                            wire:model="servicesArray.{{$key0}}.optionals" 
                                            type="checkbox" 
                                            value="{{$oppro->id}}" />
                                            <label class="form-check-label" for="inlineCheckbox{{$key0}}{{$oppro->id}}">{{$oppro->name}} {{'('.$oppro->add_on_price.''.$oppro->currency.')' ?? ''}}</label>
                                        </div>
                                        @endforeach
                                    </div>
                                    @endforeach
                                </div>
                                @endif
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <button class="btn btn-sm btn-primary rounded-pill" type="button" wire:click.prevent="addServices">
                                        <span class="fe fe-plus-circle"></span>&nbsp; {{ count($servicesArray) == 0 ? 'Add Service' : 'Add Another Service' }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end"><button class="btn btn-primary px-4" type="submit">Assign Job</button></div>
                </div>
            </form>
        </div>
    </div>


    

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
