<div>
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <div class="card mt-1 shadow-sm">

                <div class="card-header border-bottom border-200">
                    <div class="d-lg-flex justify-content-between">
                        <div class="col"><h4 class="">Journals</h4></div>
                        <div class="col-auto">
                            <form wire:submit.prevent="filter">
                                <div class="input-group">
                                    @if(role_name(Auth::user()->id) == 'Administrator')
                                    <label class="form-label pt-2" for="customer" style="padding-right: 3px;"> Customer : </label>
                                    <select class="form-select form-select-sm w-auto ms-auto" id="customer" wire:model="user_id">
                                        <option value="">Select</option>
                                        @foreach($customers as $customer)
                                        <option value="{{$customer->id}}">{{ fullName($customer->id) }}</option>
                                        @endforeach
                                    </select>
                                    @endif
                                    <label class="form-label mx-2 pt-2" for="job" >Job :</label>
                                    <select class="form-select form-select-sm w-auto ms-auto" id="job" wire:model="job_id">
                                        <option value="">Select</option>
                                        @foreach($jobs as $job)
                                        <option value="{{$job->id}}">{{ serviceName($job->service_id) }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-sm btn-primary border-300 hover-border-secondary">
                                        <span class="fa fa-search fs--1"></span> Filter
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm mb-0 fs--1 table-view-tickets">
                            <thead class="text-800 bg-light">
                                <tr>
                                    <th class="py-2 fs-0 pe-2">Job</th>
                                    <th class="sort align-middle ps-2" data-sort="user">User/Role</th>
                                    <th class="sort align-middle ps-2" data-sort="content">Content/Notes</th>
                                    <th class="sort align-middle ps-2" data-sort="content">Created at</th>
                                    <th class="sort align-middle ps-2 text-end" data-sort="content">Options</th>
                                </tr>
                            </thead>
                            <tbody class="list" id="table-ticket-body">
                                @foreach($journals_data as $j)
                                <tr>
                                    <td class="align-middle fs-0 py-1">{{$j['service_name']}}</td>
                                    <td class="align-middle fs-0 py-1">{{fullName($j['user_id'])}} <span class="badge rounded-pill bg-info">{{$j['role_name']}}</span> </td>
                                    <td class="align-middle fs-0 py-1">{{$j['journal']}} </td>
                                    <td class="align-middle fs-0 py-1">{{Carbon\Carbon::parse($j['updated_at'])->format('Y-m-d, H:i A')}} </td>
                                    <td class="align-middle content py-1 pe-4 text-end">
                                        <div class="btn-group">
                                            @can('journal-edit')
                                            <button class="btn btn-falcon-light btn-circle text-primary edit-journal" data-journal-id="{{$j['id']}}" data-journal-content="{{$j['journal']}}" data-job-id="{{$j['job_id']}}"><i class="fe fe-edit"></i></button>
                                            @endcan
                                            @can('journal-delete')
                                            <button class="btn btn-falcon-light btn-circle text-danger delete-journal" data-journal-id="{{$j['id']}}" data-job-id="{{$j['job_id']}}"><i class="fe fe-x"></i></button>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- journal edit -->

    <div class="modal fade" id="editing" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px">
            <div class="modal-content position-relative">
            <div class="position-absolute top-0 end-0 mt-2 me-2 z-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" id="close_button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="rounded-top-3 py-3 ps-4 pe-6 bg-light">
                <h4 class="mb-1" id="modalExampleDemoLabel"></h4>
                </div>
                <div class="p-4 pb-0">
                <form>
                    <div class="mb-3">
                        <input type="hidden" id="jobid" />
                        <input type="hidden" id="journal_id" />
                        <textarea class="form-control" id="journal-text" cols="30" rows="5"></textarea>
                    </div>
                </form>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="update_button" type="button"></button>
            </div>
            </div>
        </div>
    </div>

    @push('js')
    <script>
      $(document).on('click', '.edit-journal', function() {


        var journalId = $(this).data('journal-id');
        var jobId = $(this).data('job-id');
        var journalContent = $(this).data('journal-content');
        
        $('#editing').modal('show');

        $('#journal-text').val(journalContent);
        $('#jobid').val(jobId);
        $('#journal_id').val(journalId);
        $('#modalExampleDemoLabel').text('Edit Journal');
        $('#update_button').text('SAVE CHANGES');
        
      });

      $(document).on('click', '#close_button', function(){
        $('#editing').modal('hide');
        $('#journal-text').val('');
        $('#jobid').val('');
        $('#journal_id').val('');
      });

      $(document).on('click', '#update_button', function(){
        var userId    = '{{ Auth::id() }}';
        var roleName  = '{{ role_name(Auth::id()) }}';
        var journal   = $('#journal-text').val();
        var jobId     = $('#jobid').val();
        var journalId = $('#journal_id').val();

        if (journal) {
            
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
                    Livewire.dispatch('refreshJournals')
                    $('#editing').modal('hide');
                    $('#journal-text').val('');
                    toastr.success('Journal Updated successfully!');
                },
                error: function(xhr) {
                    alert('An error occurred. Please try again.');
                }
            });
        }
      });
    </script>
    

    <script>
        $(document).on('click', '.delete-journal', function(){

            var userId         = '{{ Auth::id() }}';
            var jobId          = $(this).data('job-id');
            var journalId      = $(this).data('journal-id');
            var journalContent = $(this).data('journal-content');
            var deleteButton   = $(this);
            var isConfirmed    = confirm('Are you sure you want to delete this journal?');

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
    @endpush

</div>
