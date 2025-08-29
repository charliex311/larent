<div>

    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <div class="row flex-between-center">
                        <div class="col-auto">
                            <h4>Add Service</h4>
                        </div>
                        <div class="col-auto">
                            @if ($row)
                                <span class="badge rounded-pill bg-primary">Created Date :
                                    {{ systemFormattedDateTime($row->created_at) }}</span>
                                <span class="badge rounded-pill bg-info">Last Modified:
                                    {{ systemFormattedDateTime($row->updated_at) }}</span>
                            @endif
                            <a href="/admin/services" class="btn btn-primary btn-sm">Back</a>
                        </div>
                    </div>
                </div>
                <div class="card-body bg-light p-5">
                    <form wire:submit.prevent="saveChanges">
                        <div class="row mb-3">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <label for="title" class="text-capitalize"><b>Service Name :</b></label>
                                <input type="text" wire:model="title"
                                    class="form-control form-control-lg @error('title') is-invalid @enderror"
                                    id="title" placeholder="Enter Service Name here..." />
                                @error('title')
                                    <small class="text-danger"><b>{{ $message }}</b></small>
                                @enderror
                            </div>
                        </div>
                        <div class="row g-1 mb-3">
                            <div class="col-sm-12 col-md-2 col-lg-2">
                                <label for="unit" class="text-capitalize"><b>Unit :</b></label>
                                <select wire:model="unit" id="unit" class="form-select">
                                    <option value="hour">Hours</option>
                                    <option value="day">Day</option>
                                    <option value="km">km</option>
                                    <option value="m2">m2</option>
                                    <option value="qm">qm</option>
                                    <option value="pcs">pcs</option>
                                    <option value="flat rate">flat rate</option>
                                </select>
                                @error('unit')
                                    <small class="text-danger"><b>{{ $message }}</b></small>
                                @enderror
                            </div>
                            <div class="col-sm-12 col-md-2 col-lg-2">
                                <label for="unit" class="text-capitalize"><b>Currency :</b></label>
                                <select wire:model="unit" id="unit" class="form-select">
                                    <option value="€">€</option>
                                    <option value="$">$</option>
                                    <option value="£">£</option>
                                    <option value="lei">lei</option>
                                </select>
                                @error('unit')
                                    <small class="text-danger"><b>{{ $message }}</b></small>
                                @enderror
                            </div>
                            <div class="col-sm-12 col-md-2 col-lg-2">
                                <label for="price" class="text-capitalize"><b>Price :</b></label>
                                <input type="number" step="any" min="0.0" wire:model="price"
                                    wire:key="triggerCalTaxVal" wire:keydown.debounce.300ms="triggerCalTaxVal"
                                    class="form-control @error('price') is-invalid @enderror" id="price"
                                    placeholder="Enter price..." />
                                @error('price')
                                    <small class="text-danger"><b>{{ $message }}</b></small>
                                @enderror
                            </div>
                            <div class="col-sm-12 col-md-2 col-lg-2">
                                <label for="tax" class="text-capitalize"><b>Tax% :</b></label>
                                <input type="number" step="any" min="0.0" wire:model="tax"
                                    wire:key="triggerCalTaxVal" wire:keydown.debounce.300ms="triggerCalTaxVal"
                                    class="form-control @error('tax') is-invalid @enderror" id="tax"
                                    placeholder="Enter tax..." />
                                @error('tax')
                                    <small class="text-danger"><b>{{ $message }}</b></small>
                                @enderror
                            </div>
                            <div class="col-sm-12 col-md-2 col-lg-2">
                                <label for="tax_value" class="text-capitalize"><b>Tax Value :</b></label>
                                <input type="number" step="2" min="0.0" wire:model="tax_value"
                                    class="form-control @error('tax_value') is-invalid @enderror bg-light"
                                    id="tax_value" readonly />
                                @error('tax_value')
                                    <small class="text-danger"><b>{{ $message }}</b></small>
                                @enderror
                            </div>
                            <div class="col-sm-12 col-md-2 col-lg-2">
                                <label for="total_price" class="text-capitalize"><b>Total Price :</b></label>
                                <input type="number" step="any" min="0.0" wire:model="total_price"
                                    class="form-control @error('total_price') is-invalid @enderror bg-light"
                                    id="total_price" readonly />
                                @error('total_price')
                                    <small class="text-danger"><b>{{ $message }}</b></small>
                                @enderror
                            </div>
                        </div>
                        <div class="row g-1 mb-4">
                            <!--div class="col-sm-12 col-md-2 col-lg-2">
                                <label for="status" class="text-capitalize"><b>Status :</b></label>
                                <select wire:model="status" id="status" class="form-control">
                                    <option value="0">Pending</option>
                                    <option value="1">Active</option>
                                    <option value="2">Inactive</option>
                                </select>
                                @error('status')
    <small class="text-danger"><b>{{ $message }}</b></small>
