<div wire:poll.3s>


    <div class="row my-2">
        <div class="d-lg-flex justify-content-between">
            <div class="col-auto">
                <a href="/admin/dashboard" class="btn btn-sm btn-falcon-primary" wire:navigate> <i class="fe fe-arrow-left-circle"></i> Back to Dashboard</a>
            </div>
            <div class="col-auto"></div>
        </div>
    </div>

    <div class="card card-chat overflow-hidden">
        <div class="card-body d-flex p-0 h-100">
            <div class="chat-sidebar">
                <div class="contacts-list scrollbar-overlay scrollbar">
                    <div class="nav nav-tabs border-0 flex-column" role="tablist" aria-orientation="vertical">
                        <!-- showing the administrator for employee and customer role -->
                        @if(role_name(Auth::user()->id) != 'Administrator')
                        <div class="hover-actions-trigger border-bottom chat-contact nav-item" wire:click="active('1','','')" role="tab" id="chat-link-0" data-bs-toggle="tab" data-bs-target="#chat-0" aria-controls="chat-0" aria-selected="true" wire:ignore>
                            <div class="d-md-none d-lg-block"></div>
                            <div class="d-flex p-3">
                                <div class="avatar avatar-xl status-online">
                                    <img class="rounded-circle" src="{{admin_avater()}}" alt="admin" />
                                </div>
                                <div class="flex-1 chat-contact-body ms-2 d-md-none d-lg-block">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="mb-0 chat-contact-title">{{admin_name()}}</h6>
                                        <span class="message-time fs--2"></span>
                                    </div>
                                    <div class="min-w-0">
                                        <div class="chat-contact-content pe-3">Administrator</div>
                                        <div class="position-absolute bottom-0 end-0 hover-hide"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- all the contacts -->
                        
                        @can('chat-only-admin')
                            @foreach($contacts as $contact)
                            <div class="hover-actions-trigger chat-contact nav-item border-top" wire:click="active('{{$contact['user_id']}}','{{$contact['job_id']}}','{{$contact['service_id']}}')" role="tab" id="chat-link-1" data-bs-toggle="tab" data-bs-target="#chat-1" aria-controls="chat-1" aria-selected="false" wire:ignore>
                                <div class="d-md-none d-lg-block"></div>
                                <div class="d-flex p-3">
                                    <div class="avatar avatar-xl">
                                        <div class="rounded-circle overflow-hidden h-100 d-flex">
                                        <div class="w-100"><img src="{{photo($contact['user_id'])}}" alt="" /></div>
                                        </div>
                                    </div>
                                    <div class="flex-1 chat-contact-body ms-2 d-md-none d-lg-block">
                                        <div class="d-flex justify-content-between">
                                            <h6 class="mb-0 chat-contact-title">{{fullName($contact['user_id'])}} {{role_name($contact['user_id']) ? '('.role_name($contact['user_id']).')' : ''}}</h6>
                                            <span class="message-time fs--2"></span>
                                        </div>
                                        <div class="min-w-0">
                                            <div class="chat-contact-content pe-3">{{$contact['service'] ? $contact['service'] : lastMessage(Auth::user()->id, $contact['user_id'])}}</div>
                                            <div class="position-absolute bottom-0 end-0 ">
                                                <!-- <span class="fas fa-check text-success" data-fa-transform="shrink-5 down-4"></span> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @endcan
                    </div>
                </div>
                <!-- <form class="contacts-search-wrapper">
                    <div class="form-group mb-0 position-relative d-md-none d-lg-block w-100 h-100">
                        <input class="form-control form-control-sm chat-contacts-search border-0 h-100" type="text" placeholder="Search contacts ..." />
                        <span class="fas fa-search contacts-search-icon"></span>
                    </div>
                    <button class="btn btn-sm btn-transparent d-none d-md-inline-block d-lg-none"><span class="fas fa-search fs--1"></span></button>
                </form> -->
            </div>
            <div class="tab-content card-chat-content">
                <!-- conversation box -->
                @if($recipient_id)
                <div class="tab-pane card-chat-pane active" id="chat-1" role="tabpanel" aria-labelledby="chat-link-0">
                    <div class="chat-content-header">
                        <div class="row flex-between-center">
                            <div class="col-6 col-sm-8 d-flex align-items-center"><a class="pe-3 text-700 d-md-none contacts-list-show" href="#!">
                                <div class="fas fa-chevron-left"></div>
                            </a>
                            <div class="min-w-0">
                                <div class="d-flex position-relative p-0 align-items-center">
                                    <div class="avatar avatar-2xl status-online me-2">
                                        <img class="rounded-circle" src="{{photo($recipient_id)}}" alt="" />
                                    </div>
                                    <div class="flex-1">
                                        <h6 class="mb-0"><a class="text-decoration-none stretched-link text-700" href="javascript::void(0);">{{fullName($recipient_id)}} {{serviceName($service_id) ? '('.role_name($recipient_id).')' : ''}}</a></h6>
                                        <p class="mb-0">{{serviceName($service_id) ? serviceName($service_id) : role_name($recipient_id)}}</p>
                                    </div>
                                </div>
                            </div>
                            </div>
                            <div class="col-auto"></div>
                        </div>
                    </div>
                    <div class="chat-content-body" style="display: inherit;">
                        <div class="conversation-info" data-index="0"></div>
                        <div class="chat-content-scroll-area scrollbar">
                            @foreach($conversations as $conversation)
                                <div class="text-center fs--2 text-500"><span></span></div>
                                @if($conversation['recipient_id'] == Auth::user()->id)
                                <div class="d-flex p-3">
                                    <div class="avatar avatar-l me-2">
                                        <img class="rounded-circle" src="{{photo($recipient_id)}}" alt="" />
                                    </div>
                                    <div class="flex-1">
                                        <div class="w-xxl-75">
                                        <div class="hover-actions-trigger d-flex align-items-center">
                                            <div class="chat-message bg-200 p-2 rounded-2">{!! $conversation['content'] !!}</div>
                                        </div>
                                        <div class="text-400 fs--2"><span>{{parseOnlyTimeForHumans($conversation['created_at']) }}</span>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                @if($conversation['recipient_id'] != Auth::user()->id)
                                <div class="d-flex p-3">
                                    <div class="flex-1 d-flex justify-content-end">
                                        <div class="w-100 w-xxl-75">
                                            <div class="hover-actions-trigger d-flex flex-end-center">
                                                <div class="{{ Str::contains($conversation['content'], ['.jpg', '.png', '.jpeg','mp4','mp3','ogv']) ? '' : 'bg-primary' }} text-white p-2 rounded-2 chat-message" data-bs-theme="light">
                                                    <p class="mb-0">{!! $conversation['content'] !!}</p>
                                                </div>
                                            </div>
                                            <div class="text-400 fs--2 text-end">{{parseOnlyTimeForHumans($conversation['created_at']) }}<span class="fas fa-check ms-2 text-success"></span></div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                @else
                <div class="tab-pane card-chat-pane active" id="chat-1" role="tabpanel" aria-labelledby="chat-link-0">
                    <div class="chat-content-header"></div>
                    <div class="chat-content-body" style="display: inherit;"></div>
                </div>
                @endif
                <!-- /conversation box -->

                <!-- chat box -->
                <form class="chat-editor-area bg-success text-white" wire:submit.prevent="send">
                    <textarea 
                    class="form-control @error('message') is-invalid @enderror outline-none w-100 @error('active_id') is-invalid @enderror " 
                    wire:model.defer="message" 
                    wire:keydown.enter="send"
                    placeholder="Type your message" 
                    cols="30" rows="2"></textarea> 
                    <input class="d-none" type="file" id="chat-file-upload" wire:model.live="myfile" />
                    <label class="chat-file-upload cursor-pointer text-white" for="chat-file-upload">
                        <span class="fas fa-paperclip"></span>
                    </label>
                    <button class="btn btn-sm btn-send shadow-none text-white mx-2" type="submit">Send</button>
                </form>
                <!-- /chat box -->
            </div>
        </div>
    </div>

    @push('js')
    <script>
        var chatbox = document.getElementById('chatbox');
        chatbox.scrollTop = chatbox.scrollHeight;
    </script>
    @endpush
</div>