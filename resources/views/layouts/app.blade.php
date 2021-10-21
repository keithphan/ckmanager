<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png') }}" />


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" rel="stylesheet" />
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="{{ asset('css/select2-bootstrap-5-theme.min.css') }}" rel="stylesheet"/>
</head>
<body class="nav-fixed">

    @include('includes.navBar')

    <div id="layoutSidenav">
        @include('includes.sideNav')

        <div id="layoutSidenav_content">
            @yield('content')

            <footer class="footer-admin mt-auto footer-light">
                <div class="container-xl px-4">
                    <div class="row">
                        <div class="col-md-6 small">Copyright &copy; CkManager 2021</div>
                        <div class="col-md-6 text-md-end small">
                            <a href="#!">Privacy Policy</a>
                            &middot;
                            <a href="#!">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Toast -->
    <div style="position: fixed; right: 1rem; bottom: 1rem; z-index: 999">
        <div class="toast hide" id="toastBasic" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
            <div class="toast-header {{ Session::get('class') }} text-white">
                <i data-feather="bell" class="me-2"></i>
                <strong class="me-auto">Notification</strong>
                <button class="ml-2 mb-1 btn-close btn-close-white" type="button" data-bs-dismiss="toast" aria-label="Close">                                                                </button>
            </div>
            <div class="toast-body bg-white">{!! Session::get('message') !!}</div>
        </div>
    </div>

    <!-- Model -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">{{ __('Delete') }}</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{ __('You will delete everythings belong to this item. Are you sure?') }}
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <form action="
                        @if (Request::segment(1) == 'goods')
                            @if(Request::segment(2))
                            {{ route( Request::segment(2) . '.destroy', 'id') }}
                            @endif
                        @else
                            @if(Request::segment(1) != 'dashboard')
                                {{ route( Request::segment(1) . '.destroy', 'id') }}
                            @endif
                        @endif

                    " method="POST">
                        @csrf
                        @method('DELETE')
                        <input id="id" type="number" hidden name="id" value="">
                        <button class="btn btn-danger" type="submit">{{ __('Delete') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Model -->
    <div class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">{{ __('Delete') }}</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{ __('You will delete everythings belong to these items. Are you sure?') }}
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <form action="
                    @if (Request::segment(1) == 'goods')
                        @if(Request::segment(2))
                            {{ route( Request::segment(2) . '.destroySelected') }}
                        @endif
                    @else
                        @if(Request::segment(1) != 'dashboard')
                            {{ route( Request::segment(1) . '.destroySelected') }}
                        @endif
                    @endif
                    " method="POST">
                        @csrf
                        <input id="itemIds" type="text" hidden name="itemIds" value="">
                        <button class="btn btn-danger" type="submit">{{ __('Delete') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/all.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="{{ asset('js/datatables/datatables-simple-demo.js') }}"></script>

    @if (Request::segment(1) == 'dashboard')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" crossorigin="anonymous"></script>
        <script src="{{ asset('assets/demo/chart-area-demo.js') }}"></script>
        <script src="{{ asset('assets/demo/chart-bar-demo.js') }}"></script>
    @endif
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('/vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/bundle.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/litepicker.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</body>
</html>