@enderror
                            </div-->
                        </div>
                        <div class="mb-4" x-data="{ isAddress: $wire.is_address }">

                            <div class="row">
                                <div class="col-sm-12 col-md-2 col-lg-2">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" id="is_Address" type="checkbox"
                                            x-model="isAddress" wire:model="is_address" />
                                        <label class="form-check-label" for="is_Address"><b>Address</b></label>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3 mb-3" x-show="isAddress">
                                <div class="col-sm-12 col-md-3 col-lg-3">
                                    <label for="address"><b>Street Address :</b></label>
                                    <textarea wire:model="address" class="form-control @error('address') is-invalid @enderror" id="address"
                                        cols="30" rows="2" placeholder="Enter Address"></textarea>
                                    @error('address')
                                        <small class="text-danger"><b>{{ $message }}</b></small>
                                    @enderror
                                </div>
                                <div class="col-sm-12 col-md-3 col-lg-3">
                                    <label for="postal_code" class="text-capitalize"><b>Postal Code :</b></label>
                                    <input type="text" wire:model="postal_code"
                                        class="form-control @error('postal_code') is-invalid @enderror"
                                        id="postal_code" placeholder="Enter postal code" />
                                    @error('postal_code')
                                        <small class="text-danger"><b>{{ $message }}</b></small>
                                    @enderror
                                </div>
                                <div class="col-sm-12 col-md-3 col-lg-3">
                                    <label for="city" class="text-capitalize"><b>City :</b></label>
                                    <input type="text" value="{{ $city }}"
                                        class="form-control @error('city') is-invalid @enderror" id="city"
                                        placeholder="city" disabled />
                                    @error('city')
                                        <small class="text-danger"><b>{{ $message }}</b></small>
                                    @enderror
                                </div>
                                <div class="col-sm-12 col-md-3 col-lg-3">
                                    <label for="country" class="text-capitalize"><b>Country :</b></label>
                                    <input type="text" value="{{ $country }}"
                                        class="form-control @error('country') is-invalid @enderror" id="country"
                                        placeholder="country" disabled />
                                    @error('country')
                                        <small class="text-danger"><b>{{ $message }}</b></small>
                                    @enderror
                                </div>
                            </div>

                            <div class="row g-3 mb-4" x-show="isAddress">
                                <div class="col-sm-12 col-md-3 col-lg-3">
                                    <label for="box_code" class="text-capitalize"><b>Box Code :</b></label>
                                    <input type="text" wire:model="box_code"
                                        class="form-control @error('box_code') is-invalid @enderror" id="box_code"
                                        placeholder="box code" />
                                    @error('box_code')
                                        <small class="text-danger"><b>{{ $message }}</b></small>
                                    @enderror
                                </div>
                                <div class="col-sm-12 col-md-3 col-lg-3">
                                    <label for="client_code" class="text-capitalize"><b>Client Code :</b></label>
                                    <input type="text" wire:model="client_code"
                                        class="form-control @error('client_code') is-invalid @enderror"
                                        id="client_code" placeholder="Client Code" />
                                    @error('client_code')
                                        <small class="text-danger"><b>{{ $message }}</b></small>
                                    @enderror
                                </div>
                                <div class="col-sm-12 col-md-3 col-lg-3">
                                    <label for="deposit_code" class="text-capitalize"><b>Deposit Code :</b></label>
                                    <input type="text" wire:model="deposit_code"
                                        class="form-control @error('deposit_code') is-invalid @enderror"
                                        id="deposit_code" placeholder="Deposit Code" />
                                    @error('deposit_code')
                                        <small class="text-danger"><b>{{ $message }}</b></small>
                                    @enderror
                                </div>
                                <div class="col-sm-12 col-md-3 col-lg-3">
                                    <label for="access_phone" class="text-capitalize"><b>Access Phone :</b></label>
                                    <input type="text" wire:model="access_phone"
                                        class="form-control @error('access_phone') is-invalid @enderror"
                                        id="access_phone" placeholder="Access Phone" />
                                    @error('access_phone')
                                        <small class="text-danger"><b>{{ $message }}</b></small>
                                    @enderror
                                </div>
                                <div class="col-sm-12 col-md-3 col-lg-3">
                                    <label for="floor_number" class="text-capitalize"><b>Floor Number :</b></label>
                                    <input type="text" wire:model="floor_number"
                                        class="form-control @error('floor_number') is-invalid @enderror"
                                        id="floor_number" placeholder="Floor Number" />
                                    @error('floor_number')
                                        <small class="text-danger"><b>{{ $message }}</b></small>
                                    @enderror
                                </div>
                                <div class="col-sm-12 col-md-3 col-lg-3">
                                    <label for="house_number" class="text-capitalize"><b>House Number :</b></label>
                                    <input type="text" wire:model="house_number"
                                        class="form-control @error('house_number') is-invalid @enderror"
                                        id="house_number" placeholder="House Number" />
                                    @error('house_number')
                                        <small class="text-danger"><b>{{ $message }}</b></small>
                                    @enderror
                                </div>
                            </div>

                            @if ($row)
                                <div class="mb-5 mt-5">
                                    <div class="row justify-content-between">
                                        <div class="col-md-12">
                                            <div class="card shadow-none">
                                                <div class="card-header">
                                                    <div class="row flex-between-center">
                                                        <div class="col-auto">Images / Videos</div>
                                                        <div class="col-auto">
                                                            <button class="btn btn-sm btn-primary add-files"
                                                                type="button"
                                                                data-service-id="{{ $row->id }}">Add
                                                                Files</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="table-responsive scrollbar">
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col">Name</th>
                                                                    <th scope="col">File</th>
                                                                    <th class="text-end" scope="col">Actions</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach (json_decode($row->files) ?? [] as $fkey => $uidn)
                                                                    <tr>
                                                                        <td>{{ $uidn->caption ?? 'n/a' }}</td>
                                                                        <td>
                                                                            <a href="{{ $uidn->file }}"
                                                                                target="_blank">{{ Str::replace(config('app.cdn_domain') . '/uploads/', ' ', $uidn->file) }}</a>
                                                                        </td>
                                                                        <td class="text-end">
                                                                            <div>
                                                                                <button class="btn btn-link ms-2 p-0"
                                                                                    wire:click="delete({{ $fkey }},{{ $row->id }})"
                                                                                    type="button"
                                                                                    data-bs-toggle="tooltip"
                                                                                    data-bs-placement="top"
                                                                                    title="Delete"><span
                                                                                        class="text-500 fas fa-trash-alt"></span></button>
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
                                </div>

                                <div class="mb-5 mt-5">
                                    <div class="row justify-content-between">
                                        <div class="col-md-12">
                                            <div class="card shadow-none">
                                                <div class="card-header">
                                                    <div class="row flex-between-center">
                                                        <div class="col-auto">Images / Videos</div>
                                                        <div class="col-auto">
                                                            <button class="btn btn-sm btn-primary" type="button"
                                                                data-toggle="modal" id="productAddModalButton">Add
                                                                Product</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="table-responsive scrollbar">
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col">Name</th>
                                                                    <th scope="col">Price</th>
                                                                    <th class="text-end" scope="col">Actions</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($optionalProducts ?? [] as $product)
                                                                    <tr>
                                                                        <td>{{ $product->product->name ?? 'n/a' }}</td>
                                                                        <td>
                                                                            {{ $product->product->currency ?? 'n/a' }}
                                                                            {{ $product->product->add_on_price ?? 'n/a' }}
                                                                        </td>
                                                                        <td class="text-end">
                                                                            <div>
                                                                                <button class="btn btn-link ms-2 p-0"
                                                                                    wire:click="deleteOptionalProduct({{ $product->id }})"
                                                                                    type="button"
                                                                                    data-bs-toggle="tooltip"
                                                                                    data-bs-placement="top"
                                                                                    title="Delete"><span
                                                                                        class="text-500 fas fa-trash-alt"></span></button>
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
                                </div>
                            @endif

                            <button class="btn btn-primary mb-1 me-1"
                                type="submit">{{ $row ? 'Save Changes' : 'Submit' }}</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- modal for uploading -->
        <div class="modal" id="files-modal" data-bs-backdrop="static" tabindex="-1" role="dialog"
            aria-hidden="true">
            <div class="modal-dialog" role="document" style="max-width: 600px">
                <div class="modal-content">
                    <form action="/api/upload-single-via-ftp" method="POST" class="modal-content position-relative"
                        enctype="multipart/form-data">
                        <div class="position-absolute z-1 end-0 top-0 me-2 mt-2">
                            <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                                data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-0">
                            <div class="rounded-top-3 bg-light py-3 pe-6 ps-4">
                                <h4 class="mb-1" id="">Add Image / Video</h4>
                            </div>
                            <div class="p-4 pb-0">
                                @csrf
                                <input type="hidden" name="upload_id" id="upload_id" value="" required />
                                <div class="border-1 border-dark mb-3 border border-dashed p-4">
                                    <label for="images-upload"> Select file: </label>
                                    <input class="form-control" type="file" id="images-upload" name="filename"
                                        required />
                                </div>
                                <div class="mb-3">
                                    <textarea name="media_caption" id="media_caption" class="form-control" cols="30" rows="5"
                                        placeholder="Media Caption"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary submit-button" type="submit"> Upload </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- modal for asdding optional products -->
        <div class="modal fade" id="productAddModal" data-bs-backdrop="static" tabindex="-1" role="dialog"
            aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog" role="document" style="max-width: 600px">
                <form wire:submit.prevent='saveProductForService' class="modal-content position-relative"
                    enctype="multipart/form-data">
                    <div class="position-absolute z-1 end-0 top-0 me-2 mt-2">
                        <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                            data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0">
                        <div class="rounded-top-3 bg-light py-3 pe-6 ps-4">
                            <h4 class="mb-1" id="">Add product</h4>
                        </div>
                        <div class="row p-4">
                            <div class="col-12">
                                <label for="status" class="text-capitalize"><b>Choose product :</b></label>
                                <select wire:model="choosenProduct" class="form-control w-100">
                                    <option>Choose product</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                                @error('choosenProduct')
                                    <small class="text-danger"><b>{{ $message }}</b></small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary submit-button" type="submit"> Add product </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    @push('js')
        <script>
            $(document).on('click', '.add-files', function() {
                var id = $(this).data('service-id');
                $('#upload_id').val(id);
                $('#files-modal').modal('show');
            });

            $(document).on('click', '#productAddModalButton', function() {
                $('#productAddModal').modal('show');
            });

            $(document).on('click', '.submit-button', function() {
                var upload_id = $('#upload_id').val();
                var file = $('#images-upload').val();
                var caption = $('#media_caption').val();
                if (upload_id && file && caption) {
                    $('.submit-button').addClass('disabled').html(
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Uploading...'
                    );
                }
            });
        </script>
    @endpush
</div>
