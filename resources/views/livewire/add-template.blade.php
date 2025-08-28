<div>
    <div class="row mt-3">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header bg-light">

                    <div class="row flex-between-center">
                        <div class="col-auto">
                            <h3 class="card-title text-capitalize" wire:ignore><b>{{Str::replace('-',' ', Route::currentRouteName())}}</b></h3>
                            @if($row)
                            <span class="badge rounded-pill bg-primary">Created Date : {{ systemFormattedDateTime($row->created_at) }}</span>
                            <span class="badge rounded-pill bg-info">Last Modified: {{ systemFormattedDateTime($row->updated_at) }}</span>
                            @endif
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('email-templates') }}" class="btn btn-primary rounded-pill me-1 mb-1" wire:navigate>
                                <span class="fe fe-arrow-up-left me-1" ></span> Back to list
                            </a>
                        </div>
                    </div>
                    
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="saveChanges">

                        <div class="row g-1">
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="mb-4">
                                    <label for="name">Name</label>
                                    <input 
                                    type="text" 
                                    wire:model="name" 
                                    class="form-control @error('name') is-invalid @enderror" 
                                    placeholder="Enter Name " />
                                    @error('name') <b class="text-danger">{{$message}}</b> @enderror
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="mb-4">
                                    <label for="type">Type</label>
                                    <select wire:model="type" id="type" class="form-control @error('type') is-invalid @enderror">
                                        <option value="">Select</option>
                                        @foreach($types as $itype)
                                        <option value="{{$itype}}">{{$itype}}</option>
                                        @endforeach
                                    </select>
                                    @error('type') <b class="text-danger">{{$message}}</b> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-4" wire:ignore>
                            <label for="summernote"><b>Template Body</b></label>
                            <textarea id="mytextarea" name="content" wire:model="template" class=""></textarea>

                        </div>
                        @error('template') <b class="text-danger">{{$message}}</b> @enderror

                        <div class="mb-3 mt-5">
                            @foreach($tags as $tkey => $tag)
                            <span class="badge rounded-pill bg-success copy-button"
                                data-value="{{$tag}}">{{$tag}}</span>
                            @endforeach
                        </div>

                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary text-capitalize">

                                <div wire:loading wire:target="saveChanges">
                                    <div class="la-ball-clip-rotate-multiple la-sm">
                                        <div></div>
                                        <div></div>
                                    </div>
                                </div>

                                &nbsp; Save Template
                            </button>

                            <a href="/admin/email-templates" class="btn btn-info text-capitalize" wire:navigate>back to list</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    @push('js')
    <script src="{{asset('public/vendors/tinymce/tinymce.min.js')}}" data-navigate-once></script>
    <script data-navigate-once>
        document.addEventListener('livewire:navigated', () => {
            tinymce.init({
                selector: '#mytextarea',
                height: '60vh',
                menubar: false,
                mobile: {
                    theme: 'mobile',
                    toolbar: ['undo', 'bold']
                },
                plugins: [
                    'advlist', 'autolink', 'lists', 'advlist', 'link', 'image', 'charmap', 'preview',
                    'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                    'insertdatetime', 'media', 'table', 'tableofcontents', 'wordcount', 'emoticons', 'visualchars'
                ],
                toolbar: 'customInsertButton | undo redo | styleselect | bold italic underline strikethrough  | link | table  alignleft aligncenter alignright alignjustify | bullist numlist | emoticons | code',
                relative_urls: false,
                remove_script_host: false,
                automatic_uploads: true,
                iframe_aria_text: 'Text Editor',
                placeholder: 'Write Email Body...',
                setup: function (editor) {
                    editor.on('Change', function (e) {
                        @this.set('template', editor.getContent());
                    });
                }
            });
        });

        
        tinymce.init({
            selector: '#mytextarea',
            height: '60vh',
            menubar: false,
            mobile: {
                theme: 'mobile',
                toolbar: ['undo', 'bold']
            },
            plugins: [
                'advlist', 'autolink', 'lists', 'advlist', 'link', 'image', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'table', 'tableofcontents', 'wordcount', 'emoticons', 'visualchars'
            ],
            toolbar: 'customInsertButton | undo redo | styleselect | bold italic underline strikethrough  | link | table  alignleft aligncenter alignright alignjustify | bullist numlist | emoticons | code',
            relative_urls: false,
            remove_script_host: false,
            automatic_uploads: true,
            iframe_aria_text: 'Text Editor',
            placeholder: 'Write Email Body...',
            setup: function (editor) {
                editor.on('Change', function (e) {
                    @this.set('template', editor.getContent());
                });
            }
        });
    </script>


    <script>
        $(document).ready(function() {
            $('.copy-button').on('click', function() {
                const valueToCopy = $(this).data('value');
                const tempTextarea = $('<textarea></textarea>');
                tempTextarea.val(valueToCopy);
                $(document.body).append(tempTextarea);
                tempTextarea.select();
                document.execCommand('copy');
                tempTextarea.remove();
                toastr.success(valueToCopy + ' Copied.');
            });
        });
    </script>
    
    @endpush
</div>
