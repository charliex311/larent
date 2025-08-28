<nav class="navbar navbar-light navbar-vertical navbar-expand-xl">
    <script>
    var navbarStyle = localStorage.getItem("navbarStyle");
    if (navbarStyle && navbarStyle !== 'transparent') {
        document.querySelector('.navbar-vertical').classList.add(`navbar-${navbarStyle}`);
    }
    </script>
    <div class="d-flex align-items-center">
        <div class="toggle-icon-wrapper">

            <button class="btn navbar-toggler-humburger-icon navbar-vertical-toggle" data-bs-toggle="tooltip"
                data-bs-placement="left" title="Toggle Navigation"><span class="navbar-toggle-icon"><span
                        class="toggle-line"></span></span></button>

        </div>
        <a class="navbar-brand" href="{{route('dashboard')}}">
            <div class="d-flex align-items-center py-3">
                <img class="me-2" src="{{asset('public/logo.png')}}" alt="" width="150">
                <span class="font-sans-serif"></span>
            </div>
        </a>
    </div>
    <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
        <div class="navbar-vertical-content scrollbar">
            <ul class="navbar-nav flex-column mb-3" id="navbarVerticalNav">

                @can('dashboard')
                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName()=='dashboard'?'active':'' }}" href="{{route('dashboard')}}" role="button" >
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><span class="fe fe-home fs-1"></span></span>
                            <span class="nav-link-text ps-1">Dashboard</span>
                        </div>
                    </a>
                </li>
                @endcan


                @canany(['service', 'users', 'users-unpaid-user', 'job-calender', 'work-work-hour'])
                <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                    <div class="col-auto navbar-vertical-label">Workspace</div>
                    <div class="col ps-0">
                        <hr class="mb-0 navbar-vertical-divider">
                    </div>
                </div>                
                @endcanany

                @can('service')
                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName()=='services'?'active':'' }} 
                  {{ Route::currentRouteName()=='add-services'?'active':'' }} 
                  {{ Route::currentRouteName()=='edit-services
                    '?'active':'' }}" href="{{route('services')}}" role="button" >
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><span class="fe fe-grid fs-1"></span></span>
                            <span class="nav-link-text ps-1">Services</span>
                        </div>
                    </a>
                </li>
                @endcan
                

                @can('users')

                <li class="nav-item">
                    <a class="nav-link dropdown-indicator " href="#user" role="button" data-bs-toggle="collapse" aria-expanded="false" aria-controls="user">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><span class="fe fe-users fs-1"></span></span>
                            <span class="nav-link-text ps-1">Users</span>
                        </div>
                    </a>

                    <ul class="nav collapse {{ Route::currentRouteName()=='users'?'show':'' }} {{ Route::currentRouteName()=='add-user'?'show':'' }} 
                    {{ Route::currentRouteName()=='users'?'show':'' }} {{ Route::currentRouteName()=='unpaid-users'?'show':'' }} {{ Route::currentRouteName()=='user-journal-page'?'show':'' }}" id="user">
                        @foreach(\Spatie\Permission\Models\Role::where('name','!=', 'Administrator')->get() as $item)
                        <li class="nav-item ">
                            <a class="nav-link " href="/admin/users?type={{$item->name}}" >
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-icon"><span class="fe fe-corner-down-right fs-1"></span></span>
                                    <span class="nav-link-text ps-1">{{ $item->name }}</span>
                                    <span class="badge rounded-pill ms-2 bg-success">{{getTotalUserByRole($item->name)}}</span>
                                </div>
                            </a>
                        </li>
                        @endforeach

                        @can('users-unpaid-user')
                        <li class="nav-item ">
                            <a class="nav-link " href="/admin/unpaid-users" >
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-icon"><span class="fe fe-corner-down-right fs-1"></span></span>
                                    <span class="nav-link-text ps-1">Unpaid Users</span>
                                    <span class="badge rounded-pill ms-2 bg-danger">0</span>
                                </div>
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>

                @endcan

                @can('job-jobs-calender')
                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName()=='jobs-calendar'?'active':'' }} {{ Route::currentRouteName()=='add-job'?'active':'' }}" href="{{ route('jobs-calendar') }}" role="button">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><span class="fe fe-calendar fs-1"></span></span>
                            <span class="nav-link-text ps-1">Jobs Calendar</span>
                        </div>
                    </a>
                </li>
                @endcan

                @can('work-work-hour')
                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName()=='works-hour'?'active':'' }}" href="{{ route('works-hour') }}" role="button" >
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><span class="fe fe-clock fs-1"></span></span>
                            <span class="nav-link-text ps-1">Work Hour</span>
                        </div>
                    </a>
                </li>
                @endcan


                @can('journal')
                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName()=='journal-page'?'active':'' }}" href="{{ route('journal-page') }}" role="button" >
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><span class="fe fe-book fs-1"></span></span>
                            <span class="nav-link-text ps-1">Journals</span>
                        </div>
                    </a>
                </li>
                @endcan


                @can('chat')
                <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                    <div class="col-auto navbar-vertical-label">Conversations</div>
                    <div class="col ps-0">
                        <hr class="mb-0 navbar-vertical-divider">
                    </div>
                </div>

                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName()=='chat'?'active':'' }}" href="{{ route('chat') }}" role="button" > 
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><span class="fe fe-message-circle fs-1"></span></span>
                            <span class="nav-link-text ps-1">Chat</span>
                        </div>
                    </a>
                </li>
                @endcan


                @canany(['billing-billing-history', 'invoices'])
                    <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                        <div class="col-auto navbar-vertical-label">Billings</div>
                        <div class="col ps-0">
                            <hr class="mb-0 navbar-vertical-divider">
                        </div>
                    </div>
                @endcanany
                
                @can('billing-billing-history')
                    @if(role_name(Auth::user()->id) != 'Administrator')
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName()=='billing-history'?'active':'' }}" href="{{ route('billing-history') }}" role="button" >
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon"><span class="fe fe-file-text fs-1"></span></span>
                                <span class="nav-link-text ps-1">Billing History</span>
                            </div>
                        </a>
                    </li>
                    @endif
                @endcan

                @can('invoices')
                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName()=='invoices'?'active':'' }}
                    {{ Route::currentRouteName()=='generate-invoice'?'active':'' }}" href="{{route('invoices')}}" role="button" >
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><span class="fe fe-file-text fs-1"></span></span>
                            <span class="nav-link-text ps-1">Invoices</span>
                        </div>
                    </a>
                </li>
                @endcan


                @can('withdraw')
                <li class="nav-item">
                    <a class="nav-link dropdown-indicator" href="#withdraw" role="button" data-bs-toggle="collapse" aria-expanded="false" aria-controls="withdraw">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><span class="fas fa-money-check fs-1"></span></span>
                            <span class="nav-link-text ps-1">Withdraw History</span>
                        </div>
                    </a>

                    <ul class="nav collapse {{ Route::currentRouteName()=='withdraw-paid'?'show':'' }} 
                    {{ Route::currentRouteName()=='withdraw-unpaid'?'show':'' }}" id="withdraw">
                        @can('withdraw-unpaid')
                        <li class="nav-item ">
                            <a class="nav-link {{ Route::currentRouteName()=='withdraw-unpaid'?'active':'' }}" href="{{ route('withdraw-unpaid') }}" >
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-icon"><span class="fe fe-corner-down-right fs-1"></span></span>
                                    <span class="nav-link-text ps-1">Unpaid</span>
                                    @if(unpaid_withdraw() > 0)
                                    <span class="badge rounded-pill ms-2 bg-danger">{{unpaid_withdraw()}}</span>
                                    @endif
                                </div>
                            </a>
                        </li>
                        @endcan
                        @can('withdraw-paid')
                        <li class="nav-item ">
                            <a class="nav-link {{ Route::currentRouteName()=='withdraw-paid'?'active':'' }}" href="{{ route('withdraw-paid') }}" >
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-icon"><span class="fe fe-corner-down-right fs-1"></span></span>
                                    <span class="nav-link-text ps-1">Paid</span>
                                    @if(paid_withdraw() > 0)
                                    <span class="badge rounded-pill ms-2 bg-success">{{paid_withdraw()}}</span>
                                    @endif
                                </div>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcan
                
                @can('payment-payment-method')
                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName()=='payment-method'?'active':'' }}" href="{{route('payment-method')}}" role="button" >
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><span class="fe fe-credit-card fs-1"></span></span>
                            <span class="nav-link-text ps-1">Payment Method</span>
                        </div>
                    </a>
                </li>
                @endcan

                @if(role_name(Auth::user()->id) == 'Administrator')
                @can('deposit-deposit-history')
                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName()=='all-deposits-history'?'active':'' }}" href="{{route('all-deposits-history')}}" role="button" >
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><span class="fe fe-dollar-sign fs-1"></span></span>
                            <span class="nav-link-text ps-1">Deposit History</span>
                        </div>
                    </a>
                </li>
                @endcan
                @endif


                @canany(['email-templates', 'servers-smtp-server'])
                <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                    <div class="col-auto navbar-vertical-label">Mailing</div>
                    <div class="col ps-0">
                        <hr class="mb-0 navbar-vertical-divider">
                    </div>
                </div>
                @endcanany
                
                @can('email-templates')
                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName()=='email-templates'?'active':'' }} 
                    {{ Route::currentRouteName()=='add-template'?'active':'' }}" href="{{route('email-templates')}}" role="button" >
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><span class="fe fe-mail fs-1"></span></span>
                            <span class="nav-link-text ps-1">Email Templates</span>
                        </div>
                    </a>
                </li>
                @endcan

                @can('servers-smtp-server')
                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName()=='smtp-server'?'active':'' }} 
                    {{ Route::currentRouteName()=='add-template'?'active':'' }}" href="{{route('smtp-server')}}" role="button" >
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><span class="fe fe-at-sign fs-1"></span></span>
                            <span class="nav-link-text ps-1">SMTP Server</span>
                        </div>
                    </a>
                </li>
                @endcan


                <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                    <div class="col-auto navbar-vertical-label">Utilities</div>
                    <div class="col ps-0">
                        <hr class="mb-0 navbar-vertical-divider">
                    </div>
                </div>

                @can('optional-optinal-products')

                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName()=='optional-product'?'active':'' }} 
                    {{ Route::currentRouteName()=='add-optional-product'?'active':'' }} 
                    {{ Route::currentRouteName()=='edit-optional-product'?'active':'' }}" href="{{route('optional-product')}}" role="button" >
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><span class="fe fe-package fs-1"></span></span>
                            <span class="nav-link-text ps-1">Optional Products</span>
                        </div>
                    </a>
                </li>

                @endcan


                @can('pop_ups')

                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName()=='pop-list'?'active':'' }}" href="{{route('pop-list')}}" role="button" >
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><span class="fe fe-monitor fs-1"></span></span>
                            <span class="nav-link-text ps-1">Popup Notification</span>
                        </div>
                    </a>
                </li>

                @endcan

                

                @can('logs')

                <!--li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName()=='logs'?'active':'' }}" href="javascript::void(0);" role="button"> 
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><span class="fe fe-flag fs-1"></span></span>
                            <span class="nav-link-text ps-1">Logs(<small class="text-danger">Coming Soon...</small>)</span>
                        </div>
                    </a>
                </li-->

                @endcan

                @can('settings-view')
                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName()=='settings'?'active':'' }}" href="{{route('settings')}}" role="button" >
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><span class="fe fe-settings fs-1"></span></span>
                            <span class="nav-link-text ps-1">{{ role_name(Auth::user()->id) != 'Administrator' ? 'Profile Settings' : 'Settings' }} </span>
                        </div>
                    </a>
                </li>
                @endcan


                @if(role_name(Auth::user()->id) == 'Administrator')
                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName()=='make-storage'?'active':'' }}" href="{{route('make-storage')}}" role="button" >
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><span class="fe fe-repeat fs-1"></span></span>
                            <span class="nav-link-text ps-1">Optimize</span>
                        </div>
                    </a>
                </li>
                @endif

                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin-logout')}}">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><span class="fe fe-power fs-1"></span></span>
                            <span class="nav-link-text ps-1">Logout</span>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>