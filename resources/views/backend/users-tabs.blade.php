@if ($row)
    <div class="btn-group gap-1" wire:ignore>
        <a href="/admin/add-user?id={{ $row->id }}&&type={{ Str::ucfirst($role) }}"
            class="btn btn-falcon-light btn-sm {{ Route::currentRouteName() == 'add-user' ? 'bg-white' : '' }} border">View/Edit
            Customer</a>
        <a href="/admin/edit-secondary-info?id={{ $row->id }}&&type={{ Str::ucfirst($role) }}"
            class="btn btn-falcon-light btn-sm {{ Route::currentRouteName() == 'edit-secondary' ? 'bg-white' : '' }} border">Secondary
            Info</a>
        <a href="/admin/add-address?id={{ $row->id }}&&type={{ Str::ucfirst($role) }}"
            class="btn btn-falcon-light btn-sm {{ Route::currentRouteName() == 'add-addresses' ? 'bg-white' : '' }} border">Address</a>

            <a href="{{ route('add-salary', ['user_id' => $row->id]) }}"
            class="btn btn-falcon-light btn-sm {{ Route::currentRouteName() == 'add-salary' ? 'bg-white' : '' }} border">Salary</a>


        <a href="/admin/add-social-links?id={{ $row->id }}&&type={{ Str::ucfirst($role) }}"
            class="btn btn-falcon-light btn-sm {{ Route::currentRouteName() == 'add-social-links' ? 'bg-white' : '' }} border">Social
            Links</a>
        <a href="/admin/add-documents?id={{ $row->id }}&&type={{ Str::ucfirst($role) }}"
            class="btn btn-falcon-light btn-sm {{ Route::currentRouteName() == 'add-documents' ? 'bg-white' : '' }} border">Documents</a>
        @if ($role == 'Customer')
            <a href="/admin/add-contact-person?id={{ $row->id }}&&type={{ Str::ucfirst($role) }}"
                class="btn btn-falcon-light btn-sm {{ Route::currentRouteName() == 'add-contact-person' ? 'bg-white' : '' }} border">Contact
                Person</a>
            <a href="/admin/add-new-services?id={{ $row->id }}&&type={{ Str::ucfirst($role) }}"
                class="btn btn-falcon-light btn-sm {{ Route::currentRouteName() == 'add-new-services' ? 'bg-white' : '' }} border">Services</a>
        @endif

        @if (role_name(Auth::id()) == 'Administrator')
            <a href="/admin/email-permissions?id={{ $row->id }}&&type={{ Str::ucfirst($role) }}"
                class="btn btn-falcon-light btn-sm {{ Route::currentRouteName() == 'email-permissions' ? 'bg-white' : '' }} border">Email
                Permissions</a>
            @if (role_name($row->id) != role_name(Auth::id()))
                <a href="/admin/permissions?id={{ $row->id }}&&type={{ Str::ucfirst($role) }}"
                    class="btn btn-falcon-light btn-sm {{ Route::currentRouteName() == 'permissions' ? 'bg-white' : '' }} border">Permissions</a>
            @endif
        @endif

        @can('journal')
            <a href="/admin/journals?id={{ $row->id }}&&type={{ Str::ucfirst($role) }}"
                class="btn btn-falcon-light btn-sm {{ Route::currentRouteName() == 'user-journal-page' ? 'bg-white' : '' }} border">Journals</a>
        @endcan
        <a href="/admin/impersonate/{{ $row->id }}?type={{ Str::ucfirst($role) }}"
            class="btn btn-danger btn-sm {{ Route::currentRouteName() == 'impersonate' ? 'bg-white' : '' }} border">Auto
            Login</a>
    </div>
@endif
