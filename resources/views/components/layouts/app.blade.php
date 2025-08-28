<!DOCTYPE html>
<html data-bs-theme="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <link rel="apple-touch-icon" sizes="180x180" href="{{ config('app.cdn_root') }}/public/assets/img/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ config('app.cdn_root') }}/public/assets/img/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ config('app.cdn_root') }}/public/assets/img/favicons/favicon-16x16.png">
    <link rel="shortcut icon" type="image/x-icon" href="{{ config('app.cdn_root') }}/public/assets/img/favicons/favicon.ico">
    <link rel="manifest" href="{{ config('app.cdn_root') }}/public/assets/img/favicons/manifest.json">
    <meta name="msapplication-TileImage" content="{{ config('app.cdn_root') }}/public/assets/img/favicons/mstile-150x150.png">
    <meta name="theme-color" content="#ffffff">
    <meta name="turbolinks-cache-control" content="no-cache">
    <meta name="turbolinks-visit-control" content="reload">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="{{ config('app.cdn_root') }}/public/assets/js/config.js" data-navigate-once></script>
    <script src="{{ config('app.cdn_root') }}/public/vendors/simplebar/simplebar.min.js" data-navigate-once></script>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;1,300;1,400;1,600;1,800&display=swap" rel="stylesheet">
    <link href="{{ config('app.cdn_root') }}/public/vendors/simplebar/simplebar.min.css" rel="stylesheet" data-navigate-once>
    <link href="{{ config('app.cdn_root') }}/public/assets/css/theme.css" rel="stylesheet" id="style-default" data-navigate-once>
    <link href="{{ config('app.cdn_root') }}/public/assets/css/user.css" rel="stylesheet" id="user-style-default" data-navigate-once>
    <link href="{{ config('app.cdn_root') }}/public/smart-icons.css" rel="stylesheet" data-navigate-once>

    <link href="{{ config('app.cdn_root') }}/public/toastr/toastr.min.css" rel="stylesheet" data-navigate-once>
    
    <link href="{{ config('app.cdn_root') }}/public/vendors/flatpickr/flatpickr.min.css" rel="stylesheet" data-navigate-once />
    <link href="{{ config('app.cdn_root') }}/public/vendors/choices/choices.min.css" rel="stylesheet" />
    <link href="{{ config('app.cdn_root') }}/public/vendors/summernote/summernote-bs5.min.css" rel="stylesheet" data-navigate-once />

    <link rel="stylesheet" href="{{ config('app.cdn_root') }}/public/loader.css">
    <link rel="stylesheet" href="{{ config('app.cdn_root') }}/public/loader-2.css" data-navigate-once>
    <link rel="stylesheet" href="{{ config('app.cdn_root') }}/public/loader-3.css" data-navigate-once>
    <link rel="stylesheet" href="{{ config('app.cdn_root') }}/public/loader-4.css" data-navigate-once> 
    <link rel="stylesheet" href="{{ config('app.cdn_root') }}/public/loader-5.css" data-navigate-once>

    <style>
        /* Hide the spinner arrows for number input */
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        input[type="number"] {
            -moz-appearance: textfield; /* Firefox */
        }

        .fc .fc-h-event .fc-event-time, .fc .fc-h-event .fc-event-title {
            font-weight: 600 !important;
            white-space: normal;
        }

        .bg-status-blue {background:#004AA8 !important;}
        .bg-status-yellow {background:#FEDD5A !important;}
        .bg-status-green {background:#1E9474 !important;}
        .bg-status-red {background:#F13538 !important;}
        .bg-status-orange {background:#FE914E !important;}
        .bg-status-white {background:#FFFFFF !important;}
        .bg-status-black {background:#000000 !important;}

        .modal-backdrop {
            --falcon-backdrop-zindex: 1050;
            --falcon-backdrop-bg: #000;
            --falcon-backdrop-opacity: 0.5;
            position: fixed;
            top: 0;
            left: 0;
            z-index: var(--falcon-backdrop-zindex);
            width: 0;
            height: 0;
            background-color: var(--falcon-backdrop-bg);
        }
    </style>
    
    @stack('css')
    @livewireStyles
  </head>
  <body>

  
    
    <main class="main" id="top">
        <div class="container-fluid" data-layout="container">
            @include('backend.left-menu')
            <div class="content ">

                @include('backend.header')

                <nav class="my-3" style="--falcon-breadcrumb-divider: '»';" aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item text-capitalize active" aria-current="page">
                      {{ request('type') ? request('type') : Str::replace('-',' ',Route::currentRouteName())}}
                    </li>
                  </ol>
                </nav>

                {{ $slot }}
                <div class="mb-3"></div>
                @include('backend.footer-2')
                
            </div>
        </div>
    </main>

    <script src="{{ config('app.cdn_root') }}/public/vendors/jquery/jquery.min.js" data-navigate-once></script>
    <script src="{{ config('app.cdn_root') }}/public/vendors/popper/popper.min.js" data-navigate-once></script>
    <script src="{{ config('app.cdn_root') }}/public/vendors/bootstrap/bootstrap.min.js" data-navigate-once></script>
    <script src="{{ config('app.cdn_root') }}/public/vendors/anchorjs/anchor.min.js" data-navigate-once></script>
    <script src="{{ config('app.cdn_root') }}/public/vendors/is/is.min.js" data-navigate-once></script>
    
    <script src="{{ config('app.cdn_root') }}/public/vendors/chart/chart.min.js" data-navigate-once></script>
    <script src="{{ config('app.cdn_root') }}/public/vendors/echarts/echarts.min.js" data-navigate-once></script>
    <script src="{{ config('app.cdn_root') }}/public/assets/js/echarts-example.js" data-navigate-once></script>
    <script src="{{ config('app.cdn_root') }}/public/vendors/dayjs/dayjs.min.js" data-navigate-once></script>
    <script src="{{ config('app.cdn_root') }}/public/vendors/fontawesome/all.min.js" data-navigate-once></script>
    <script src="{{ config('app.cdn_root') }}/public/vendors/lodash/lodash.min.js" data-navigate-once></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll" data-navigate-once></script>
    <script src="{{ config('app.cdn_root') }}/public/vendors/list.js/list.min.js" data-navigate-once></script>
    <script src="{{ config('app.cdn_root') }}/public/assets/js/theme.js" data-navigate-once></script>
    <script src="{{ config('app.cdn_root') }}/public/toastr/toastr.min.js" data-navigate-once></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js" data-navigate-once></script>
    <script src="{{ config('app.cdn_root') }}/public/assets/js/flatpickr.js" data-navigate-once></script>
    <script src="{{ config('app.cdn_root') }}/public/vendors/choices/choices.min.js" data-navigate-once></script>
    <script src="{{ config('app.cdn_root') }}/public/vendors/summernote/summernote-bs5.min.js" data-navigate-once></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
          $('#window-pop-modal').modal('show');
        });
        document.addEventListener('livewire:navigated', function () {
          $('#window-pop-modal').modal('show');
        });
    </script>
    
    <script data-navigate-once>
      feather.replace()
    </script>
    <script data-navigate-once>
      $(document).ready(function(){
      toastr.options={
        "positionClass":"toast-top-right",
        "progressBar":true,
      }

      window.addEventListener('hide-add-new-admin-form',event=>{
        $('#addNewAdminForm').modal('hide');
        toastr.success(event.detail.message);
      });

      window.addEventListener('close_seconday_modal',event=>{
        $('#addEditSecodaryModal').modal('hide');
        toastr.success(event.detail.message);
      });

      window.addEventListener('close_address_modal',event=>{
        $('#addEditAddressModal').modal('hide');
        toastr.success(event.detail.message);
      });

      window.addEventListener('close_social_modal',event=>{
        $('#addSocialModal').modal('hide');
        toastr.success(event.detail.message);
      });

      window.addEventListener('close_document_modal',event=>{
        $('#addDocumentModal').modal('hide');
        toastr.success(event.detail.message);
      });

      window.addEventListener('close_contact_person_modal',event=>{
        $('#addContactPersionModal').modal('hide');
        toastr.success(event.detail.message);
      });

      window.addEventListener('hide_secondary_contact_modal',event=>{
        $('#addContactPerson').modal('hide');
        toastr.success(event.detail.message);
      });

      window.addEventListener('success',event=>{
        toastr.success(event.detail.message);
      });

      window.addEventListener('exported',event=>{
        toastr.success(event.detail.message);
      });

      window.addEventListener('deleted',event=>{
        toastr.success(event.detail.message);
      });

      window.addEventListener('uploaded',event=>{
        toastr.success(event.detail.message);
      });

      window.addEventListener('warning',event=>{
        toastr.error(event.detail.message);
      });

      window.addEventListener('notfound',event=>{
        toastr.error(event.detail.message);
      });

      window.addEventListener('error',event=>{
        toastr.error(event.detail.message);
      });
    });
    </script>


    <script type="text/javascript" data-navigate-once >
      toastr.options={
          "positionClass":"toast-top-right",
          "progressBar":true,
        }
      @if(Session::has('success'))
          toastr.options.positionClass = 'toast-top-right';
          toastr.success("{{ Session::get('success')}}") ;
      @endif
      @if(Session::has('error'))
          toastr.options.positionClass = 'toast-top-right';
          toastr.error("{{ Session::get('error')}}");
      @endif
      @if(Session::has('warning'))
          toastr.options.positionClass = 'toast-top-right';
          toastr.error("{{ Session::get('warning')}}");
      @endif
    </script>
    
    @stack('js')
    @livewireScripts
  </body>
</html>