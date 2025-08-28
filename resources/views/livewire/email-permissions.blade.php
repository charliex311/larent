<div>
    <div>
        @include('backend.users-tabs')

        <div class="row mt-4">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <form wire:submit.prevent="saveChanges">
                    <div class="card mb-2 shadow-sm">
                        <div class="card-header">
                            <div class="d-lg-flex justify-content-between">
                                <div class="col-auto"><b>Email Preference</b></div>
                                <div class="col-auto"><h3>{{ $row ? '('.fullName($row->id).')' : ''}}</h3></div>
                                <div class="col-auto">
                                    <a href="/admin/users?type={{$role}}" class="btn btn-primary btn-sm">Back</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">

                            @if(role_name(Auth::id()) == 'Administrator')
                            <div class="mb-3">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" id="emails1" type="checkbox" value="yes" wire:model="notification" @if($notification == 'yes') checked="" @endif />
                                    <label class="form-check-label" for="emails1">Enable Email Notifications.</label>
                                </div>
                            </div>

                            <button class="btn btn-primary" type="button" wire:click="update">Update</button>

                            @else

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" id="emails2" type="checkbox" value="yes" disabled="" @if($notification == 'yes') checked="" @endif />
                                <label class="form-check-label" for="emails2">Enable Email Notifications.</label>
                            </div>

                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
