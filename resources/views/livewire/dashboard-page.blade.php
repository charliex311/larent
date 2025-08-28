<div>
    @if(happyBirthDay())
    <!-- <div class="card mb-2">
        <div class="card-body fs-1">
            <div class="d-flex">
                <span class="fas fa-gift text-success fs-3"></span>
                <div class="flex-1 ms-2">
                    <a class="fw-semi-bold" href="javascript::void(0);">{{fullName(Auth::user()->id)}}</a> Happy birthday! “It's your special day — get out there and celebrate!”
                </div>
            </div>
        </div>
    </div> -->

    
    @endif

    <div class="row flex-between-center gy-2 my-3">
        <div class="col-auto"></div>
        <div class="col-auto">
            <form wire:submit="dateToDateSearch">
                <div class="input-group gap-1">
                    <input type="date" wire:model="from" class="form-control rounded shadow-none" />
                    <input type="date" wire:model="to" class="form-control rounded shadow-none" />
                    <button type="submit" class="btn btn-sm btn-outline-secondary rounded border-300 hover-border-secondary">
                        <span class="fa fa-search fs--1"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if(role_name(Auth::user()->id) == 'Administrator')
    <div class="row g-3 mb-3">
        <div class="col-sm-6 col-md-3 col-lg-3">
            <div class="card overflow-hidden" style="min-width: 12rem">
                <div class="bg-holder bg-card"
                    style="background-image:url({{asset('public/assets/img/icons/spot-illustrations/corner-1.png')}});">
                </div>
                <!--/.bg-holder-->

                <div class="card-body position-relative py-4">
                    <h6>Total Services</h6>
                    <div 
                    class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-warning" 
                    data-countup="{&quot;endValue&quot;:58.386,&quot;decimalPlaces&quot;:2,&quot;suffix&quot;:&quot;k&quot;}">{{ $totalServices }}</div>
                    <!-- <a class="fw-semi-bold fs--1 text-nowrap" href="javascript::volid(0);">See all</a> -->
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3 col-lg-3">
            <div class="card overflow-hidden" style="min-width: 12rem">
                <div class="bg-holder bg-card"
                    style="background-image:url({{asset('public/assets/img/icons/spot-illustrations/corner-1.png')}});">
                </div>
                <!--/.bg-holder-->

                <div class="card-body position-relative py-4">
                    <h6>Total Jobs</h6>
                    <div 
                    class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-warning" 
                    data-countup="{&quot;endValue&quot;:58.386,&quot;decimalPlaces&quot;:2,&quot;suffix&quot;:&quot;k&quot;}">{{ $totalJobs }}</div>
                    <!-- <a class="fw-semi-bold fs--1 text-nowrap" href="javascript::volid(0);">See all</a> -->
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3 col-lg-3">
            <div class="card overflow-hidden" style="min-width: 12rem">
                <div class="bg-holder bg-card"
                    style="background-image:url({{asset('public/assets/img/icons/spot-illustrations/corner-1.png')}});">
                </div>
                <!--/.bg-holder-->

                <div class="card-body position-relative py-4">
                    <h6>Total Employee Hours</h6>
                    <div 
                    class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-warning" 
                    data-countup="{&quot;endValue&quot;:58.386,&quot;decimalPlaces&quot;:2,&quot;suffix&quot;:&quot;k&quot;}">{{$totalEmployeeHours}}</div>
                    <!-- <a class="fw-semi-bold fs--1 text-nowrap" href="javascript::volid(0);">See all</a> -->
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3 col-lg-3">
            <div class="card overflow-hidden" style="min-width: 12rem">
                <div class="bg-holder bg-card"
                    style="background-image:url({{asset('public/assets/img/icons/spot-illustrations/corner-1.png')}});">
                </div>
                <!--/.bg-holder-->

                <div class="card-body position-relative py-4">
                    <h6>Total Employee Payments</h6>
                    <div 
                    class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-warning" 
                    data-countup="{&quot;endValue&quot;:58.386,&quot;decimalPlaces&quot;:2,&quot;suffix&quot;:&quot;k&quot;}">{{$totalEmployeePayments}}</div>
                    <!-- <a class="fw-semi-bold fs--1 text-nowrap" href="javascript::volid(0);">See all</a> -->
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3 col-lg-3">
            <div class="card overflow-hidden" style="min-width: 12rem">
                <div class="bg-holder bg-card"
                    style="background-image:url({{asset('public/assets/img/icons/spot-illustrations/corner-1.png')}});">
                </div>
                <!--/.bg-holder-->

                <div class="card-body position-relative py-4">
                    <h6>Total Customer Price</h6>
                    <div 
                    class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-warning" 
                    data-countup="{&quot;endValue&quot;:58.386,&quot;decimalPlaces&quot;:2,&quot;suffix&quot;:&quot;k&quot;}">{{$totalCustomerPrice}}</div>
                    <!-- <a class="fw-semi-bold fs--1 text-nowrap" href="javascript::volid(0);">See all</a> -->
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3 col-lg-3">
            <div class="card overflow-hidden" style="min-width: 12rem">
                <div class="bg-holder bg-card"
                    style="background-image:url({{asset('public/assets/img/icons/spot-illustrations/corner-1.png')}});">
                </div>
                <!--/.bg-holder-->

                <div class="card-body position-relative py-4">
                    <h6>Total Customer</h6>
                    <div 
                    class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-warning" 
                    data-countup="{&quot;endValue&quot;:58.386,&quot;decimalPlaces&quot;:2,&quot;suffix&quot;:&quot;k&quot;}">{{$totalCustomers}}</div>
                    <!-- <a class="fw-semi-bold fs--1 text-nowrap" href="javascript::volid(0);">See all</a> -->
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3 col-lg-3">
            <div class="card overflow-hidden" style="min-width: 12rem">
                <div class="bg-holder bg-card"
                    style="background-image:url({{asset('public/assets/img/icons/spot-illustrations/corner-1.png')}});">
                </div>
                <!--/.bg-holder-->

                <div class="card-body position-relative py-4">
                    <h6>Total Employee</h6>
                    <div 
                    class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-warning" 
                    data-countup="{&quot;endValue&quot;:58.386,&quot;decimalPlaces&quot;:2,&quot;suffix&quot;:&quot;k&quot;}">{{$totalEmployees}}</div>
                    <!-- <a class="fw-semi-bold fs--1 text-nowrap" href="javascript::volid(0);">See all</a> -->
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3 col-lg-3">
            <div class="card overflow-hidden" style="min-width: 12rem">
                <div class="bg-holder bg-card"
                    style="background-image:url({{asset('public/assets/img/icons/spot-illustrations/corner-1.png')}});">
                </div>
                <!--/.bg-holder-->

                <div class="card-body position-relative py-4">
                    <h6>Total Earnings</h6>
                    <div 
                    class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-warning" 
                    data-countup="{&quot;endValue&quot;:58.386,&quot;decimalPlaces&quot;:2,&quot;suffix&quot;:&quot;k&quot;}">{{$totalEarnings}}</div>
                    <!-- <a class="fw-semi-bold fs--1 text-nowrap" href="javascript::volid(0);">See all</a> -->
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3 col-lg-3">
            <div class="card overflow-hidden" style="min-width: 12rem">
                <div class="bg-holder bg-card"
                    style="background-image:url({{asset('public/assets/img/icons/spot-illustrations/corner-1.png')}});">
                </div>
                <!--/.bg-holder-->

                <div class="card-body position-relative py-4">
                    <h6>Total Invoices</h6>
                    <div 
                    class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-warning" 
                    data-countup="{&quot;endValue&quot;:58.386,&quot;decimalPlaces&quot;:2,&quot;suffix&quot;:&quot;k&quot;}">{{$totalInvoices}}</div>
                    <!-- <a class="fw-semi-bold fs--1 text-nowrap" href="javascript::volid(0);">See all</a> -->
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3 col-lg-3">
            <div class="card overflow-hidden" style="min-width: 12rem">
                <div class="bg-holder bg-card"
                    style="background-image:url({{asset('public/assets/img/icons/spot-illustrations/corner-1.png')}});">
                </div>
                <!--/.bg-holder-->

                <div class="card-body position-relative py-4">
                    <h6>Total Paid</h6>
                    <div 
                    class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-warning" 
                    data-countup="{&quot;endValue&quot;:58.386,&quot;decimalPlaces&quot;:2,&quot;suffix&quot;:&quot;k&quot;}">{{$totalPaid}}</div>
                    <!-- <a class="fw-semi-bold fs--1 text-nowrap" href="javascript::volid(0);">See all</a> -->
                </div>
            </div>
        </div>
    </div>
    @endif

    @if(role_name(Auth::user()->id) == 'Employee')
    <div class="row g-3 mb-3">
        <div class="col-sm-6 col-md-3 col-lg-3">
            <div class="card overflow-hidden" style="min-width: 12rem">
                <div class="bg-holder bg-card"
                    style="background-image:url({{asset('public/assets/img/icons/spot-illustrations/corner-1.png')}});">
                </div>
                <!--/.bg-holder-->

                <div class="card-body position-relative py-4">
                    <h6>Pending Jobs</h6>
                    <div 
                    class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-warning" 
                    data-countup="{&quot;endValue&quot;:58.386,&quot;decimalPlaces&quot;:2,&quot;suffix&quot;:&quot;k&quot;}">{{pendingJob()}}</div>
                    <!-- <a class="fw-semi-bold fs--1 text-nowrap" href="javascript::volid(0);">See all</a> -->
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3 col-lg-3">
            <div class="card overflow-hidden" style="min-width: 12rem">
                <div class="bg-holder bg-card"
                    style="background-image:url({{asset('public/assets/img/icons/spot-illustrations/corner-2.png')}});">
                </div>
                <!--/.bg-holder-->
                <div class="card-body position-relative py-4">
                    <h6>Completed Jobs</h6>
                    <div 
                    class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-info"
                    data-countup="{&quot;endValue&quot;:23.434,&quot;decimalPlaces&quot;:2,&quot;suffix&quot;:&quot;k&quot;}">{{completedJob()}}</div>
                    <!-- <a class="fw-semi-bold fs--1 text-nowrap" href="javascript::volid(0);">All orders</a> -->
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3 col-lg-3">
            <div class="card overflow-hidden" style="min-width: 12rem">
                <div class="bg-holder bg-card"
                    style="background-image:url({{asset('public/assets/img/icons/spot-illustrations/corner-3.png')}});">
                </div>
                <!--/.bg-holder-->

                <div class="card-body position-relative py-4">
                    <h6>Hourly Rate</h6>
                    <div 
                    class="display-4 fs-4 mb-2 fw-normal font-sans-serif"
                    data-countup="{&quot;endValue&quot;:43594,&quot;prefix&quot;:&quot;$&quot;}">{{HourlyRateWithSign()}}</div>
                    <!-- <a class="fw-semi-bold fs--1 text-nowrap" href="javascript::volid(0);">Statistics</a> -->
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3 col-lg-3">
            <div class="card overflow-hidden" style="min-width: 12rem">
                <div class="bg-holder bg-card"
                    style="background-image:url({{asset('public/assets/img/icons/spot-illustrations/corner-4.png')}});">
                </div>
                <!--/.bg-holder-->

                <div class="card-body position-relative py-4">
                    <h6>Total Paid</h6>
                    <div 
                    class="display-4 fs-4 mb-2 fw-normal font-sans-serif"
                    data-countup="{&quot;endValue&quot;:43594,&quot;prefix&quot;:&quot;$&quot;}">{{$totalPaid}}</div>
                    <!-- <a class="fw-semi-bold fs--1 text-nowrap" href="javascript::volid(0);">Statistics</a> -->
                </div>
            </div>
        </div>
    </div>
    @endif

    @if(role_name(Auth::user()->id) == 'Customer')
    <div class="row g-3 mb-3">
        <div class="col-sm-6 col-md-3 col-lg-3">
            <div class="card overflow-hidden" style="min-width: 12rem">
                <div class="bg-holder bg-card"
                    style="background-image:url({{asset('public/assets/img/icons/spot-illustrations/corner-1.png')}});">
                </div>
                <!--/.bg-holder-->

                <div class="card-body position-relative py-4">
                    <h6>Total Services</h6>
                    <div 
                    class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-warning" 
                    data-countup="{&quot;endValue&quot;:58.386,&quot;decimalPlaces&quot;:2,&quot;suffix&quot;:&quot;k&quot;}">{{$totalServices}}</div>
                    <!-- <a class="fw-semi-bold fs--1 text-nowrap" href="javascript::volid(0);">See all</a> -->
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3 col-lg-3">
            <div class="card overflow-hidden" style="min-width: 12rem">
                <div class="bg-holder bg-card"
                    style="background-image:url({{asset('public/assets/img/icons/spot-illustrations/corner-2.png')}});">
                </div>
                <!--/.bg-holder-->
                <div class="card-body position-relative py-4">
                    <h6>Total Invoice</h6>
                    <div 
                    class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-info"
                    data-countup="{&quot;endValue&quot;:23.434,&quot;decimalPlaces&quot;:2,&quot;suffix&quot;:&quot;k&quot;}">{{$totalInvoices}}</div>
                    <!-- <a class="fw-semi-bold fs--1 text-nowrap" href="javascript::volid(0);">All orders</a> -->
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3 col-lg-3">
            <div class="card overflow-hidden" style="min-width: 12rem">
                <div class="bg-holder bg-card"
                    style="background-image:url({{asset('public/assets/img/icons/spot-illustrations/corner-2.png')}});">
                </div>
                <!--/.bg-holder-->
                <div class="card-body position-relative py-4">
                    <h6>Total Deposit</h6>
                    <div 
                    class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-info"
                    data-countup="{&quot;endValue&quot;:23.434,&quot;decimalPlaces&quot;:2,&quot;suffix&quot;:&quot;k&quot;}">{{$totalDeposit}}</div>
                    <!-- <a class="fw-semi-bold fs--1 text-nowrap" href="javascript::volid(0);">All orders</a> -->
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3 col-lg-3">
            <div class="card overflow-hidden" style="min-width: 12rem">
                <div class="bg-holder bg-card"
                    style="background-image:url({{asset('public/assets/img/icons/spot-illustrations/corner-2.png')}});">
                </div>
                <!--/.bg-holder-->
                <div class="card-body position-relative py-4">
                    <h6>Available Balance</h6>
                    <div 
                    class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-info"
                    data-countup="{&quot;endValue&quot;:23.434,&quot;decimalPlaces&quot;:2,&quot;suffix&quot;:&quot;k&quot;}">{{$availableBalance}}</div>
                    <!-- <a class="fw-semi-bold fs--1 text-nowrap" href="javascript::volid(0);">All orders</a> -->
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="row justify-content-center" wire:ignore>
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-body pe-xxl-0">
                    <div 
                        class="echart-line-total-sales-ecommerce" 
                        data-echart-responsive="true"
                        data-options='{"optionOne":"ecommerceLastMonth","optionTwo":"ecommercePrevYear"}'>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @can('pop_ups-visible')
        @if(globalPopID() && $showPopUp == false)
        <div class="modal fade" id="window-pop-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content position-relative">
                    <div class="position-absolute top-0 end-0 mt-2 me-2 z-1">
                        <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" type="button" wire:click="hidePopUps({{globalPopID()}})" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0">
                        <div class="rounded-top-3 py-3 ps-4 pe-6 bg-white">
                            <h4 class="mb-1" id="modalExampleDemoLabel" style="font-family: 'Open Sans', sans-serif;"> {{ $popup->title }} </h4>
                        </div>
                        <div class="p-4 pb-0">
                            <div class="text-center">
                                <img class="d-block mx-auto mb-4" 
                                src="{{asset('public/storage').'/'.$popup->image}}" 
                                alt="shield" width="100%">
                                <i class="fs-1 py-3" style="font-family: 'Open Sans', sans-serif;">{{ $popup->description }}</i>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal" wire:click="hidePopUps({{globalPopID()}})">Close</button>
                        <button class="btn btn-primary" type="button" wire:click="hidePopUps({{globalPopID()}})"> Okay </button>
                    </div>
                </div>
            </div>
        </div>
        @endif
    @endcan


    @if(happyBirthDay())

    <div class="modal fade" id="birthday-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width: 500px">
            <div class="modal-content position-relative">
            <div class="position-absolute top-0 end-0 mt-2 me-2 z-1">
                <button wire:click="birthDayModalHide" class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base " data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-5 text-center">
                <img src="{{asset('public/assets/img/icons/spot-illustrations/41.png')}}" alt="Happy birthday" style="width: 60%">
                <div class="flex-1 ms-2">
                    <a class="fw-semi-bold" href="javascript::void(0);">Hey, {{fullName(Auth::user()->id)}}</a> Happy birthday! <br>
                    <h4>“It's your special day — get out there and celebrate!”</h4>
                </div>
            </div>
            </div>
        </div>
    </div>

    @endif

    

    @push('js')
    <script type="text/javascript" data-navigate-track >

        document.addEventListener('livewire:navigated', () => { 
            function totalSalesEcommerce() {
                var ECHART_LINE_TOTAL_SALES_ECOMM = '.echart-line-total-sales-ecommerce';
                var $echartsLineTotalSalesEcomm = document.querySelector(ECHART_LINE_TOTAL_SALES_ECOMM);
                var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    
                function getFormatter(params) {
                    return params.map(function(_ref18) {
                        var value = _ref18.value,
                            borderColor = _ref18.borderColor,
                            seriesName = _ref18.seriesName;
                        return "<span class= \"fas fa-circle\" style=\"color: ".concat(borderColor,
                            "\"></span>\n    <span class='text-800'>").concat(seriesName === 'option-1' ?
                            'option-1' : 'option-2', ": ").concat(value, "</span>");
                    }).join('<br/>');
                }
                if ($echartsLineTotalSalesEcomm) {
                    // Get options from data attribute
                    var userOptions = utils.getData($echartsLineTotalSalesEcomm, 'options');
                    var TOTAL_SALES_LAST_MONTH = "#".concat(userOptions.optionOne);
                    var TOTAL_SALES_PREVIOUS_YEAR = "#".concat(userOptions.optionTwo);
                    var totalSalesLastMonth = document.querySelector(TOTAL_SALES_LAST_MONTH);
                    var totalSalesPreviousYear = document.querySelector(TOTAL_SALES_PREVIOUS_YEAR);
                    var chart = window.echarts.init($echartsLineTotalSalesEcomm);
                    var getDefaultOptions = function getDefaultOptions() {
                        return {
                            color: utils.getGrays()['100'],
                            tooltip: {
                                trigger: 'axis',
                                padding: [5, 7],
                                backgroundColor: utils.getGrays()['300'],
                                borderColor: utils.getGrays()['600'],
                                textStyle: {
                                    color: utils.getColors().dark
                                },
                                borderWidth: 1,
                                formatter: function formatter(params) {
                                    return getFormatter(params);
                                },
                                transitionDuration: 0,
                                position: function position(pos, params, dom, rect, size) {
                                    return getPosition(pos, params, dom, rect, size);
                                }
                            },
                            legend: {
                                data: ['option-1', 'option-2'],
                                show: false
                            },
                            xAxis: {
                                type: 'category',
                                data: [
                                  '10', 
                                  '12', 
                                  '3', 
                                  '4', 
                                  '5',
                                  '6', 
                                  '7', 
                                  '8', 
                                  '9', 
                                  '12',
                                  '13', 
                                  '15'
                                ],
                                boundaryGap: false,
                                axisPointer: {
                                    lineStyle: {
                                        color: utils.getColor('gray-300'),
                                        type: 'dashed'
                                    }
                                },
                                splitLine: {
                                    show: false
                                },
                                axisLine: {
                                    lineStyle: {
                                        // color: utils.getGrays()['300'],
                                        color: utils.rgbaColor('#000', 0.01),
                                        type: 'dashed'
                                    }
                                },
                                axisTick: {
                                    show: false
                                },
                                axisLabel: {
                                    color: utils.getColor('gray-800'),
                                    formatter: function formatter(value) {
                                        var date = new Date(value);
                                        return "".concat(months[date.getMonth()], " ").concat(date.getDate());
                                    },
                                    margin: 10
                                    // showMaxLabel: false
                                }
                            },
    
                            yAxis: {
                                type: 'value',
                                axisPointer: {
                                    show: false
                                },
                                splitLine: {
                                    lineStyle: {
                                        color: utils.getColor('gray-300'),
                                        type: 'dashed'
                                    }
                                },
                                boundaryGap: false,
                                axisLabel: {
                                    show: true,
                                    color: utils.getColor('gray-400'),
                                    margin: 15
                                },
                                axisTick: {
                                    show: false
                                },
                                axisLine: {
                                    show: false
                                }
                            },
                            series: [{
                                name: 'option-1',
                                type: 'line',
                                data: [
                                    '66',
                                    '85',
                                    '125',
                                    '108',
                                    '163',
                                    '353',
                                    '918',
                                    '219',
                                    '99',
                                    '182',
                                    '610',
                                    '211'
                                ],
                                lineStyle: {
                                    color: utils.getColor('success')
                                },
                                itemStyle: {
                                    borderColor: utils.getColor('success'),
                                    borderWidth: 2
                                },
                                symbol: 'circle',
                                symbolSize: 15,
                                hoverAnimation: true,
                                areaStyle: {
                                    color: {
                                        type: 'linear',
                                        x: 0,
                                        y: 0,
                                        x2: 0,
                                        y2: 1,
                                        colorStops: [{
                                            offset: 0,
                                            color: utils.rgbaColor(utils.getColor('success'), 0.2)
                                        }, {
                                            offset: 1,
                                            color: utils.rgbaColor(utils.getColor('success'), 0)
                                        }]
                                    }
                                }
                            }, {
                                name: 'option-2',
                                type: 'line',
                                data: [
                                    '22',
                                    '16',
                                    '15',
                                    '8',
                                    '14',
                                    '6',
                                    '7',
                                    '10',
                                    '11',
                                    '15',
                                    '12',
                                    '3'
                                ],
                                lineStyle: {
                                    color: utils.rgbaColor(utils.getColor('danger'), 0.3)
                                },
                                itemStyle: {
                                    borderColor: utils.rgbaColor(utils.getColor('danger'), 0.6),
                                    borderWidth: 2
                                },
                                symbol: 'circle',
                                symbolSize: 15,
                                hoverAnimation: true
                            }],
                            grid: {
                                right: '18px',
                                left: '40px',
                                bottom: '15%',
                                top: '5%'
                            }
                        };
                    };
                    echartSetOption(chart, userOptions, getDefaultOptions);
                    totalSalesLastMonth.addEventListener('click', function() {
                        chart.dispatchAction({
                            type: 'legendToggleSelect',
                            name: 'option-1'
                        });
                    });
                    totalSalesPreviousYear.addEventListener('click', function() {
                        chart.dispatchAction({
                            type: 'legendToggleSelect',
                            name: 'option-2'
                        });
                    });
                }
            };
    
            totalSalesEcommerce();            
        });

        document.addEventListener('DOMContentLoaded', () => {

            function totalSalesEcommerce() {
                var ECHART_LINE_TOTAL_SALES_ECOMM = '.echart-line-total-sales-ecommerce';
                var $echartsLineTotalSalesEcomm = document.querySelector(ECHART_LINE_TOTAL_SALES_ECOMM);
                var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    
                function getFormatter(params) {
                    return params.map(function(_ref18) {
                        var value = _ref18.value,
                            borderColor = _ref18.borderColor,
                            seriesName = _ref18.seriesName;
                        return "<span class= \"fas fa-circle\" style=\"color: ".concat(borderColor,
                            "\"></span>\n    <span class='text-800'>").concat(seriesName === 'option-1' ?
                            'option-1' : 'option-2', ": ").concat(value, "</span>");
                    }).join('<br/>');
                }
                if ($echartsLineTotalSalesEcomm) {
                    // Get options from data attribute
                    var userOptions = utils.getData($echartsLineTotalSalesEcomm, 'options');
                    var TOTAL_SALES_LAST_MONTH = "#".concat(userOptions.optionOne);
                    var TOTAL_SALES_PREVIOUS_YEAR = "#".concat(userOptions.optionTwo);
                    var totalSalesLastMonth = document.querySelector(TOTAL_SALES_LAST_MONTH);
                    var totalSalesPreviousYear = document.querySelector(TOTAL_SALES_PREVIOUS_YEAR);
                    var chart = window.echarts.init($echartsLineTotalSalesEcomm);
                    var getDefaultOptions = function getDefaultOptions() {
                        return {
                            color: utils.getGrays()['100'],
                            tooltip: {
                                trigger: 'axis',
                                padding: [5, 7],
                                backgroundColor: utils.getGrays()['300'],
                                borderColor: utils.getGrays()['600'],
                                textStyle: {
                                    color: utils.getColors().dark
                                },
                                borderWidth: 1,
                                formatter: function formatter(params) {
                                    return getFormatter(params);
                                },
                                transitionDuration: 0,
                                position: function position(pos, params, dom, rect, size) {
                                    return getPosition(pos, params, dom, rect, size);
                                }
                            },
                            legend: {
                                data: ['option-1', 'option-2'],
                                show: false
                            },
                            xAxis: {
                                type: 'category',
                                data: [
                                    '10', 
                                    '12', 
                                    '3', 
                                    '4', 
                                    '5',
                                    '6', 
                                    '7', 
                                    '8', 
                                    '9', 
                                    '12',
                                    '13', 
                                    '15'
                                ],
                                boundaryGap: false,
                                axisPointer: {
                                    lineStyle: {
                                        color: utils.getColor('gray-300'),
                                        type: 'dashed'
                                    }
                                },
                                splitLine: {
                                    show: false
                                },
                                axisLine: {
                                    lineStyle: {
                                        // color: utils.getGrays()['300'],
                                        color: utils.rgbaColor('#000', 0.01),
                                        type: 'dashed'
                                    }
                                },
                                axisTick: {
                                    show: false
                                },
                                axisLabel: {
                                    color: utils.getColor('gray-800'),
                                    formatter: function formatter(value) {
                                        var date = new Date(value);
                                        return "".concat(months[date.getMonth()], " ").concat(date.getDate());
                                    },
                                    margin: 10
                                    // showMaxLabel: false
                                }
                            },
    
                            yAxis: {
                                type: 'value',
                                axisPointer: {
                                    show: false
                                },
                                splitLine: {
                                    lineStyle: {
                                        color: utils.getColor('gray-300'),
                                        type: 'dashed'
                                    }
                                },
                                boundaryGap: false,
                                axisLabel: {
                                    show: true,
                                    color: utils.getColor('gray-400'),
                                    margin: 15
                                },
                                axisTick: {
                                    show: false
                                },
                                axisLine: {
                                    show: false
                                }
                            },
                            series: [{
                                name: 'option-1',
                                type: 'line',
                                data: [
                                    '66',
                                    '85',
                                    '125',
                                    '108',
                                    '163',
                                    '353',
                                    '918',
                                    '219',
                                    '99',
                                    '182',
                                    '610',
                                    '211'
                                ],
                                lineStyle: {
                                    color: utils.getColor('success')
                                },
                                itemStyle: {
                                    borderColor: utils.getColor('success'),
                                    borderWidth: 2
                                },
                                symbol: 'circle',
                                symbolSize: 15,
                                hoverAnimation: true,
                                areaStyle: {
                                    color: {
                                        type: 'linear',
                                        x: 0,
                                        y: 0,
                                        x2: 0,
                                        y2: 1,
                                        colorStops: [{
                                            offset: 0,
                                            color: utils.rgbaColor(utils.getColor('success'), 0.2)
                                        }, {
                                            offset: 1,
                                            color: utils.rgbaColor(utils.getColor('success'), 0)
                                        }]
                                    }
                                }
                            }, {
                                name: 'option-2',
                                type: 'line',
                                data: [
                                    '22',
                                    '16',
                                    '15',
                                    '8',
                                    '14',
                                    '6',
                                    '7',
                                    '10',
                                    '11',
                                    '15',
                                    '12',
                                    '3'
                                ],
                                lineStyle: {
                                    color: utils.rgbaColor(utils.getColor('danger'), 0.3)
                                },
                                itemStyle: {
                                    borderColor: utils.rgbaColor(utils.getColor('danger'), 0.6),
                                    borderWidth: 2
                                },
                                symbol: 'circle',
                                symbolSize: 15,
                                hoverAnimation: true
                            }],
                            grid: {
                                right: '18px',
                                left: '40px',
                                bottom: '15%',
                                top: '5%'
                            }
                        };
                    };
                    echartSetOption(chart, userOptions, getDefaultOptions);
                    totalSalesLastMonth.addEventListener('click', function() {
                        chart.dispatchAction({
                            type: 'legendToggleSelect',
                            name: 'option-1'
                        });
                    });
                    totalSalesPreviousYear.addEventListener('click', function() {
                        chart.dispatchAction({
                            type: 'legendToggleSelect',
                            name: 'option-2'
                        });
                    });
                }
            };
        
            totalSalesEcommerce(); 
        });


    </script>


    <script>
        $(document).ready(function(){

            var DateOfBirth = {{happyBirthDay()}};
            var isShown     = {{isBirthDaySession()}};
            if (DateOfBirth) {
                if (isShown) {
                    $('#birthday-modal').modal('show');
                }
            }
        });
    </script>
    @endpush
</div>