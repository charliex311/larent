<div>
    <div class="card mb-3 shadow-sm">
        <div class="card-body">
            <div class="row justify-content-between align-items-center">
                <div class="col-md">
                    <h5 class="mb-2 mb-md-0">Invocie Number : {{invoice_prefix($row->user_id).$row->invoice_number}}</h5>
                </div>
                <div class="col-auto">
                    <a href="/admin/customer-pdf-download?id={{$row->id}}" target="_self" class="btn btn-info btn-sm me-1 mb-2 mb-sm-0" >
                        <span class="fas fa-arrow-down me-1"> </span>Download (.pdf)
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-3 shadow-sm bgLogo" id="contentToPrint">
        <div class="card-body">
            <div class="row align-items-center text-center mb-3">
            <div class="col-sm-6 text-sm-start"><img src="{{asset('public/logo.png')}}" alt="invoice" width="150" /></div>
            <div class="col text-sm-end mt-3 mt-sm-0">
                <h2 class="mb-3"></h2>
                <p class="fs--1 mb-0"> </p>
            </div>
            <div class="col-12">
                <hr />
            </div>
            </div>
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="text-500"></h6>
                    <h5>{{fullName($row->user_id)}}</h5>
                    <p class="fs--1"><b>{{$row->billing_address}}</b><br /></p>
                </div>
                <div class="col-sm-auto ms-auto">
                    <div class="table-responsive">
                    <table class="table table-sm table-borderless fs--1">
                        <tbody>
                        <tr>
                            <th class="text-sm-end">{{ parseDateOnly($row->created_at) }}</th>
                        </tr>
                        <tr>
                            <th class="text-sm-end">Rechnungsnummer : {{invoice_prefix($row->user_id).$row->invoice_number}}</th>
                        </tr>
                        <tr>
                            <th class="text-sm-end">Leistungsdatum: {{ parseDateOnly($row->start_date) . ' - ' .  parseDateOnly($row->end_date) }}</th>
                        </tr>
                        <tr class="alert alert-success fw-bold text-sm-end">
                            <!-- <th class="">Amount Due : {{ $row->total_price. ' ' . $currency }}</th> -->
                        </tr>
                        </tbody>
                    </table>
                    </div>
                </div>
                <h5 class="px-5 py-4 text-center"> {{invoiceText(1)}} </h5>
            </div>
            <div class="table-responsive scrollbar mt-4 fs--1">
                <table class="table border-bottom">
                    <thead data-bs-theme="light">
                    <tr class="text-dark border border-1">
                        <th class="border-0">Nr</th>
                        <th class="border-0 text-center">Service</th>
                        <th class="border-0 text-center">Date</th>
                        <th class="border-0 text-center">Unit</th>
                        <th class="border-0 text-center">Customer Hour</th>
                        <th class="border-0 text-center">Service Price</th>
                        <th class="border-0 text-center">Customer Price</th>
                        <th class="border-0 text-end">Tax</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php $counter = 0;  @endphp
                    @foreach($jobs as $job)
                    <tr>
                        <td class="fs-0 py-1">{{ $counter+=1 . $job->service_id}}</td>
                        <td class="text-center service fs-0 py-1">{{ serviceName($job->service_id) }}</td>
                        <td class="text-center date fs-0 py-1">{{ parseDateOnly($job->job_date) }}</td>
                        <td class="text-center unit fs-0 py-1">hour</td>
                        <td class="text-center customer_hour fs-0 py-1">{!! getTotalHourReadable($job->id) !!}</td>
                        <td class="text-center service_price fs-0 py-1">{{ servicePrice($job->id).' '.$currency }}</td>
                        <td class="text-center customer_price fs-0 py-1">{{calculateTotalBillAmount(getTotalHour($job->id), $job->hourly_rate, $job->id).' '.$currency}}</td>
                        <td class="align-middle tax py-1 fs-0 text-end">{{ calculateTaxUsingCustomerPrice($job->id) . ' ' . $currency . ' ('. globalTax().'%)' }}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                
            </div>
            <div class="row justify-content-end">
                <div class="col-auto">
                    <table class="table table-sm table-borderless fs--1 text-end">
                    <tr>
                        <th class="text-900">Netto</th>
                        <td class="fw-semi-bold"> : {{ $row->total_customer_price . ' ' . $currency }} </td>
                    </tr>
                    <tr>
                        <th class="text-900">zzgl. (19%) MwSt</th>
                        <td class="fw-semi-bold"> : {{ $row->total_tax . ' ' . $currency }} </td>
                    </tr>
                    <tr class="border-top border-top-2 fw-bolder text-900 ">
                        <th class="text-900 fs-1"><b class="@if($row->status == 'paid') text-success @elseif($row->status == 'unpaid') text-danger @endif">Brutto</b></th>
                        <td class="fw-semi-bold @if($row->status == 'paid') text-success @elseif($row->status == 'unpaid') text-danger @endif fs-1"><b> : {{ $row->total_price . ' ' . $currency }}</b> </td>
                    </tr>
                    </table>

                </div>
                <h5 class="px-5 py-4 text-center">Bitte überweisen die Endsumme von <b class="@if($row->status == 'paid') text-success @elseif($row->status == 'unpaid') text-danger @endif"> {{ $row->total_price . ' ' . $currency }} </b> innerhalb von 3 Tagen mit dem Verwendungszweck. 
                <br> Rechnungsnummer: <b class="@if($row->status == 'paid') text-success @elseif($row->status == 'unpaid') text-danger @endif">{{invoice_prefix($row->user_id).$row->invoice_number}}</b></h5>
            </div>
        </div>
        <div class="card-footer bg-light">
            <div class="row justify-content-between gap-1 ">
                <div class="col-lg-2 fs--1">
                    {{$company->company}} <br />
                    Postanschrift <br />
                    LÃ¶wenbergerstr 2 <br />
                    {{$company->company_address}} <br />
                </div>
                <div class="col-lg-2 fs--1">
                    10315 Berlin Germany <br />
                    <a href="tel:015757010977">015757010977</a><br />
                    E-Mail <br />
                    <a href="mailto:{{$company->company_email}}">{{$company->company_email}}</a> <br />
                </div>
                <div class="col-lg-2 fs--1">
                    Webseite <br />
                    <a target="_blank" href="{{$company->website}}">{{ preg_replace('/\.+/', '.', str_replace(['https://', 'http://', 'www'], 'www.', companyWebsite())) }}</a> <br />
                    Steuernummer <br />
                    132/571/00584 <br />
                </div>
                <div class="col-lg-2 fs--1">
                    USt-IdNr <br />
                    DE301503988 <br />
                    Betriebsnummer <br />
                    969504433 <br />
                </div>
                <div class="col-lg-2 fs--1">
                    Bankverbindung <br />
                    N26 <br />
                    NTSBDEB1XXX <br />
                    DE04100110012626447499 <br />
                </div>
            </div>
        </div>
    </div>

    @push('css')
    <style>
        .bgLogo {
            background-image: url({{asset('public/invoice-bg.png')}});
            background-repeat: no-repeat;
            background-size: contain;
            background-color: white !important;
            background-position: center;
        }
    </style>
    @endpush
    
</div>
