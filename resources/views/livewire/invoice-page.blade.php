<div>

    @push('css')
    <link rel="stylesheet" href="{{ config('app.cdn_root') }}/public/loader-5.css" data-navigate-once>
    @endpush

    <div class="row mt-3">
        <div class="col-sm-12 col-md-12 col-lg-12">

            <!-- unpaid invoices -->

            <div class="card mt-1 shadow-sm mb-5">
                <div class="card-header border-bottom border-200 px-0">
                    <div class="d-lg-flex justify-content-between">
                        <div class="row flex-between-center gy-2 px-x1">
                            <div class="col-auto pe-0"><h4 class="mb-0 text-muted"><b>Unpaid Invoices</b></h4></div>
                            <div class="col-auto"></div>
                        </div>
                        <div class="border-bottom border-200 my-3"></div>
                        <div class="d-flex align-items-center justify-content-between justify-content-lg-end px-x1">
                            @can('invoices-add')
                            <a href="{{route('add-invoice')}}" class="btn btn-info btn-sm me-1 mb-1"><span class="fe fe-plus-circle"></span> Add New Invoice</a>
                            @endcan
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive scrollbar">
                        <table class="table table-sm mb-0 fs--1 table-view-tickets" id="unpaidInvoice">
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
                                    <th class="sort align-middle ps-2 text-end" data-sort="actions">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="list" id="table-ticket-body">
                                @foreach($unpaid_invoices as $unpaid_item)
                                <tr>
                                    <td class="align-middle fs-0 py-1">{{ $unpaid_item->id }}</td>
                                    <td class="align-middle subject py-1">{{ $unpaid_item->invoice_number }}</td>
                                    <td class="align-middle subject py-1">{{ fullName($unpaid_item->user_id) }}</td>
                                    <td class="align-middle subject py-1">{{ parseDateOnly($unpaid_item->date) }}</td>
                                    <td class="align-middle subject py-1">{{ $unpaid_item->total_customer_price.' '.currencySign() }}</td>
                                    <td class="align-middle subject py-1">{{ $unpaid_item->total_tax.' '.currencySign() }}</td>
                                    <td class="align-middle subject py-1">{{ $unpaid_item->total_price.' '.currencySign() }}</td>
                                    <td class="align-middle subject py-1">{{ balanceRemain($unpaid_item->id) == 0 ? '0.00 '.currencySign(1) : balanceRemain($unpaid_item->id).' '.currencySign(1) }}</td>
                                    <td class="align-middle subject py-1 pe-4 text-end">
                                        <div class="btn-group gap-1">
                                            @if(role_name(Auth::user()->id) == 'Administrator')
                                                @can('invoices-make-payment')
                                                    <a 
                                                    href="/admin/invoice-payments?id={{$unpaid_item->id}}" 
                                                    title="Invoice Payments"
                                                    class="btn btn-sm bg-facebook rounded shadow-sm btn-sm text-white"><i class="fe fe-upload"></i></a>
                                                @endcan
                                                @can('invoices-edit')
                                                    <a 
                                                    href="/admin/edit-new-invoice?id={{$unpaid_item->id}}" 
                                                    title="Edit Service"
                                                    class="btn btn-sm btn-primary rounded shadow-sm btn-sm"><i class="fe fe-edit-3"></i></a>
                                                @endcan
                                            @endif
                                            <a 
                                            href="/admin/view-invoice?id={{$unpaid_item->id}}" 
                                            title="Download Invoice"
                                            target="_blank" class="btn btn-sm btn-info rounded shadow-sm btn-sm"><i class="far fa-file-pdf"></i></a>
                                            @if(role_name(Auth::user()->id) == 'Administrator')
                                                @can('invoices-invoice-sent_to_email')
                                                <button 
                                                class="btn btn-sm btn-success rounded shadow-sm btn-sm send-mail" 
                                                title="Send Email"
                                                data-invoice-id="{{$unpaid_item->id}}"><i class="fe fe-mail"></i></button>
                                                @endcan
                                                @can('invoices-delete')
                                                <button 
                                                onclick="return confirm('Are you sure you want to delete?') || event.stopImmediatePropagation()" 
                                                wire:click="deleteInvoice({{$unpaid_item->id}})" 
                                                title="Delete Invoice"
                                                class="btn btn-sm btn-danger rounded shadow-sm"><i class="fe fe-x"></i></button>
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
            </div>

            <!-- paid invoices -->

            <div class="card mt-1 shadow-sm mb-5">
                <div class="card-header border-bottom border-200 px-0">
                    <div class="d-lg-flex justify-content-between">
                        <div class="row flex-between-center gy-2 px-x1">
                            <div class="col-auto pe-0"><h4 class="mb-0 text-muted"><b>Paid Invoices</b></h4></div>
                            <div class="col-auto"></div>
                        </div>
                        <div class="border-bottom border-200 my-3"></div>
                        <div class="d-flex align-items-center justify-content-between justify-content-lg-end px-x1"></div>
                    </div>
                </div>
                <div class="card-body" >
                    <div class="table-responsive scrollbar">
                        <table class="table table-sm mb-0 fs--1 table-view-tickets" id="paidInvoice" >
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
                                    <th class="sort align-middle ps-2 text-end" data-sort="actions">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="list" id="table-ticket-body">
                                @foreach($paid_invoices as $paid_item)
                                <tr>
                                    <td class="align-middle fs-0 py-1">{{ $paid_item->id }}</td>
                                    <td class="align-middle subject py-1 pe-4">{{ $paid_item->invoice_number }}</td>
                                    <td class="align-middle subject py-1 pe-4">{{ fullName($paid_item->user_id) }}</td>
                                    <td class="align-middle subject py-1 pe-4">{{ parseDateOnly($paid_item->date) }}</td>
                                    <td class="align-middle subject py-1 pe-4">{{ $paid_item->total_customer_price.' '.currencySign() }}</td>
                                    <td class="align-middle subject py-1 pe-4">{{ $paid_item->total_tax.' '.currencySign() }}</td>
                                    <td class="align-middle subject py-1 pe-4">{{ $paid_item->total_price.' '.currencySign() }}</td>
                                    <td class="align-middle subject py-1 pe-4">-</td>
                                    <td class="align-middle subject py-1 pe-4 text-end">
                                        <div class="btn-group gap-2">
                                            <a href="/admin/view-invoice?id={{$paid_item->id}}" 
                                            title="Download Invice"
                                            class="btn btn-sm btn-falcon-primary rounded shadow-sm"><i class="far fa-file-pdf"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            @can('invoices-invoice-sent_to_email')
            <div class="modal" id="send-mail-modal" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
                <div class="modal-dialog" role="document" style="max-width: 700px">
                    <form id="sendMail" class="modal-content position-relative">
                        <div class="position-absolute top-0 end-0 mt-1 me-2 z-1">
                            <button type="button" class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-0">
                            <div class="rounded-top-3 py-3 ps-4 pe-6 bg-light">
                                <h4 class="mb-1">Send Mail </h4>
                            </div>
                            <div class="p-4 pb-0" id="input-area">

                                <h2 class="success-msg"></h2>
                                <input type="hidden" name="get_invoice_id" id="get_invoice_id" class="" />
                                <div id="emails-area"></div>
                                <div class="row justify-content-end mt-2">
                                    <div class="col-md-4 text-end">
                                        <button class="btn btn-falcon-primary" id="add-email" type="button">
                                            <span class="fe fe-plus"></span> Add New Email
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="col-form-label" for="template">Select Template:</label>
                                    <select name="template" id="template" class="form-control text-capitalize">
                                        <option value="">Select</option>
                                        @foreach($templates as $titem)
                                        <option value="{{$titem->id}}">{{Str::replace('_',' ', $titem->type)}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="em-body-view" style="width: 100%; display: block !important;"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary email-send-button" type="button"> Send </button>
                        </div>
                    </form>
                </div>
            </div>
            @endcan
        </div>
    </div>

    @push('js')
    <script src="{{ config('app.cdn_root') }}/public/vendors/datatables.net/jquery.dataTables.min.js"></script>
    <script src="{{ config('app.cdn_root') }}/public/vendors/datatables.net-bs5/dataTables.bootstrap5.min.js"></script>

    
    @can('invoices-invoice-sent_to_email')
    <script>
        document.addEventListener('livewire:init', function () {
            new DataTable('#paidInvoice');
            new DataTable('#unpaidInvoice');

            $(document).on('click', '.send-mail', function(){
                $('.em-body-view').html('');
                $('#emails-area').html('');
                $('.success-msg').removeClass('text-success text-center p-5').html('');
                $('.email-send-button').addClass('btn-primary').removeClass('btn-success disabled').text('Send');
                
                var id = $(this).data('invoice-id');
                $('#get_invoice_id').val(id);
                //Livewire.dispatch('setInvoiceId', { id: id });
                //@this.set('invoice_id', id);
                $('#send-mail-modal').modal('show');
            });
        });

        document.addEventListener('livewire:initialized', () => {
            new DataTable('#paidInvoice');
            new DataTable('#unpaidInvoice');
        });

        document.addEventListener('livewire:load', function () {
            new DataTable('#paidInvoice');
            new DataTable('#unpaidInvoice');
        });
    </script>

    <script>
        document.getElementById('template').addEventListener('change', function() {
            const templateId = this.value;
            const csrfToken  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            if (templateId) {
                fetch('/api/email-body', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken // Include CSRF token here
                    },
                    body: JSON.stringify({ id: templateId })
                })
                .then(response => response.json())
                .then(data => {

                    document.querySelector('.em-body-view').innerHTML = data.body;
                })
                .catch(error => console.error("Error fetching email body:", error));
            } else {
                document.querySelector('.em-body-view').innerHTML = ""; // Clear the body if no template is selected
            }
        });

        document.getElementById('add-email').addEventListener('click', function() {
            // Create a new container for the email input and delete button
            const emailContainer = document.createElement('div');
            emailContainer.className = 'email-container d-flex align-items-center mb-1';

            // Add the email input field
            emailContainer.innerHTML = `
                <input type="email" name="email[]" class="form-control me-2 multi_emails" placeholder="Enter email" />
                <button type="button" class="btn btn-danger btn-sm rounded-pill btn-sm delete-email" title="Remove Email"><span class="fe fe-x"></span></button>
            `;

            // Append the email container to the emails area
            document.querySelector('#emails-area').appendChild(emailContainer);

            // Add an event listener to the delete button
            emailContainer.querySelector('.delete-email').addEventListener('click', function() {
                emailContainer.remove(); // Remove the email container on delete
            });
        });
    </script>

    <script>
        $(document).on('click', '.email-send-button', function() {
            const formData = {
                invoice_id: $('#get_invoice_id').val(),
                emails: [], // Initialize an array to store multiple emails
                template_id: $('#template').val(),
            };

            // Collect all email values
            $('.multi_emails').each(function() {
                const email = $(this).val();
                if (email) { // Ensure that the email field is not empty
                    formData.emails.push(email);
                }
            });

            //console.log(formData);

            // Disable button and show loading state
            $(this).addClass('disabled').text('Sending...');

            $.ajax({
                url: '/api/send-invoices', // Adjust the API endpoint as needed
                type: 'POST',
                data: JSON.stringify(formData),
                contentType: 'application/json',
                success: function(response) {
                    // Handle success response
                    $('.success-msg').addClass('text-success text-center p-5').text('Invoice Sent Successful!');
                    $('.email-send-button').addClass('btn-success').text('Sent');

                    // Optional: Clear form fields after success
                    $('.em-body-view').html('');
                    $('#emails-area').html('');
                    // $('#input-area').html('<div class="text-center p-4 mb-5 text-success"><b>Invoice Sent Successfully.</b></div>');
                    //$('#send-mail-modal').modal('show');
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    $('.success-msg').text('failed. Please try again.');
                    $('.email-send-button').removeClass('disabled').text('Send');
                    console.error('Error:', error);
                }
            });
        });
    </script>

    
    @endcan

    @endpush

</div>