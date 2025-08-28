<div>
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <div class="row flex-between-center">
                        <div class="col-auto">
                            Payment Methods
                        </div>
                        <div class="col-auto">
                            @can('payment-add')
                            @endcan
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Payment Method Name</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($lists as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center position-relative">
                                            <img class="rounded-1 border border-200" src="{{$item->logo}}" width="100" alt="">
                                            <div class="flex-1 ms-3">
                                                <h6 class="mb-1 fw-semi-bold"><a class="text-dark stretched-link" href="#!">{{$item->name}}</a></h6>
                                                <span class="badge rounded-pill {{$item->status == 'enable' ? 'bg-success' : 'bg-danger'}} ">{{$item->status}}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        <div class="btn-group gap-2">
                                            @can('payment-edit')
                                            <button
                                            wire:click="edit({{$item->id}})"
                                            data-name="{{$item->name}}"
                                            class="btn btn-falcon-primary btn-sm edit-button" 
                                            type="buton"><i class="fe fe-edit"></i></button>
                                            @endcan
                                            @can('payment-delete')
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row flex-between-center">
                        <div class="col-auto">
                            <strong>Showing {{ $lists->firstItem() }} - {{ $lists->lastItem() }} of {{ $lists->total() }}</strong>
                        </div>
                        <div class="col-auto">{{ $lists->links() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- add edit modal -->
    @canany(['payment-add','payment-edit'])
    <div class="modal" id="addEditModal" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" wire:ignore.stream_get_line>
        <div class="modal-dialog modal-md" role="document">
            <form wire:submit.prevent="saveChanges" class="modal-content position-relative">
                <div class="position-absolute top-0 end-0 mt-2 me-2 z-1">
                    <button type="button" class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="rounded-top-3 py-3 ps-4 pe-6 bg-light">
                    <h4 class="mb-1" id="modalExampleDemoLabel">{{ $row ? 'Edit' : 'Add New' }} </h4>
                    </div>
                    <div class="p-4 pb-0">
                        <div class="mb-3">
                            <label class="col-form-label" for="logo">Logo:</label>
                            <input class="form-control @error('mylogo') is-invalid @enderror" id="logo" wire:model="mylogo" type="file" />
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label" for="method_name">Payment Method Name:</label>
                            <input class="form-control @error('name') is-invalid @enderror" id="method_name" type="text" wire:model="name" />
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label" for="mytextarea">Details:</label>
                            <textarea id="mytextarea" wire:model="details" class="form-control @error('details') is-invalid @enderror" cols="30" rows="10"></textarea>
                        </div>
                        
                        <div class="mb-3 stripe_block">
                            <label for="pk">Public Key:</label>
                            <textarea name="pk" id="pk" class="form-control" wire:model="stripe_public_key" cols="30" rows="3"></textarea>
                        </div>
                        <div class="mb-3 stripe_block">
                            <label for="sk">Secret Key:</label>
                            <textarea name="sk" id="sk" class="form-control" wire:model="stripe_secret_key" cols="30" rows="3"></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label class="col-form-label" for="mytextarea">Status:</label>
                            <select class="form-select @error('status') is-invalid @enderror" wire:model="status" aria-label="Default select example">
                                <option value="">Select Status</option>
                                <option value="enable">Enable</option>
                                <option value="disable">Disable</option>
                            </select>
                        </div>
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit"> {{ $row ? 'Save Changes' : 'Save' }} </button>
                </div>
            </form>
        </div>
    </div>
    @endcan

    @push('js')
    <script>
        $(document).on('click', '.edit-button', function() {
            $('#addEditModal').modal('show');

            var name = $(this).data('name');
            if (name === 'Stripe' || name === 'stripe') {
                $('.stripe_block').show();
            } else {
                $('.stripe_block').hide(); 
            }
        });
    </script>
    @endpush
</div>
