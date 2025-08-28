@if($row)
<div class="btn-group gap-1" wire:ignore>
    <a href="/admin/add-user?id={{$row->id}}&&type={{Str::ucfirst($role)}}" class="btn btn-falcon-light border btn-sm {{Route::currentRouteName() == 'add-user' ? 'bg-white' : ''}} " >View/Edit Customer</a>
    <a href="/admin/edit-secondary-info?id={{$row->id}}&&type={{Str::ucfirst($role)}}" class="btn btn-falcon-light border btn-sm {{Route::currentRouteName() == 'edit-secondary' ? 'bg-white' : ''}}" >Secondary Info</a>
    <a href="/admin/add-address?id={{$row->id}}&&type={{Str::ucfirst($role)}}" class="btn btn-falcon-light border btn-sm {{Route::currentRouteName() == 'add-addresses' ? 'bg-white' : ''}}" >Address</a>
    <a href="/admin/add-social-links?id={{$row->id}}&&type={{Str::ucfirst($role)}}" class="btn btn-falcon-light border btn-sm {{Route::currentRouteName() == 'add-social-links' ? 'bg-white' : ''}}" >Social Links</a>
    <a href="/admin/add-documents?id={{$row->id}}&&type={{Str::ucfirst($role)}}" class="btn btn-falcon-light border btn-sm {{Route::currentRouteName() == 'add-documents' ? 'bg-white' : ''}}" >Documents</a>
    @if($role == 'Customer')
    <a href="/admin/add-contact-person?id={{$row->id}}&&type={{Str::ucfirst($role)}}" class="btn btn-falcon-light border btn-sm {{Route::currentRouteName() == 'add-contact-person' ? 'bg-white' : ''}}" >Contact Person</a>
    <a href="/admin/add-new-services?id={{$row->id}}&&type={{Str::ucfirst($role)}}" class="btn btn-falcon-light border btn-sm {{Route::currentRouteName() == 'add-new-services' ? 'bg-white' : ''}}" >Services</a>
    @endif

    @if(role_name(Auth::id()) == 'Administrator')
    <a href="/admin/email-permissions?id={{$row->id}}&&type={{Str::ucfirst($role)}}" class="btn btn-falcon-light border btn-sm {{Route::currentRouteName() == 'email-permissions' ? 'bg-white' : ''}}">Email Permissions</a>
    @if(role_name($row->id) != role_name(Auth::id()))
    <a href="/admin/permissions?id={{$row->id}}&&type={{Str::ucfirst($role)}}" class="btn btn-falcon-light border btn-sm {{Route::currentRouteName() == 'permissions' ? 'bg-white' : ''}}">Permissions</a>
    @endif
    @endif

    @can('journal')
    <a href="/admin/journals?id={{$row->id}}&&type={{Str::ucfirst($role)}}" class="btn btn-falcon-light border btn-sm {{Route::currentRouteName() == 'user-journal-page' ? 'bg-white' : ''}}">Journals</a>
    @endcan
    <a href="/admin/impersonate/{{$row->id}}?type={{Str::ucfirst($role)}}" class="btn btn-danger border btn-sm {{Route::currentRouteName() == 'impersonate' ? 'bg-white' : ''}}">Auto Login</a>
</div>
@endif