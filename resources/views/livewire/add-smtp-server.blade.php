<div>
    <div class="row g-2">
        <div class="col-sm-12 col-md-6 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-gradient-theme">
                    <h3 class="card-title text-capitalize" wire:ignore>
                        {{Str::replace('-',' ', Route::currentRouteName())}} 
                        @if($row) 
                        <span class="badge rounded-pill {{ $row->status == 0 ? 'bg-danger' : 'bg-success' }}">{{ $row->status == 0 ? 'Inactive' : 'Active' }}</span> 
                        @endif
                    </h3>
                </div>
                <div class="card-body bg-light">
                    <form wire:submit.prevent="save">
                        <div class="row g-2">
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="mb-1">
                                    <label for="name"><b>Server Name:</b></label>
                                    <input type="text" wire:model="name" min="0" class="form-control @error('name') is-invalid @enderror form-control-border" placeholder="Enter Server Name">
                                    @error('name') <b class="text-danger">{{$message}}</b> @enderror
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="mb-1">
                                    <label for="hostname"><b>Host Name:</b></label>
                                    <input type="text" wire:model="hostname" class="form-control @error('hostname') is-invalid @enderror form-control-border" placeholder="Enter Host Name">
                                    @error('hostname') <b class="text-danger">{{$message}}</b> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="mb-1">
                                    <label for="username"><b>User Name:</b></label>
                                    <input type="text" wire:model="username" class="form-control @error('username') is-invalid @enderror form-control-border" placeholder="Enter User Name">
                                    @error('username') <b class="text-danger">{{$message}}</b> @enderror
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="mb-1">
                                    <label for="password"><b>Password:</b></label>
                                    <input type="text" wire:model="password" class="form-control @error('password') is-invalid @enderror form-control-border" placeholder="Enter Password">
                                    @error('password') <b class="text-danger">{{$message}}</b> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="mb-1">
                                    <label for="port"><b>Port Number:</b></label>
                                    <input type="number" min="0" wire:model="port" class="form-control @error('port') is-invalid @enderror form-control-border" placeholder="Enter Port Number">
                                    @error('port') <b class="text-danger">{{$message}}</b> @enderror
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="mb-1">
                                    <label for="encryption"><b>Encryption Type:</b></label>
                                    <select wire:model="encryption" id="encryption" class="form-control form-contorl-border">
                                        <option value="tls" select>tls</option>
                                        <option value="ssl">ssl</option>
                                    </select>
                                    @error('encryption') <b class="text-danger">{{$message}}</b> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="mb-1">
                                    <label for="hourly_limit"><b>From Address:</b></label>
                                    <input type="email" wire:model="from_address" class="form-control @error('from_address') is-invalid @enderror form-control-border" placeholder="Enter Email Addres">
                                    @error('from_address') <b class="text-danger">{{$message}}</b> @enderror
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="mb-1">
                                    <label for="hourly_limit"><b>Hourly Limit:</b></label>
                                    <input type="number" min="0" wire:model="hourly_limit" class="form-control @error('hourly_limit') is-invalid @enderror form-control-border" placeholder="Enter Sending Hourly Limit">
                                    @error('hourly_limit') <b class="text-danger">{{$message}}</b> @enderror
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group mt-2">
                            <button type="submit" class="btn btn-falcon-primary text-capitalize">

                                <div wire:loading wire:target="save">
                                    <div class="la-ball-clip-rotate-multiple la-sm">
                                        <div></div>
                                        <div></div>
                                    </div>
                                </div>

                                &nbsp; {{$row ? 'Update Server' : 'Save'}}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header"><b>Test SMTP</b></div>
                <div class="card-body bg-light">
                    <form wire:submit.prevent="testSmtp">
                        <div class="mb-3">
                            <label for="to"><b>Your Destination Email Address to Send Mail:</b></label>
                            <div class="input-group">
                                <input type="email" wire:model="to" class="form-control form-control-md" id="to" placeholder="to Email Address" />
                                <button type="submit" class="btn btn-falcon-primary input-group-text">
                                    Send Test Email
                                </button>                                
                            </div>
                            @error('to') <b class="text-danger">{{$message}}</b> @enderror
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
