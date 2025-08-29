<div>

    @include('backend.users-tabs')

    <div class="row mt-4">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <form wire:submit.prevent="saveChanges">
                <!-- Add new Customer -->
                <div class="card mb-2 shadow-sm">
                    <div class="card-header">
                        <div class="d-lg-flex justify-content-between">
                            <div class="col-auto"><b>{{ $row ? 'Update ' : 'Add New ' }} {{ $role }}</b></div>
                            <div class="col-auto">
                                <h3>{{ $row ? '(' . fullName($row->id) . ')' : '' }}</h3>
                            </div>
                            <div class="col-auto">
                                <a href="/admin/users?type={{ $role }}" class="btn btn-primary btn-sm">Back</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body bg-light">
                        <div class="row g-2 mb-2">
                            @if ($role == 'Customer')
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <label for="customer_type"><b>Customer Type :</b></label>

                                    <div class="input-group">
                                        <select wire:model.live="customer_type" id="customer_type" class="form-select">
                                            <option value="">Select</option>
                                            @foreach ($types as $titem)
                                                <option value="{{ $titem->name }}">{{ $titem->name }}</option>
                                            @endforeach
                                        </select>
                                        <button class="btn btn-falcon-primary btn-sm add-customer-type"
                                            type="button"><span class="fe fe-plus"></span></button>
                                    </div>
                                </div>
                            @endif
                            @if ($customer_type == 'Company')
                                <div
                                    class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="first_name"><b>Company Name :</b></label>
                                        <input type="text"
                                            class="form-control @error('first_name') is-invalid @enderror" placeholder="enter company name" wire:model="company_name" />
                                        @error('company_name')
                                            <small class="text-danger"><strong>{{ $message }}</strong></small>
                                        @enderror
                                    </div>
                                </div>
                            @else
                                <div
                                    class="col-sm-12 {{ $role == 'Customer' ? 'col-md-3 col-lg-3' : 'col-md-6 col-lg-6' }}">
                                    <div class="form-group">
                                        <label for="first_name"><b>First Name :</b></label>
                                        <input type="text"
                                            class="form-control @error('first_name') is-invalid @enderror"
                                            id="first_name" placeholder="enter first name" wire:model="first_name" />
                                        @error('first_name')
                                            <small class="text-danger"><strong>{{ $message }}</strong></small>
                                        @enderror
                                    </div>
                                </div>
                                <div
                                    class="col-sm-12 {{ $role == 'Customer' ? 'col-md-3 col-lg-3' : 'col-md-6 col-lg-6' }}">
                                    <div class="form-group">
                                        <label for="last_name"><b>Last Name :</b></label>
                                        <input type="text"
                                            class="form-control @error('last_name') is-invalid @enderror" id="last_name"
                                            placeholder="enter last name" wire:model="last_name" />
                                        @error('last_name')
                                            <small class="text-danger"><strong>{{ $message }}</strong></small>
                                        @enderror
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-sm-12 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label for="user_email"><b>Email :</b></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="user_email" placeholder="enter email address" wire:model="email" />
                                    @error('email')
                                        <small class="text-danger"><strong>{{ $message }}</strong></small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label for="phone"><b>Phone :</b></label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                        id="phone" placeholder="enter phone number" wire:model="phone" />
                                    @error('phone')
                                        <small class="text-danger"><strong>{{ $message }}</strong></small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label for="password"><b>Password :</b></label>
                                    <input type="text" class="form-control @error('password') is-invalid @enderror"
                                        placeholder="enter password" wire:model="password" />
                                    @error('password')
                                        <small class="text-danger"><strong>{{ $message }}</strong></small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-sm-12 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label for="phone"><b>Whatsapp ID:</b></label>
                                    <input type="text"
                                        class="form-control @error('whatsapp_id') is-invalid @enderror"
                                        placeholder="Enter Whatsapp id" wire:model="whatsapp_id" />
                                    @error('whatsapp_id')
                                        <small class="text-danger"><strong>{{ $message }}</strong></small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label for="phone"><b>Botsailor ID:</b></label>
                                    <input type="text"
                                        class="form-control @error('botsailor_id') is-invalid @enderror"
                                        placeholder="Enter Botsailor id" wire:model="botsailor_id" />
                                    @error('botsailor_id')
                                        <small class="text-danger"><strong>{{ $message }}</strong></small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label for="phone"><b>Telegram ID:</b></label>
                                    <input type="text"
                                        class="form-control @error('telegram_id') is-invalid @enderror"
                                        placeholder="Enter Telegram id" wire:model="telegram_id" />
                                    @error('telegram_id')
                                        <small class="text-danger"><strong>{{ $message }}</strong></small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        @if ($role == 'Employee')
                            <div class="row g-2 mb-2">
                                <div class="col-sm-12 col-md-4 col-lg-4">
                                    <label for="date_of_birth"><b>Date of Birth :</b></label>
                                    <input type="date" wire:model="date_of_birth" id="date_of_birth"
                                        class="form-control" />
                                </div>
                                <div class="col-sm-12 col-md-4 col-lg-4">
                                    <label for="street"><b>Street :</b></label>
                                    <input type="text" wire:model="street" id="street" class="form-control"
                                        placeholder="Street" />
                                </div>
                                <div class="col-sm-12 col-md-4 col-lg-4">
                                    <label for="postal_code"><b>Postal Code :</b></label>
                                    <input type="text" wire:model="postal_code" id="postal_code"
                                        class="form-control" placeholder="Postal Code" />
                                </div>
                            </div>
                            <div class="row g-2 mb-2">
                                <div class="col-sm-12 col-md-4 col-lg-4">
                                    <label for="city"><b> City :</b></label>
                                    <input type="text" wire:model="city" id="city" class="form-control"
                                        placeholder="City" />
                                </div>
                                <div class="col-sm-12 col-md-4 col-lg-4">
                                    <label for="country"><b>Country :</b></label>
                                    <input type="text" wire:model="country" id="country" class="form-control"
                                        placeholder="Country" />
                                </div>
                                <div class="col-sm-12 col-md-4 col-lg-4">
                                    <label for="nationality"><b>Nationality :</b></label>
                                    <input type="text" wire:model="nationality" id="nationality"
                                        class="form-control" placeholder="Nationality" />
                                </div>
                            </div>
                        @endif
                        @if (role_name(Auth::id()) == 'Administrator' || role_name(Auth::id()) == 'administrator')
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <label for="notes"><b>Notes :</b></label>
                                    <textarea wire:model="notes" id="notes" class="form-control" cols="30" rows="3"></textarea>
                                </div>
                            </div>
                        @endif
                        @if ($row)
                            @if ($role == 'Employee' || $role == 'employee')
                                <div class="row my-4">

                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <h4>Profile Picture</h4>
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-12 mb-5">

                                        <div class="avatar avatar-5xl">
                                            <img class="rounded-circle img-thumbnail shadow-sm"
                                                src="{{ photo($row->id) }}" width="200" alt="">
                                            <a href="{{ photo($row->id) }}" target="_blank"
                                                class="btn btn-falcon-default btn-sm my-2">View Profile Picture</a>

                                                <div class="col-12 mt-2">
                                        <label for="bank"><b>Change profile :</b></label>
                                        <input type="file" wire:model="uploadedProfile" class="form-control"
                                            placeholder="Bank" />
                                    </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <h4>Finance Information</h4>
                                    </div>
                                </div>
                                <div class="row g-2">
                                    <div class="col-sm-12 col-md-2 col-lg-2">
                                        <label for="currency"><b>Currency :</b></label>
                                        <select id="currency" wire:model="currency" class="form-select">
                                            <option value="">Select</option>
                                            <option value="€">€</option>
                                            <option value="$">$</option>
                                            <option value="£">£</option>
                                            <option value="lei">lei</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-12 col-md-2 col-lg-2">
                                        <label for="hourly_rate"><b>Tarrif :</b></label>
                                        <input type="number" class="form-control" id="hourly_rate" min="0"
                                            wire:model="hourly_rate" placeholder="hourly_rate" />
                                    </div>
                                    <div class="col-sm-12 col-md-4 col-lg-4">
                                        <label for="bank"><b>Bank :</b></label>
                                        <input type="text" wire:model="bank" id="bank" class="form-control"
                                            placeholder="Bank" />
                                    </div>
                                    <div class="col-sm-12 col-md-4 col-lg-4">
                                        <label class="form-label" for="bic"><b>BIC:</b></label>
                                        <input type="text" wire:model="bic" id="bic"
                                            class="form-control @error('bic') is-invalid @enderror"
                                            placeholder="Enter BIC">
                                    </div>
                                    <div class="col-sm-12 col-md-4 col-lg-4">
                                        <label for="iban"><b>IBan :</b></label>
                                        <input type="text" wire:model="iban" id="iban" class="form-control"
                                            placeholder="Iban" />
                                    </div>
                                    <div class="col-sm-12 col-md-4 col-lg-4">
                                        <label class="form-label" for="ust_idnr"><b>USt-IdNr:</b></label>
                                        <input type="text" wire:model="ust_idnr" id="ust_idnr"
                                            class="form-control @error('ust_idnr') is-invalid @enderror"
                                            placeholder="Enter USt-IdNr">
                                    </div>

                                    <div class="col-sm-12 col-md-4 col-lg-4">
                                        <label class="form-label" for="passport_no"><b>Passport no:</b></label>
                                        <input type="text" wire:model="passport_no" id="passport_no"
                                            class="form-control @error('passport_no') is-invalid @enderror"
                                            placeholder="Enter Passport no">
                                    </div>

                                    <div class="col-sm-12 col-md-4 col-lg-4">
                                        <label class="form-label" for="passport_expiry"><b>Passport expiry:</b></label>
                                        <input type="date" wire:model="passport_expiry" id="passport_expiry"
                                            class="form-control @error('passport_expiry') is-invalid @enderror"
                                            placeholder="Enter Passport expiry">
                                    </div>

                                    <div class="col-sm-12 col-md-4 col-lg-4">
                                        <label class="form-label" for="passport_picture"><b>Passport picture:</b></label>
                                        <input type="file" wire:model="uploadedPassportPicture" id="passport_picture"
                                            class="form-control @error('passport_picture') is-invalid @enderror"
                                            placeholder="Enter Passport picture">

                                            @if($passport_picture)
                                                <a href="{{ Storage::disk('public')->url($passport_picture) }}" class="" wire:loading.remove wire:target='uploadedPassportPicture'>View passport picture</a>
                                            @endif
                                            <div class="" wire:loading wire:target='uploadedPassportPicture'>Uploading picture....</div>
                                    </div>
                                </div>
                            @endif

                        @endif
                        @if (role_name(Auth::id()) == 'Administrator' || role_name(Auth::id()) == 'administrator')
                            <div class="row my-3">
                                <div class="col-sm-12 col-md-3 col-lg-3">
                                    <label for="access_mode"><b>Access Mode:</b></label>
                                    <select wire:model="access_mode" id="access_mode" class="form-control">
                                        <option value="Blocked">Blocked</option>
                                        <option value="Unblocked">Unblocked</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <label for="reason"><b>Blocking Reason:</b></label>
                                    <textarea wire:model="blocking_reason" id="reason" class="form-control" cols="30" rows="5"></textarea>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary" type="submit">{{ $row ? 'Update ' : 'Add' }}
                            {{ $role }}</button>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <!-- add new customer type -->
    <div class="modal" id="add-customer-type-modal" data-bs-backdrop="static" tabindex="-1" role="dialog"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px">
            <div class="modal-content position-relative">
                <div class="position-absolute z-1 end-0 top-0 me-2 mt-2">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                        data-bs-dismiss="modal" aria-label="Close" type="button"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="rounded-top-3 bg-light py-3 pe-6 ps-4">
                        <h4 class="mb-1" id="modalExampleDemoLabel"> Enter Customer Type:</h4>
                    </div>
                    <div class="p-5 pt-2">
                        <form id="typeFormData">
                            <div class="mb-3">
                                <label class="col-form-label" for="title">Enter Title:</label>
                                <input class="form-control" id="type_title" type="text"
                                    placeholder="Enter Title..." />
                                <b class="message-here"></b>
                            </div>
                            <button class="btn btn-falcon-primary submit-type-button" type="button"> Submit </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script>
            document.addEventListener('livewire:navigated', function() {
                // JavaScript function to handle group-wise "Check All" checkboxes
                const checkAllCheckboxes = (groupName, checked) => {
                    const groupCheckboxes = document.querySelectorAll(`.group-${groupName}`);
                    groupCheckboxes.forEach((checkbox) => {
                        checkbox.checked = checked;
                    });
                };

                // Add event listeners to the "Check All" checkboxes
                const checkAllCheckboxesInputs = document.querySelectorAll('.check-all');
                checkAllCheckboxesInputs.forEach((input) => {
                    input.addEventListener('change', (e) => {
                        const groupName = e.target.value;
                        const checked = e.target.checked;
                        checkAllCheckboxes(groupName, checked);
                    });
                });
            });

            /*for just DOM*/
            // JavaScript function to handle group-wise "Check All" checkboxes
            const checkAllCheckboxes = (groupName, checked) => {
                const groupCheckboxes = document.querySelectorAll(`.group-${groupName}`);
                groupCheckboxes.forEach((checkbox) => {
                    checkbox.checked = checked;
                });
            };

            // Add event listeners to the "Check All" checkboxes
            const checkAllCheckboxesInputs = document.querySelectorAll('.check-all');
            checkAllCheckboxesInputs.forEach((input) => {
                input.addEventListener('change', (e) => {
                    const groupName = e.target.value;
                    const checked = e.target.checked;
                    checkAllCheckboxes(groupName, checked);
                });
            });
        </script>

        <script>
            $(document).on('click', '.add-customer-type', function() {
                $('#add-customer-type-modal').modal('show');
                $('.submit-type-button').text('Submit');
                $('.message-here').addClass('text-success').text('');
                $('#type_title').val('');
            });

            $(document).on('click', '.submit-type-button', function() {

                // Gather form data
                const formData = {
                    name: $('#type_title').val()
                };

                $(this).html('Saving...');

                $.ajax({
                    url: '/api/saving-customer-type', // Adjust the API endpoint as needed
                    type: 'POST',
                    data: JSON.stringify(formData),
                    contentType: 'application/json',
                    success: function(response) {
                        // Hide the modal immediately
                        $('#add-customer-type-modal').modal('hide');

                        // Append new option from response data to the select element
                        const select = $('#customer_type');
                        if (response.data && response.data.name) {
                            const newOption = $('<option>', {
                                value: response.data.id,
                                text: response.data.name
                            });
                            select.append(newOption);
                        }
                        $('.message-here').addClass('text-success').text('Saved.');
                        alert('New Customer Type has been Added Successfully.');

                        // Optional: Clear form fields after success
                        $('#typeFormData')[0].reset();

                        // Display success message and update button text after a short delay
                        setTimeout(function() {
                            $('.submit-type-button').text('Saved.');
                        }, 3000); // Adjust delay as needed (500ms in this example)
                    },
                    error: function(xhr) {

                        // Handle error response
                        let errorMessage = 'An error occurred. Please try again.'; // Default error message

                        // Check if there's a specific error message from the server
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }


                        $('.message-here').removeClass('text-success').addClass('text-danger').text(
                            errorMessage);
                        $('.submit-type-button').text('Submit');
                    }
                });
            });
        </script>
    @endpush
</div>
