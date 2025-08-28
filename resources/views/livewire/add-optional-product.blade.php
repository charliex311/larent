<div>
    <div class="row mt-3">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <div class="card mt-1 shadow-sm">
                <div class="card-header border-bottom border-200 px-0">
                    <div class="d-lg-flex justify-content-between">
                        <div class="row flex-between-center gy-2 px-x1">
                            <div class="col-auto pe-0">
                                <h5 class="mb-0">Add New Optional Product</h5>
                            </div>
                            <div class="col-auto">
                                @if($row)
                                <span class="badge rounded-pill bg-primary">Created Date : {{ systemFormattedDateTime($row->created_at) }}</span>
                                <span class="badge rounded-pill bg-info">Last Modified: {{ systemFormattedDateTime($row->updated_at) }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="border-bottom border-200 my-3"></div>
                        <div class="d-flex align-items-center justify-content-between justify-content-lg-end px-x1">
                            <a href="{{ route('optional-product') }}" class="btn btn-falcon-primary btn-sm me-1 mb-1" wire:navigate>
                                <span class="fe fe-arrow-up-left me-1" ></span> Back to list
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body bg-light">
                    <form wire:submit.prevent="saveChanges">
                        <div class="row mb-3">
                            <div class="col-sm-12 col-md-2 col-lg-2 text-end">
                                <label for=""><b>Optional Product Name:</b></label>
                            </div>
                            <div class="col-sm-12 col-md-5 col-lg-5">
                                <input 
                                type="text" 
                                wire:model.defer="name" 
                                class="form-control @error('name') is-invalid @enderror" 
                                placeholder="Enter Optional Product Name"  />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-12 col-md-2 col-lg-2 text-end">
                                <label for=""><b>Add-on Price:</b></label>
                            </div>
                            <div class="col-sm-12 col-md-5 col-lg-5">
                                <div class="input-group g-1">
                                    <span class="input-group-text" id="price"><b>{{currencySign()}}</b></span>                          
                                    <input 
                                    type="number" 
                                    step="any"
                                    min="0"
                                    wire:model.defer="price" 
                                    id="price"
                                    class="form-control @error('price') is-invalid @enderror" 
                                    placeholder="0.00" />

                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-sm-12 col-md-2 col-lg-2 text-end">
                                <label for="icon"><b>Opitonal Product Icon:</b></label>
                                <small><b>(500px X 500px)</b></small>
                            </div>
                            <div class="col-sm-12 col-md-5 col-lg-5">
                                <input type="file" wire:model.defer="icon" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-12 col-md-2 col-lg-2 text-end">
                                <label for="status"><b>Status:</b></label>
                            </div>
                            <div class="col-sm-12 col-md-5 col-lg-5">
                                <select wire:model.defer="status" class="form-control @error('status') is-invalid @enderror" id="status">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-12 col-md-2 col-lg-2 text-end"></div>
                            <div class="col-sm-12 col-md-5 col-lg-5">
                                <button type="submit" class="btn btn-primary">
                                    {{$row ? 'Save Changes' : 'Submit'}}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
