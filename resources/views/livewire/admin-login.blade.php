<main class="main" id="top">
    <div class="container-fluid">
        <div class="row min-vh-100 flex-center g-0">
            <div class="col-lg-8 col-xxl-6 py-1 position-relative">
                    <img class="bg-auth-circle-shape" src="{{ asset('public/assets/img/icons/spot-illustrations/bg-shape.png') }}" alt="" width="250">
                    <img class="bg-auth-circle-shape-2" src="{{ asset('public/assets/img/icons/spot-illustrations/shape-1.png') }}" alt="" width="150">
                <div class="card overflow-hidden z-1">
                    <div class="card-body p-0">
                        <div class="row g-0 h-100">
                            <div class="col-md-5 text-center bg-card-gradient">
                                <div class="position-relative p-4 pt-md-5 pb-md-7" data-bs-theme="light">
                                <div class="bg-holder bg-auth-card-shape" style="background-image:url({{ asset('public/assets/img/icons/spot-illustrations/half-circle.png') }});">
                                </div>
                                <!--/.bg-holder-->

                                <div class="z-1 position-relative"><a class="link-light mb-4 font-sans-serif fs-4 d-inline-block fw-bolder" href="/" wire:navigate>Welcome</a>
                                    <p class="opacity-75 text-white"> </p>
                                </div>
                                </div>
                                <div class="mt-3 mb-4 mt-md-4 mb-md-5" data-bs-theme="light">
                                <p class="text-white">Don't have an account?<br>
                                    <a class="text-decoration-underline link-light" href="https://wa.me/8801751468946" target="_blank">Get started!</a>
                                </p>
                                <p class="mb-0 mt-4 mt-md-5 fs--1 fw-semi-bold text-white opacity-75">Read our 
                                    <a class="text-decoration-underline text-white" href="https://wa.me/8801751468946" target="_blank">terms</a> and 
                                    <a class="text-decoration-underline text-white" href="https://wa.me/8801751468946" target="_blank">conditions </a></p>
                                </div>
                            </div>
                            <div class="col-md-7 d-flex flex-center">
                                <div class="p-4 p-md-5 flex-grow-1">
                                    <div class="row flex-between-center">

                                        <div class="col-auto">
                                            <h3></h3>
                                        </div>


                                        <div id="redirecting"></div>

                                        @if(Session::has('success'))
                                        <h5 class="alert alert-success">{{Session::get('success')}}</h5>
                                        @elseif(Session::has('warning'))
                                        <h5 class="alert alert-danger">{{Session::get('warning')}}</h5>
                                        @endif

                                    </div>
                                    <form wire:submit.prevent="authentication_act">
                                        <div class="mb-3">
                                            <label class="form-label" for="card-email">Email address</label>
                                            <input 
                                            wire:model.defer="email" 
                                            placeholder="Email" 
                                            class="form-control @error('email') is-invalid @enderror" 
                                            id="card-email" 
                                            type="email" />
                                            @error('email') <p class="text-danger mb-3"><strong>{{$message}}</strong></p> @enderror
                                        </div>
                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between">
                                                <label class="form-label" for="card-password">Password</label>
                                            </div>
                                            <input 
                                            placeholder="password" 
                                            wire:model.defer="password" 
                                            class="form-control @error('password') is-invalid @enderror" 
                                            id="card-password" 
                                            type="password" />
                                            @error('password') <p class="text-danger"><strong>{{$message}}</strong></p> @enderror
                                        </div>
                                        <div class="row flex-between-center">
                                            <div class="col-auto">
                                                <div class="form-check mb-0">
                                                    <input class="form-check-input" type="checkbox" id="card-checkbox"
                                                        checked="checked" />
                                                    <label class="form-check-label mb-0" for="card-checkbox">Remember
                                                        me</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <button 
                                            class="btn btn-primary d-block w-100 mt-3" 
                                            type="submit"
                                            name="submit"
                                            wire:loading.attr="disabled">
                                            <div wire:loading wire:target="authentication_act">
                                                <div class="la-ball-clip-rotate-multiple la-sm">
                                                    <div></div>
                                                    <div></div>
                                                </div>
                                            </div>

                                                &nbsp; Sign In
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>