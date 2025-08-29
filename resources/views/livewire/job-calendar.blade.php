<div>
    @push('css')
    <link href="{{ config('app.cdn_root') }}/public/vendors/fullcalendar/main.min.css" rel="stylesheet" data-navigate-once>
    <style>
        @media screen and (max-width: 730px) {
          .fc-direction-ltr .fc-toolbar>*>:not(:first-child) { padding: 3px 10px; margin-left: 0.15em; }
          .fc { font-size: 0.6em; }
          .fc .fc-toolbar-title { font-size: 1.0em; }
          .fc-theme-bootstrap a:not([href]) { margin: 3px; padding: 1px; }
        }
    </style>
    @endpush

    <div class="row mt-3">
        <div class="col-sm-12 col-md-12 lg-12">
            <div class="card overflow-hidden shadow-none">

                @canany(['job-add'])
                  <div class="card-header border-bottom border-200 px-0">
                    <div class="d-lg-flex justify-content-between">
                      <div class="row flex-between-center gy-2 px-x1">
                        <div class="col-auto pe-0"></div>
                        <div class="col-auto"></div>
                      </div>
                      <div class="border-bottom border-200 my-3"></div>
                      <div class="d-flex align-items-center justify-content-between justify-content-lg-end px-x1">
                      <a href="#" class="btn btn-sm btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#addJobModal">
                        <span class="fe fe-plus-circle" data-fa-transform="shrink-4 down-1"></span>
                        <span class="ms-1 d-none d-sm-inline-block">Add New Job</span>
                      </a>
                    </div>
                  </div>
                </div>
                @endcanany

                <div class="card-body" wire:ignore>
                    <div class="calendar-outline" id="appCalendar" style=""></div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="schedule-view" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" wire:ignore>
      <div class="modal-dialog modal-lg mt-6" role="document">
        <div class="modal-content border-0">
          <div class="position-absolute top-0 end-0 mt-3 me-3 z-1">
            <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body p-0">
            <div class="bg-light rounded-top-3 py-3 ps-4 pe-6">
              <div class="d-flex justify-content-between gap-2">
                <!-- left -->
                <div class="modal_left">
                  <h4 class="mb-1" id="title"></h4>
                  <p class="fs--2 mb-0" id="titleSub"></p>
                </div>
                <!-- /left -->
                <!-- right -->
                <div class="modal_right">
                  <div class="fs-3 text-danger">
                    <div class="clock px-3 py-2"></div>
                  </div>
                  <!-- /right -->
                </div>
              </div>
            </div>
            <div class="p-3">
              <div class="row g-1">
                <div class="col-sm-12 col-md-12 col-lg-12">
                  <table class="table table-sm table-bordered">
                    <tbody>
                      <tr class="bg-light py-3">
                        <td colspan="4" class="text-center"> <h5><b>Job Details</b></h5> </td>
                      </tr>
                      <tr>
                        <td>Job Title</td>
                        <td><span class="jobTitle"></span></td>
                        <td colspan="2"></td>
                      </tr>
                      <tr>
                        <td>Address </td>
                        <td><span class="job_address"></span></td>
                        <td colspan="2"></td>
                      </tr>
                      <tr class="optional_jobs">
                        <td>Optional Products</td>
                        <td><span class="optional"></span></td>
                        <td colspan="2"></td>
                      </tr>
                      <tr class="checkin_parent">
                        <td>Checkin</td>
                        <td><span class="checkin"></span></td>
                        <td colspan="2"></td>
                      </tr>
                      <tr class="checkout_parent">
                        <td>Checkout</td>
                        <td><span class="checkout"></span></td>
                        <td colspan="2"></td>
                      </tr>

                      <tr class="job_date_parent">
                        <td>Job Date</td>
                        <td><span class="job_date"></span></td>
                        <td colspan="2"></td>
                      </tr>
                      <tr>
                        <td>Job Hour</td>
                        <td><span class="job_hour"></span></td>
                        <td colspan="2"></td>
                      </tr>
                      <tr>
                        <td>Recurrence Type</td>
                        <td><span class="job_recurrence"></span></td>
                        <td colspan="2"></td>
                      </tr>
                      <tr>
                        <td>Number of People</td>
                        <td><span class="job_people"></span></td>
                        <td colspan="2"></td>
                      </tr>
                      <tr>
                        <td>Code From The Door</td>
                        <td><span class="job_door_code"></span></td>
                        <td colspan="2"></td>
                      </tr>
                      <tr>
                        <td>Job Notes</td>
                        <td><span class="job_notes"></span></td>
                        <td colspan="2"></td>
                      </tr>
                      <tr>
                        <td>Job Status</td>
                        <td><span class="job_status"></span></td>
                        <td colspan="2"></td>
                      </tr>
                      @if(role_name(Auth::user()->id) != 'Employee')
                      <tr class="bg-light">
                        <td colspan="4" class="text-center"> <h5><b>Employeer</b></h5> </td>
                      </tr>
                      <tr>
                        <td>Name</td>
                        <td><span class="emp_name"></span></td>
                        <td colspan="2"></td>
                      </tr>
                      <tr>
                        <td>Email</td>
                        <td><span class="emp_email"></span></td>
                        <td colspan="2"></td>
                      </tr>
                      <tr>
                        <td>Phone</td>
                        <td><span class="emp_phone"></span></td>
                        <td colspan="2"></td>
                      </tr>
                      @endif
                      <tr class="bg-light">
                        <td colspan="4" class="text-center"> <h5><b>Customer</b></h5> </td>
                      </tr>
                      <tr>
                        <td>Name</td>
                        <td><span class="customer_name"></span></td>
                        <td colspan="2"></td>
                      </tr>
                      @if(role_name(Auth::user()->id) != 'Employee')
                      <tr>
                        <td>Email</td>
                        <td><span class="customer_email"></span></td>
                        <td colspan="2"></td>
                      </tr>
                      @endif

                      @can('journal')
                      <tr class="bg-light">
                        <td colspan="4" class="py-2">
                          <div class="@can('journal-add') row align-items-center @else text-center @endcan">
                            <div class="col"><h5><b>Journals</b></h5></div>
                            @can('journal-add')
                            <div class="col-auto">
                              <button type="button" id="toggle-journal" class="btn btn-dark text-dark btn-circle"><i class="fe fe-plus"></i></button>
                            </div>
                            @endcan
                          </div>
                        </td>
                      </tr>
                      <tr class="bg-dark text-white">
                        <td>Name/Role</td>
                        <td class="text-center">Content</td>
                        <td class="text-center">Created_at</td>
                        <td class="text-end">Actions</td>
                      </tr>
                      @canany(['journal-add','journal-edit'])
                      <tr id="journal" class="d-none">
                        <td colspan="4" class="p-0">
                          <input type="hidden" id="jobid" value="" />
                          <input type="hidden" id="journal_id" value="" />
                          <textarea id="new_journal" class="form-control" cols="30" rows="5" placeholder="Enter content here..."></textarea>
                          <div class="row align-items-center bg-light">
                              <div class="col">
                                <button class="btn text-uppercase btn-falcon-danger btn-sm" id="journal_close" type="button">Close</button>
                              </div>
                              <div class="col-auto">
                                <button class="btn text-uppercase btn-falcon-success btn-sm" id="submit_journal" type="button">Submit</button>
                              </div>
                          </div>
                        </td>
                      </tr>
                      @endcanany

                      @endcan
                    </tbody>
                    <tbody id="my_journals"></tbody>
                  </table>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-12 bg-light p-3">

                  <div id="note_section"></div>

                  <h6 class="mt-5 mt-lg-0">Actions</h6>
                  <ul class="nav flex-lg-column fs--1">

                    <!-- <li class="nav-item me-2 me-lg-0" id="incoming_job"></li> -->


                    <li class="nav-item me-2 me-lg-0 " id="">


                      <div class="d-flex align-content-center gap-1">

                        <div id="start_job"></div>
                        <div id="end_job"></div>
                        <div id="chat_with_1"></div>
                        <div id="chat_with_2"></div>


                        @can('job-edit')
                        <div id="edit_job"></div>
                        @endcan
                        @can('job-delete')
                        <div id="delete_job"></div>
                        @endcan
                        <div id="cancel_the_job"></div>
                        <div id="job_undo"></div>

                      </div>
                    </li>

                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- edit listed job -->
    @can(['job-edit'])
    <div class="modal fade" id="edit_listed_job" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
      <div class="modal-dialog" role="document" style="max-width: 500px">
        <form wire:submit.prevent="updateJob" class="modal-content position-relative">
          <div class="position-absolute top-0 end-0 mt-2 me-2 z-1">
            <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close" type="button"></button>
          </div>
          <div class="modal-body p-0">
            <div class="rounded-top-3 py-3 ps-4 pe-6 bg-light">
              <h4 class="mb-1" id="modalExampleDemoLabel"> Edit </h4>
            </div>
            <div class="p-4 pb-0">

                <div class="mb-3">
                  <label class="col-form-label" for="customer">Customer:</label>
                  <select wire:model.live="customer" id="customer" class="form-select">
                    <option value="">Select</option>
                    @foreach($customers as $cname)
                    <option value="{{$cname->id}}">{{ fullName($cname->id) }} {{customerType($cname->id) ? '('.customerType($cname->id).')' : ''}}</option>
                    @endforeach
                  </select>
                </div>

                <div class="mb-3" x-show="$wire.customer_type != 'host'" >
                  <label class="col-form-label" for="job_date">Job Date</label>
                  <div class="input-group">
                    <input type="date" wire:model="job_date" id="job_date" class="form-control" />
                    <input type="time" wire:model="job_time" class="form-control" />
                  </div>
                </div>


                <div class="row mb-2" x-show="$wire.customer_type === 'host'" >

                  <div class="mb-3">
                    <label for="checkin">Checkin:</label>
                    <div class="input-group">
                      <input type="date" wire:model="checkin" id="checkin" class="form-control" />
                      <input type="time" wire:model="checkin_time" id="checkin" class="form-control" />
                    </div>
                  </div>

                  <div class="mb-3">
                    <label for="checkout">Checkout:</label>
                    <div class="input-group">
                      <input type="date" wire:model="checkout" id="checkout" class="form-control" />
                      <input type="time" wire:model="checkout_time" id="checkout" class="form-control" />
                    </div>
                  </div>

                </div>

                <div class="mb-3">
                  <label class="col-form-label" for="service">Service Name:</label>
                  <select wire:model.live="service" id="service" class="form-select">
                    <option value="">Select Service</option>
                    @foreach( $services as $serv)
                    <option value="{{$serv->id}}" @if($serv->id == $service) selected="" @endif>{{$serv->title.' ('.$serv->regularity.')'}}</option>
                    @endforeach
                  </select>
                </div>

                <div class="mb-3">
                  <label class="col-form-label" for="address">Address:</label>
                  <select wire:model="address" id="address" class="form-select">
                    <option value="">Select address</option>

                      @foreach($addresses as $addressdata)
                        <option value="{{$addressdata['address']}}" @if($addressdata['address'] == $address) selected="" @endif>{{$addressdata['address_for'].':'.$addressdata['address']}}</option>
                      @endforeach

                  </select>
                </div>

                <div class="mb-3">
                  <label class="col-form-label" for="task_hour">Total Task Hours:</label>
                  <input type="number" min="0" step="any" wire:model="task_hour" id="task_hour" class="form-control" />
                </div>

                <div class="mb-3">
                  <label class="col-form-label" for="recurrence_type">Recurrence Type:</label>
                  <select wire:model="recurrence_type" id="recurrence_type" class="form-select">
                    <option value="none">None</option>
                    <option value="one time">One Time</option>
                    <option value="daily">Daily</option>
                    <option value="weekly">Weekly</option>
                    <option value="monthly">Monthly</option>
                    <option value="yearly">Yearly</option>
                  </select>
                </div>

                <div class="mb-3">
                  <label class="col-form-label" for="number_of_people">Number of People:</label>
                  <input type="number" min="0" step="any" wire:model="number_of_people" id="number_of_people" class="form-control" />
                </div>

                <div class="mb-3">
                  <label class="col-form-label" for="code_from_the_door">Code from the door:</label>
                  <input type="text" wire:model="code_from_the_door" id="code_from_the_door" class="form-control" />
                </div>

                <div class="mb-3">
                  <label class="col-form-label" for="job_notes">Job Notes:</label>
                  <textarea wire:model="job_notes" placeholder="Enter Job Notes" id="job_notes" cols="30" rows="3" class="form-control"></textarea>
                </div>

                @foreach($optionalproducts as $oppro)
                <div class="form-check form-check-inline" style="margin-right: 0px">
                    <input
                    class="form-check-input"
                    id="{{$oppro->id}}"
                    wire:model="optionals"
                    type="checkbox"
                    value="{{$oppro->id}}"

                    @foreach($optionals as $oppro2)

                      @if($oppro->id == $oppro2)
                        checked=""
                      @endif

                    @endforeach
                     />
                    <label class="form-check-label" for="{{$oppro->id}}">{{$oppro->name}} {{'('.$oppro->add_on_price.''.$oppro->currency.')' ?? ''}}</label>
                </div>
                @endforeach


                <div class="mb-3">
                  <label class="col-form-label" for="employee">Employee:</label>
                  <select wire:model="employee" id="employee" class="form-select">
                    <option value="">Select</option>
                    @foreach($employees as $emp)
                    <option value="{{$emp->id}}">{{ employeeName($emp->id) }}</option>
                    @endforeach
                  </select>
                </div>

            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
            <button class="btn btn-primary" type="submit"> Save Changes </button>
          </div>
        </form>
      </div>
    </div>
    @endcan

    <!-- add new job -->
    <div class="modal fade" id="addJobModal" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
      <div class="modal-dialog" role="document" style="max-width: 500px">
        <form wire:submit.prevent="addNewJob" class="modal-content position-relative">
          <div class="position-absolute top-0 end-0 mt-2 me-2 z-1">
            <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close" type="button"></button>
          </div>
          <div class="modal-body p-0">
            <div class="rounded-top-3 py-3 ps-4 pe-6 bg-light">
              <h4 class="mb-1" id="modalExampleDemoLabel"> Add Job </h4>
            </div>
            <div class="p-4 pb-0">

                <div class="mb-3">
                  <label class="col-form-label" for="new_customer">Customer:</label>
                  <select wire:model.live="new_customer" id="new_customer" class="form-select">
                    <option value="">Select</option>
                    @foreach($customers as $cname)
                    <option value="{{$cname->id}}">{{ fullName($cname->id) }} {{customerType($cname->id) ? '('.customerType($cname->id).')' : ''}}</option>
                    @endforeach
                  </select>
                </div>

                <div class="mb-3" x-show="$wire.new_customer_type != 'host'" >
                  <label class="col-form-label" for="new_job_date">Job Date</label>
                  <div class="input-group">
                    <input type="date" wire:model="new_job_date" id="new_job_date" class="form-control @error('new_job_date') is-invalid @enderror" />
                    <input type="time" wire:model="new_job_time" class="form-control @error('new_job_time') is-invalid @enderror" />
                  </div>
                </div>


                <div class="row mb-2" x-show="$wire.new_customer_type === 'host'" >

                  <div class="mb-3">
                    <label for="new_checkin">Checkin:</label>
                    <div class="input-group">
                      <input type="date" wire:model="new_checkin" id="new_checkin" class="form-control @error('new_checkin') is-invalid @enderror" />
                      <input type="time" wire:model="new_checkin_time" id="new_checkin_time" class="form-control @error('new_checkin_time') is-invalid @enderror" />
                    </div>
                  </div>

                  <div class="mb-3">
                    <label for="new_checkout">Checkout:</label>
                    <div class="input-group">
                      <input type="date" wire:model="new_checkout" id="new_checkout" class="form-control @error('new_checkout') is-invalid @enderror" />
                      <input type="time" wire:model="new_checkout_time" id="new_checkout_time" class="form-control @error('new_checkout_time') is-invalid @enderror" />
                    </div>
                  </div>

                </div>

                <div class="mb-3">
                  <label class="col-form-label" for="new_service">Service Name:</label>
                  <select wire:model.live="new_service" id="new_service" class="form-select @error('new_service') is-invalid @enderror">
                    <option value="">Select Service</option>
                    @foreach( $services as $serv)
                    <option value="{{$serv->id}}" @if($serv->id == $service) selected="" @endif>{{$serv->title.' ('.$serv->regularity.')'}}</option>
                    @endforeach
                  </select>
                </div>

                <div class="mb-3">
                  <label class="col-form-label" for="new_address">Address:</label>
                  <select wire:model="new_address" id="new_address" class="form-select @error('new_address') is-invalid @enderror">
                    <option value="">Select address</option>

                    @foreach($new_addresses as $new_addressdata)
                      <option value="{{$new_addressdata['address']}}" @if($new_addressdata['address'] == $new_address) selected="" @endif>{{$new_addressdata['address_for'].':'.$new_addressdata['address']}}</option>
                    @endforeach

                  </select>
                </div>

                <div class="mb-3">
                  <label class="col-form-label" for="new_task_hour">Total Task Hours:</label>
                  <input type="number" min="0" step="any" wire:model="new_task_hour" id="new_task_hour" class="form-control @error('new_task_hour') is-invalid @enderror" />
                </div>

                <div class="mb-3">
                  <label class="col-form-label" for="new_recurrence_type">Recurrence Type:</label>
                  <select wire:model="new_recurrence_type" id="new_recurrence_type" class="form-select @error('new_recurrence_type') is-invalid @enderror">
                    <option value="none">None</option>
                    <option value="one time">One Time</option>
                    <option value="daily">Daily</option>
                    <option value="weekly">Weekly</option>
                    <option value="monthly">Monthly</option>
                    <option value="yearly">Yearly</option>
                  </select>
                </div>

                <div class="mb-3">
                  <label class="col-form-label" for="new_number_of_people">Number of People:</label>
                  <input type="number" min="0" step="any" wire:model="new_number_of_people" id="new_number_of_people" class="form-control @error('new_number_of_people') is-invalid @enderror" />
                </div>

                <div class="mb-3">
                  <label class="col-form-label" for="new_code_from_the_door">Code from the door:</label>
                  <input type="text" wire:model="new_code_from_the_door" id="new_code_from_the_door" class="form-control @error('new_code_from_the_door') is-invalid @enderror" />
                </div>

                <div class="mb-3">
                  <label class="col-form-label" for="new_job_notes">Job Notes:</label>
                  <textarea wire:model="new_job_notes" placeholder="Enter Job Notes" id="new_job_notes" cols="30" rows="3" class="form-control @error('new_job_notes') is-invalid @enderror"></textarea>
                </div>

                @foreach($optionalproducts as $opkey => $oppro)
                <div class="form-check form-check-inline" style="margin-right: 0px">
                    <input
                    class="form-check-input"
                    id="check{{$opkey.$oppro->id}}"
                    wire:model="new_optionals"
                    type="checkbox"
                    value="{{$oppro->id}}"

                    @foreach($optionals as $oppro2)

                      @if($oppro->id == $oppro2)
                        checked=""
                      @endif

                    @endforeach
                     />
                    <label class="form-check-label" for="check{{$opkey.$oppro->id}}">{{$oppro->name}} {{'('.$oppro->add_on_price.''.$oppro->currency.')' ?? ''}}</label>
                </div>
                @endforeach


                <div class="mb-3">
                  <label class="col-form-label" for="employee">Employee:</label>
                  <select wire:model="new_employee" id="employee" class="form-select">
                    <option value="">Select</option>
                    @foreach($employees as $emp)
                    <option value="{{$emp->id}}">{{ employeeName($emp->id) }}</option>
                    @endforeach
                  </select>
                </div>

            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
            <button class="btn btn-primary" type="submit"> Save Changes </button>
          </div>
        </form>
      </div>
    </div>

    @push('js')
    <script src="{{ config('app.cdn_root') }}/public/vendors/fullcalendar/main.min.js" data-navigate-track></script>
    <script>
        // Define colors
        var blue   = "#004AA8";
        var yellow = "#FEDD5A";
        var green  = "#1E9474";
        var red    = "#F13538";
        var orange = "#FE914E";
        var white  = "#FFFFFF";
        var black  = "#000000";
        var panelType                = '<?php echo role_name(Auth::user()->id); ?>';
        var permissionToAddJob       = '<?php echo checkUserPermission('job-add'); ?>';
        var permissionToAddSingleJob = '<?php echo checkUserPermission('job-add'); ?>';
        var eventDropPermission      = '<?php echo checkUserPermission('job-drag-drop'); ?>';
        var calendarEl               = document.getElementById("appCalendar");

        var calendar = new FullCalendar.Calendar(calendarEl, {

            editable: true, // Enable drag-and-drop
            droppable: true, // Enable external drag and drop
            eventDurationEditable: true, // Allow event resizing
            firstDay: 1,
            headerToolbar: {
              left: panelType === 'Employee' ? 'prev,next today' : 'prev,next today',
              center: 'title',
              right: 'dayGridMonth,dayGridWeek,dayGridDay',
            },
            initialDate: new Date(),
            locale: 'en',
            navLinks: true, // can click day/week names to navigate views
            businessHours: false, // display business hours
            selectable: false,
            dateClick: function(info) {
              if (permissionToAddJob == 'yes' && permissionToAddSingleJob == 'yes') {
                // window.location.href = panelType == 'Administrator' ? '/admin/add-job' : '/admin/add-single-job';
                $('#addJobModal').modal('show');
                //@this.set('new_job_date', info.dateStr);
              }
            },

            events: <?php echo $events; ?>,

            eventDrop: function(info) {

              if (eventDropPermission == 'yes') {
                var dEvent = info.event;
                // Manually format to 'YYYY-MM-DD'
                var startLocal = dEvent.start;
                var year       = startLocal.getFullYear();
                var month      = ('0' + (startLocal.getMonth() + 1)).slice(-2); // Add leading 0
                var day        = ('0' + startLocal.getDate()).slice(-2); // Add leading 0
                var newDate    = `${year}-${month}-${day}`;
                var newDate2   = null;

                if (dEvent.end) {
                  var endLocal = dEvent.end;
                  var year2    = endLocal.getFullYear();
                  var month2   = ('0' + (endLocal.getMonth() + 1)).slice(-2); // Add leading 0
                  var day2     = ('0' + endLocal.getDate()).slice(-2); // Add leading 0
                  var newDate2 = `${year2}-${month2}-${day2}`;
                }
                $.ajax({
                  url: '/api/update-event',
                  method: 'POST',
                  data: {
                    id: dEvent.id,
                    start: newDate,
                    end: newDate2,
                    _token: "{{ csrf_token() }}"
                  },
                  success: function(response) {
                    toastr.success('updated successfully!');
                  },
                  error: function() {
                    //
                  }
                });
              }
            },

            eventContent: function(info) {
              return {
                html: info.event.title
              };
            },


            eventClick: function(info) {

                var details = info.event.extendedProps.details;

                $('#schedule-view .emp_name').text(details.emp_name);

                /*REETTING*/
                var elementIDs = [
                  '#title',
                  '.jobTitle',
                  '#titleSub',
                  '.job_address',
                  '.optional',
                  '.checkin',
                  '.checkout',
                  '.job_date',
                  '.job_hour',
                  '.job_recurrence',
                  '.job_people',
                  '.job_door_code',
                  '.job_notes',
                  '.job_status'
                ];
                elementIDs.forEach(function(elementID) {
                    $('#schedule-view ' + elementID).text('');
                });
                $('#schedule-view #note_section').html('');
                $('#schedule-view #start_job').html('');
                $('#schedule-view #chat_with_1').html('');
                $('#schedule-view #chat_with_2').html('');
                $('#schedule-view #end_job').html('');
                $('#schedule-view #cancel_the_job').html('');
                $('#schedule-view #edit_job').html('');
                $('#schedule-view #delete_job').html('');
                $('#schedule-view #job_undo').html('');
                $('#schedule-view .job_address').html('');
                $('#schedule-view .optional').html('');
                $('#schedule-view .clock').attr('data-start-time', '');
                $('#schedule-view .emp_email').html('');
                $('#schedule-view .emp_phone').html('');
                $('#schedule-view .customer_email').html('');
                $('#jobid').val('');
                $('#my_journals').html('');


                /*RESETING END*/


                /* adding the journals */

                var journals = details.journals;

                journals.forEach(function(item) {
                    // Format the created_at date to YY-MM-DD
                    var date = new Date(item.created_at);
                    var formattedDate = date.toISOString().split('T')[0];
                    var year = formattedDate.split('-')[0];
                    var month = formattedDate.split('-')[1];
                    var day = formattedDate.split('-')[2];
                    var finalDate = `${year}-${month}-${day}`;

                    // Get hours and minutes
                    var hours = date.getHours();
                    var minutes = date.getMinutes();

                    // Convert to AM/PM format
                    var ampm = hours >= 12 ? 'PM' : 'AM';
                    hours = hours % 12;
                    hours = hours ? hours : 12;
                    minutes = minutes < 10 ? '0' + minutes : minutes;
                    var finalTime = `${hours}:${minutes} ${ampm}`;

                    var journalHtml = `
                        <tr class="journal-entry">
                            <td>${item.full_name} <span class="badge rounded-pill bg-primary">${item.role_name}</span></td>
                            <td>${item.journal}</td>
                            <td>${finalDate} <br />  <span class="badge rounded-pill bg-info">${finalTime}</span> </td>
                            <td class="text-end">
                              <div class="btn-group">
                                @can('journal-edit')
                                <button class="btn btn-sm btn-circle edit-btn" data-journal-id="${item.id}" data-journal-content="${item.journal}"><span class="fe fe-edit text-primary"></span></button>
                                @endcan
                                @can('journal-delete')
                                <button class="btn btn-sm btn-circle delete-btn" data-journal-id="${item.id}"><span class="fe fe-x text-danger"></span></button>
                                @endcan
                              </div>
                            </td>
                        </tr>
                    `;
                    $('#my_journals').append(journalHtml);
                });


                /* Ending the Journals */


                /*BUTTONS*/

                if (details.job_status === 'Assigned') {

                  // start button
                  var buttonElement = document.createElement('button');
                  buttonElement.type = 'button';
                  buttonElement.className = 'btn btn-primary btn-sm text-white text-left';
                  buttonElement.style.width = '100%';
                  buttonElement.style.textAlign = 'left';
                  buttonElement.innerHTML = '<span class="fas fa-clock me-2"></span>Start';
                  buttonElement.setAttribute('wire:click', 'start(\'' + info.event.id + '\')');
                  buttonElement.setAttribute('wire:confirm', 'Are you sure you want to delete this post?');
                  //buttonElement.setAttribute('onclick', 'return confirm("Do you want to start Working?") || event.stopImmediatePropagation()');
                  $('#schedule-view #start_job').append(buttonElement);

                  // edit button

                  if (details.panel === 'Administrator') {

                    var deleteButtonElement = document.createElement('button');
                    deleteButtonElement.type = 'button';
                    deleteButtonElement.className = 'btn btn-info btn-sm text-white text-left';
                    deleteButtonElement.style.width = '100%';
                    deleteButtonElement.style.textAlign = 'left';
                    deleteButtonElement.innerHTML = '<span class="fas fa-edit me-2"></span> Edit';
                    deleteButtonElement.setAttribute('data-bs-toggle', 'modal');
                    deleteButtonElement.setAttribute('data-bs-target', '#edit_listed_job');
                    deleteButtonElement.setAttribute('wire:click', 'editJob(\'' + info.event.id + '\')');
                    $('#schedule-view #edit_job').append(deleteButtonElement);
                  }

                  // delete button
                  var deleteButtonElement = document.createElement('button');
                  deleteButtonElement.type = 'button';
                  deleteButtonElement.className = 'btn btn-warning btn-sm text-white text-left';
                  deleteButtonElement.style.width = '100%';
                  deleteButtonElement.style.textAlign = 'left';
                  deleteButtonElement.innerHTML = '<span class="fas fa-trash me-2"></span>delete';
                  deleteButtonElement.setAttribute('wire:click', 'delete(\'' + info.event.id + '\')');
                  //deleteButtonElement.setAttribute('onclick', 'return confirm("Are you Sure to Delete?") || event.stopImmediatePropagation()');
                  $('#schedule-view #delete_job').append(deleteButtonElement);
                }

                if (details.job_status === 'Working') {

                  // Create a file input element
                  var fileInputElement = document.createElement('input');
                  fileInputElement.type = 'file'; // Set the input type to file
                  fileInputElement.multiple = true; // Add the multiple attribute
                  fileInputElement.className = 'form-control mb-2';
                  fileInputElement.setAttribute('wire:model', 'taskfiles');


                  var textareaElement = document.createElement('textarea');
                  textareaElement.placeholder = 'Enter messages...'; // Customize placeholder text if needed
                  textareaElement.rows = 4; // Specify the number of rows
                  textareaElement.className = "form-control mb-2 is-invalid";
                  textareaElement.setAttribute('wire:model', 'employee_message');

                  // Create the "Mark as Complete" button
                  var buttonElement = document.createElement('button');
                  buttonElement.type = 'button';
                  buttonElement.className = 'btn btn-success btn-sm text-white text-left';
                  buttonElement.style.width = '100%';
                  buttonElement.style.textAlign = 'left';
                  buttonElement.innerHTML = '<span class="fas fa-check me-2"></span>Stop';
                  buttonElement.setAttribute('wire:click', 'done(\'' + info.event.id + '\')');
                  //buttonElement.setAttribute('onclick', 'return confirm("Did you Completed the Job") || event.stopImmediatePropagation()');
                  $('#schedule-view #note_section').append(fileInputElement);
                  $('#schedule-view #note_section').append(textareaElement);
                  $('#schedule-view #end_job').append(buttonElement);

                  $('#schedule-view .clock').attr('data-start-time', details.job_start_time);

                  /*show started time*/
                  function updateClock(clockElement) {
                    const startDate = new Date(clockElement.getAttribute('data-start-time'));
                    const currentDate = new Date();
                    const elapsedTime = currentDate - startDate;
                    let seconds = Math.floor(elapsedTime / 1000) % 60;
                    let minutes = Math.floor(elapsedTime / 1000 / 60) % 60;
                    let hours = Math.floor(elapsedTime / 1000 / 3600);

                    // Format the time as HH:MM:SS
                    const timeString = `${hours < 10 ? '0' : ''}${hours}:${minutes < 10 ? '0' : ''}${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;

                    // Update the clock element
                    clockElement.textContent = timeString;
                    // Apply specified styles
                    $(clockElement).css({
                        'border': '1px dashed #000',
                        'font-weight': 'bold',
                    });
                  }

                  // Get all clock elements
                  const clockElements = document.querySelectorAll('.clock');

                  // Update each clock individually
                  clockElements.forEach(function(clockElement) {
                    updateClock(clockElement);
                    // Update each clock every second
                    setInterval(function() {
                      updateClock(clockElement);
                    }, 1000);
                  });

                }

                var buttonElement = document.createElement('button');
                buttonElement.type = 'button';
                buttonElement.className = 'btn btn-danger btn-sm text-white text-left';
                buttonElement.style.width = '100%';
                buttonElement.style.textAlign = 'left';
                buttonElement.innerHTML = '<span class="fas fa-times"></span>Cancel';
                buttonElement.setAttribute('wire:click', 'cancel(\'' + info.event.id + '\')');
                //buttonElement.setAttribute('onclick', 'return confirm("Do you want to cancel?") || event.stopImmediatePropagation()');
                $('#schedule-view #cancel_the_job').append(buttonElement);

                /*BUTTON*/

                $('#schedule-view').modal('show');
                $('#schedule-view #title').text(details.job_name);
                $('#schedule-view .jobTitle').text(details.job_name);
                $('#schedule-view #titleSub').text('assinged to: ' + details.emp_name);

                // Check if job_date is null or empty
                if (details.job_date) {
                  $('#schedule-view .checkin_parent, #schedule-view .checkout_parent').hide();
                } else {
                  $('#schedule-view .job_date_parent').hide();
                }

                // chat button
                if (details.panel === 'Administrator') {
                  $('#schedule-view #chat_with_1').append("<div class='d-grid'><a target='_blank' class='btn btn-info btn-sm text-white text-left' href='/admin/chats?recipient="+details.customer_id+"' wire:navigate>Chat With Customer</a></div>");
                  $('#schedule-view #chat_with_2').append("<a target='_blank' class='btn btn-primary btn-sm text-white text-left' href='/admin/chats?recipient="+details.employee_id+"' wire:navigate>Chat With Employee</a>");
                  if (details.job_status === 'Completed') {

                    var undoButton = document.createElement('button');
                      undoButton.type = 'button';
                      undoButton.className = 'btn btn-danger btn-sm text-white text-left';
                      undoButton.style.width = '100%';
                      undoButton.style.textAlign = 'left';
                      undoButton.innerHTML = '<span class="fas fa-times me-2"></span>UNDO JOB';
                      undoButton.setAttribute('wire:click', 'undoIt(\'' + info.event.id + '\')');
                      //undoButton.setAttribute('onclick', 'return confirm("Do you want to Reset The Job?") || event.stopImmediatePropagation()');
                      $('#schedule-view #job_undo').append(undoButton);
                  }

                } else if (details.panel === 'Employee') {
                  $('#schedule-view #chat_with_1').append("<a target='_blank' class='btn btn-info btn-sm text-white text-left' href='/admin/chats?recipient="+details.customer_id+"&job="+info.event.id+"&service="+details.service_id+"' wire:navigate>Chat With Customer</a>");
                  $('#schedule-view #chat_with_2').html('');
                } else {
                  $('#schedule-view #chat_with_1').html('');
                  $('#schedule-view #chat_with_2').html('');
                }

                $('#schedule-view .job_address').append("<a target='_blank' href='http://maps.google.com/?q="+details.job_address+"'>"+details.job_address+"</a> ");
                $('#schedule-view .optional').append("<span class=''>"+details.optional+"</span> ");
                $('#schedule-view .checkin').text(details.checkin);
                $('#schedule-view .checkout').text(details.checkout);
                $('#schedule-view .job_date').text(details.job_date);
                $('#schedule-view .job_hour').text(details.job_hour);
                $('#schedule-view .job_recurrence').text(details.job_recurrence_type);
                $('#schedule-view .job_people').text(details.job_people);
                $('#schedule-view .job_door_code').text(details.job_door_code);
                $('#schedule-view .job_notes').text(details.job_notes);
                $('#schedule-view .job_status').text(details.job_status);
                $('#jobid').val(info.event.id);

                if (details.job_status === 'Pending') {
                    $('#schedule-view .job_status').text(details.job_status).removeClass('bg-status-yellow bg-status-orange bg-status-green bg-status-red');
                    $('#schedule-view .job_status').text(details.job_status).addClass('badge rounded-pill bg-status-blue text-white');
                    $('#schedule-view .clock').text();
                } else if (details.job_status === 'Assigned') {
                    $('#schedule-view .job_status').text(details.job_status).removeClass('bg-status-blue bg-status-orange bg-status-green bg-status-red');
                    $('#schedule-view .job_status').text(details.job_status).addClass('badge rounded-pill bg-status-yellow text-dark');
                    $('#schedule-view .clock').text();
                } else if (details.job_status === 'Working') {
                    $('#schedule-view .job_status').text(details.job_status).removeClass('bg-status-blue bg-status-yellow bg-status-green bg-status-red');
                    $('#schedule-view .job_status').text(details.job_status).addClass('badge rounded-pill bg-status-orange text-dark');
                } else if (details.job_status === 'Completed') {
                    $('#schedule-view .job_status').text(details.job_status).removeClass('bg-status-blue bg-status-yellow bg-status-orange bg-status-red');
                    $('#schedule-view .job_status').text(details.job_status).addClass('badge rounded-pill bg-status-green text-white');
                    $('#schedule-view #cancel_the_job').hide();
                    $('#schedule-view #edit_job').hide();
                    $('#schedule-view .clock').text();
                } else if (details.job_status === 'Canceled') {
                    $('#schedule-view .job_status').text(details.job_status).removeClass('bg-status-blue bg-status-yellow bg-status-orange bg-status-green');
                    $('#schedule-view .job_status').text(details.job_status).addClass('badge rounded-pill bg-status-red text-white');
                    $('#schedule-view #cancel_the_job').hide();
                    $('#schedule-view #edit_job').hide();
                    $('#schedule-view .clock').text();
                }

                $('#schedule-view .emp_name').text(details.emp_name);
                $('#schedule-view .emp_email').append("<a href='mailto:" + details.emp_email.replace(/[() -]/g, '') + "' target='_blank'>" + details.emp_email + "</a> ");
                $('#schedule-view .emp_phone').append("<a href='tel:" + details.emp_phone.replace(/[() -]/g, '') + "' target='_blank'>" + details.emp_phone + "</a> ");
                $('#schedule-view .customer_name').text(details.customer_name);
                $('#schedule-view .customer_email').append("<a href='mailto:" + details.customer_email.replace(/[() -]/g, '') + "' target='_blank'>" + details.customer_email + "</a> ");
            },
        });

        calendar.render();
    </script>

    <script>
      var authType = '<?php echo role_name(Auth::user()->id); ?>';
      if ( authType === 'Employee') {
        var addButtonElements = document.getElementsByClassName('fc-addNewJob-button');
        for (var i = 0; i < addButtonElements.length; i++) {
          addButtonElements[i].style.display = 'none';
        }
      }
    </script>

    <script>
      navigator.geolocation.getCurrentPosition(function(position){
        var latitude = position.coords.latitude;
        var longitude = position.coords.longitude;
        @this.set('latitude', latitude);
        @this.set('longitude', longitude);
      });
    </script>


    @canany(['journal-add','journal-edit'])
    <!-- journal submit -->
    <script>
      $(document).ready(function() {
          $('#submit_journal').on('click', function() {

              var userId   = '{{ Auth::id() }}';
              var roleName = '{{ role_name(Auth::id()) }}';
              var journal  = $('#new_journal').val();
              var jobId    = $('#jobid').val();
              var journalId= $('#journal_id').val();
              if (journal) {

                // AJAX request
                $.ajax({
                    url: '/api/submit-new-journal',
                    method: 'POST',
                    data: {
                        id: journalId,
                        job_id: jobId,
                        user_id: userId,
                        role_name: roleName,
                        journal: journal,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                      $('#new_journal').val('');
                      $('#journal').addClass('d-none');

                      var journals = response.journals;
                      $('#my_journals').html('');
                      journals.forEach(function(item) {

                         // Format the created_at date to YY-MM-DD
                          var date = new Date(item.created_at);
                          var formattedDate = date.toISOString().split('T')[0];
                          var year = formattedDate.split('-')[0];
                          var month = formattedDate.split('-')[1];
                          var day = formattedDate.split('-')[2];
                          var finalDate = `${year}-${month}-${day}`;

                          // Get hours and minutes
                          var hours = date.getHours();
                          var minutes = date.getMinutes();

                          // Convert to AM/PM format
                          var ampm = hours >= 12 ? 'PM' : 'AM';
                          hours = hours % 12;
                          hours = hours ? hours : 12;
                          minutes = minutes < 10 ? '0' + minutes : minutes;
                          var finalTime = `${hours}:${minutes} ${ampm}`;

                          var journalHtml = `
                              <tr class="journal-entry">
                                  <td>${item.full_name} <span class="badge rounded-pill bg-primary">${item.role_name}</span></td>
                                  <td>${item.journal}</td>
                                  <td>
                                    ${finalDate} <br /> <span class="badge rounded-pill bg-info">${finalTime}</span>
                                  </td>
                                  <td class="text-end">
                                    <div class="btn-group">
                                      @can('journal-edit')
                                      <button class="btn btn-sm btn-circle edit-btn" data-journal-id="${item.id}" data-journal-content="${item.journal}"><span class="fe fe-edit text-primary"></span></button>
                                      @endcan
                                      @can('journal-delete')
                                      <button class="btn btn-sm btn-circle delete-btn" data-journal-id="${item.id}"><span class="fe fe-x text-danger"></span></button>
                                      @endcan
                                    </div>
                                  </td>
                              </tr>
                          `;
                          $('#my_journals').append(journalHtml);
                      });
                    },
                    error: function(xhr) {
                      alert('An error occurred. Please try again.');
                    }
                });

              }
          });


          $('#toggle-journal').on('click', function() {
            $('#new_journal').val('');
            $('#submit_journal').text('SUBMIT');
            $('#journal_id').val('');
            $('#journal').removeClass('d-none');
          });

          $('#journal_close').on('click', function() {
            $('#new_journal').val('');
            $('#journal').addClass('d-none');
            $('#journal_id').val('');
            $('#submit_journal').text('SUBMIT');
          });

      });
    </script>

    <script>
      $(document).on('click', '.edit-btn', function() {
        var journalId = $(this).data('journal-id');
        var journalContent = $(this).data('journal-content');

        // Show the hidden form
        $('#journal').removeClass('d-none');

        // Populate the form fields with the selected journal data
        $('#new_journal').val(journalContent);
        $('#journal_id').val(journalId);
        $('#submit_journal').text('UPDATE');
      });

      // Add functionality to close the form
      $('#journal_close').on('click', function() {
        $('#journal').addClass('d-none');
        $('#new_journal').val('');
        $('#journal_id').val('');
      });
    </script>
    @endcanany



    @can('journal-delete')
    <script>
      $(document).on('click', '.delete-btn', function() {

        var userId   = '{{ Auth::id() }}';
        var journalId = $(this).data('journal-id');
        var jobId     = $('#jobid').val();
        var deleteButton = $(this); // Store reference to the delete button to remove the entry later
        var isConfirmed = confirm('Are you sure you want to delete this journal?');

        if (isConfirmed) {
          $.ajax({
            url: '/api/delete-journal',  // Your API endpoint
            method: 'POST',
            data: {
              user_id: userId,
              job_id: jobId,
              journal_id: journalId,
              _token: '{{ csrf_token() }}'  // Ensure CSRF token is accessible
            },
            success: function(response) {
              if (response.success) {
                toastr.success('Journal deleted successfully!');
                deleteButton.closest('tr').remove();
              } else {
                alert('Error: ' + response.message);
              }
            },
            error: function(xhr) {
              alert('An error occurred. Please try again.');
            }
          });
        }
      });
    </script>
    @endcan




    @endpush
</div>
