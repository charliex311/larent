<div>
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <div class="card overflow-hidden mt-3">
                <div class="card-header p-0 bg-light scrollbar-overlay">
                    <ul class="nav nav-tabs border-0 tab-tickets-status flex-nowrap" id="in-depth-chart-tab"
                        role="tablist">
                        <li class="nav-item text-nowrap" role="presentation">
                            <a href="/admin/settings" class="nav-link mb-0 d-flex align-items-center gap-2 py-3 px-x1 {{ Route::currentRouteName()=='settings'?'active':'' }}"  wire:navigate>
                                <span class="far fa-user-circle icon text-600"></span>
                                <h6 class="mb-0 text-600">Profile Settings</h6>
                            </a>
                        </li>
                        @if(role_name(Auth::user()->id) != 'Administrator')
                            @can('settings-upload-documents')
                            <li class="nav-item text-nowrap" role="presentation">
                                <a href="/admin/document-page" class="nav-link mb-0 d-flex align-items-center gap-2 py-3 px-x1 {{ Route::currentRouteName()=='document-page'?'active':'' }}" wire:navigate>
                                    <span class="fas fa-envelope-open-text icon text-600"></span>
                                    <h6 class="mb-0 text-600">Documents</h6>
                                </a>
                            </li>
                            @endcan
                        @endif
                    </ul>
                </div>
                <div class="card-body p-0"> </div>
            </div>

            <div class="row mt-2">
                <div class="col-sm-12 col-md-12 col-lg-12">

                    <form wire:submit.prevent="saveChanges">
                        <div class="card mb-3 shadow-sm">
                            <div class="card-header position-relative min-vh-25 mb-7">
                                <div class="cover-image">
                                    <div class="bg-holder rounded-3 rounded-bottom-0" style="background-image:url({{asset('public/assets/img/4.jpg')}});">
                                    </div>
                                </div>
                                <div class="avatar avatar-5xl avatar-profile shadow-sm img-thumbnail rounded-circle">
                                    <div class="h-100 w-100 rounded-circle overflow-hidden position-relative"> 
                                        <img src="{{Auth::user()->photo}}" width="200" alt="" data-dz-thumbnail="data-dz-thumbnail" />
                                        <input class="d-none" id="profile-image" type="file" wire:model.live="myphoto" />
                                        <label class="mb-0 overlay-icon d-flex flex-center" for="profile-image">
                                            <span class="bg-holder overlay overlay-0"></span>
                                            <span class="z-1 text-white dark__text-white text-center fs--1">
                                                <span class="fas fa-camera"></span>
                                                <span class="d-block">Upload Photo</span>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body bg-light pb-5">
                                <div class="row mb-3 g-1">
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <label for="fname"><b>First Name:</b></label>
                                        <input type="text" id="fname" class="form-control @error('first_name') @enderror" placeholder="Enter Your First Name" wire:model="first_name" />
                                        @error('first_name') <small class="text-danger"><b>{{$message}}</b></small> @enderror
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <label for="lname"><b>Last Name:</b></label>
                                        <input type="text" id="lname" class="form-control @error('last_name') @enderror" placeholder="Enter Your Last Name" wire:model="last_name" />
                                        @error('last_name') <small class="text-danger"><b>{{$message}}</b></small> @enderror
                                    </div>
                                </div>
                                <div class="row mb-3 g-1">
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <label class="form-label" for="company"><b>Company:</b></label>
                                        <input type="text" wire:model="company" id="company" class="form-control @error('company') is-invalid @enderror" placeholder="Enter Company Name">
                                        @error('company') <small class="text-danger"><b>{{$message}}</b></small> @enderror
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <label for="phone"><b>Phone Number:</b></label>
                                        <input type="text" id="phone" class="form-control @error('phone') @enderror" placeholder="Enter Your Phone" wire:model="phone" />
                                        @error('phone') <small class="text-danger"><b>{{$message}}</b></small> @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 g-2">
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <label for="email"><b>Email:</b></label>
                                        <input type="email" id="email" class="form-control @error('email') @enderror" placeholder="Enter Your Email" wire:model="email" readonly />
                                        @error('email') <small class="text-danger"><b>{{$message}}</b></small> @enderror
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <label class="form-label" for="website"><b>Website:</b></label>
                                        <input type="text" wire:model="website" id="website" class="form-control @error('website') is-invalid @enderror" placeholder="Enter Website">
                                        @error('website') <small class="text-danger"><b>{{$message}}</b></small> @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <label class="form-label" for="street"><b>Street:</b></label>
                                        <textarea wire:model="street" id="street" class="form-control @error('street') is-invalid @enderror" cols="30" rows="1"></textarea>
                                        @error('street') <small class="text-danger"><b>{{$message}}</b></small> @enderror
                                    </div>
                                </div>
                                <div class="row g-1">
                                    <div class="col-sm-12 col-md-4 col-lg-4">
                                        <label class="form-label" for="postal_code"><b>Postal Code:</b></label>
                                        <input type="text" wire:model="postal_code" id="postal_code" class="form-control @error('postal_code') is-invalid @enderror">
                                        @error('postal_code') <small class="text-danger"><b>{{$message}}</b></small> @enderror
                                    </div>
                                    <div class="col-sm-12 col-md-4 col-lg-4">
                                        <label class="form-label" for="city"><b>City:</b></label>
                                        <input type="text" wire:model="city" id="city" class="form-control @error('city') is-invalid @enderror">
                                        @error('city') <small class="text-danger"><b>{{$message}}</b></small> @enderror
                                    </div>
                                    <div class="col-sm-12 col-md-4 col-lg-4">
                                        <label class="form-label" for="country"><b>Country:</b></label>
                                        <input type="text" wire:model="country" id="country" class="form-control @error('country') is-invalid @enderror">
                                        @error('country') <small class="text-danger"><b>{{$message}}</b></small> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if(role_name(Auth::user()->id) == 'Administrator')

                        <div class="card mb-3 shadow-sm">
                            <div class="card-header"><b>Billing</b></div>
                            <div class="card-body bg-light">
                                <div class="row g-2">
                                    <div class="col-lg-6 col-md-6 col-sm-12 mb-1">
                                        <label class="form-label" for="invoice_prefix"><b>Invoice Prefix:</b></label>
                                        <input type="text" value="{{$invoice_prefix}}" id="invoice_prefix" class="form-control" readonly />
                                        @error('invoice_prefix') <small class="text-danger"><b>{{$message}}</b></small> @enderror
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 mb-1">
                                        <label class="form-label" for="invoice_number"><b>Invoice Number:</b></label>
                                        <input type="text" wire:model="invoice_number" id="invoice_number" class="form-control @error('invoice_number') is-invalid @enderror">
                                        @error('invoice_number') <small class="text-danger"><b>{{$message}}</b></small> @enderror
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 mb-1">
                                        <label class="form-label" for="invoice_text"><b>Invoice Text:</b></label>
                                        <textarea wire:model="invoice_text" id="invoice_text" class="form-control @error('invoice_text') is-invalid @enderror" cols="30" rows="3"></textarea>
                                        @error('invoice_text') <small class="text-danger"><b>{{$message}}</b></small> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        @endif

                        <div class="card mt-3 shadow-sm">
                            <div class="card-header "><b>Bank Data</b></div>
                            <div class="card-body bg-light">
                                <div class="row px-4 pt-3 pb-3">
                                    <div class="col-lg-12">

                                        <div class="row g-2">                                            
                                            <div class="col-lg-4 col-md-4 col-sm-12 mb-1">
                                                <label class="form-label" for="bank"><b>Bank:</b></label>
                                                <input type="text" wire:model="bank" id="bank" class="form-control @error('bank') is-invalid @enderror" placeholder="Enter Bank" @if(role_name(Auth::user()->id) == 'Employee') readonly @endif>
                                                @error('bank') <small class="text-danger"><b>{{$message}}</b></small> @enderror
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-12 mb-1">
                                                <label class="form-label" for="bic"><b>BIC:</b></label>
                                                <input type="text" wire:model="bic" id="bic" class="form-control @error('bic') is-invalid @enderror" placeholder="Enter BIC" @if(role_name(Auth::user()->id) == 'Employee') readonly @endif>
                                                @error('bic') <small class="text-danger"><b>{{$message}}</b></small> @enderror
                                            </div>
                                            
                                            <div class="col-lg-4 col-md-4 col-sm-12 mb-1">
                                                <label class="form-label" for="iban"><b>IBAN:</b></label>
                                                <input type="text" wire:model="iban" id="iban" class="form-control @error('iban') is-invalid @enderror" placeholder="Enter IBAN" @if(role_name(Auth::user()->id) == 'Employee') readonly @endif>
                                                @error('iban') <small class="text-danger"><b>{{$message}}</b></small> @enderror
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-12 mb-1">
                                                <label class="form-label" for="ust_idnr"><b>USt-IdNr:</b></label>
                                                <input type="text" wire:model="ust_idnr" id="ust_idnr" class="form-control @error('ust_idnr') is-invalid @enderror" placeholder="Enter USt-IdNr" @if(role_name(Auth::user()->id) == 'Employee') readonly @endif>
                                                @error('ust_idnr') <small class="text-danger"><b>{{$message}}</b></small> @enderror
                                            </div>
                                            
                                            <div class="col-lg-4 col-md-4 col-sm-12 mb-1">
                                                <label class="form-label"><b>Business Number:</b></label>
                                                <input type="text" wire:model="business_number" id="business_number" class="form-control @error('business_number') is-invalid @enderror" placeholder="Enter Business Number" @if(role_name(Auth::user()->id) == 'Employee') readonly @endif>
                                                @error('business_number') <small class="text-danger"><b>{{$message}}</b></small> @enderror
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-12 mb-1">
                                                <label class="form-label" for="fiscal_number"><b>Fiscal Number:</b></label>
                                                <input type="text" wire:model="fiscal_number" id="fiscal_number" class="form-control @error('fiscal_number') is-invalid @enderror" placeholder="Enter Fiscal Number" @if(role_name(Auth::user()->id) == 'Employee') readonly @endif>
                                                @error('fiscal_number') <small class="text-danger"><b>{{$message}}</b></small> @enderror
                                            </div>        
                                        </div>

                                    </div>
                                </div>
                            </div>
                            @can('settings-update')
                            <div class="card-footer">
                                <div class="row mt-3">
                                    <div class="col-lg-3 col-md-3 col-sm-12">
                                        <button class="btn btn-primary" type="submit">Update</button>
                                    </div>
                                </div>
                            </div>
                            @endcan
                        </div>
                    </form>

                </div>
            </div>
            
        </div>
    </div>

    @push('js')
    <script>
    $(function() {
        $('#date_of_birth').flatpickr({
            time_24hr: false,
            enableTime: false,
            dateFormat: "d-m-Y",
        });
    });
    </script>
    @endpush
</div>