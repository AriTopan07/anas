<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UD Mie Wahyu</title>

    <link rel="stylesheet" href="{{ asset('assets/css/main/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main/app-dark.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/shared/iconly.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/datatables.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/extensions/toastify-js/src/toastify.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/extensions/choices.js/public/assets/styles/choices.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.3/dist/sweetalert2.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body>
    <div id="app">
        <div id="sidebar" class="active">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header position-relative">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="logo fs-4">
                            <a href="{{ url('/') }}">
                                <b>UD Mie Wahyu</b>
                                {{-- <img src="assets/images/logo/logo.svg" alt="Logo"
                                    srcset=""> --}}
                            </a>
                        </div>
                        <div class="theme-toggle d-flex gap-2  align-items-center mt-2">
                            <div class="form-check form-switch fs-6">
                                <input class="form-check-input  me-0" type="checkbox" id="toggle-dark"
                                    style="cursor: pointer">
                                <label class="form-check-label"></label>
                            </div>
                        </div>
                        <div class="sidebar-toggler  x">
                            <a href="#" class="sidebar-hide d-xl-none d-block"><i
                                    class="bi bi-x bi-middle"></i></a>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu">
                    <ul class="menu">
                        <li class="sidebar-title">Hi, {{ Auth::user()->name }}</li>
                        <li class="sidebar-item {{ Session::get('menu_active') == '/' ? 'active' : '' }} ">
                            <a href="{{ url('/') }}" class='sidebar-link'>
                                <i class="bi bi-house"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        @foreach (NavHelper::list_menu(Auth::user()->user_group[0]->group_id) as $item)
                            @if ($item['section_id'] != null)
                                <li
                                    class="sidebar-item has-sub {{ in_array(Session::get('menu_active'), $item['aktif']) ? 'active' : '' }}">
                                    <a href="#" class='sidebar-link'>
                                        <i class="bi bi-{{ $item['icons'] }}"></i>
                                        <span>{{ $item['section'] }}</span>
                                    </a>
                                    <ul
                                        class="submenu {{ in_array(Session::get('menu_active'), $item['aktif']) ? 'active' : '' }}">
                                        @foreach ($item['menu'] as $key)
                                            <li
                                                class="submenu-item {{ Session::get('menu_active') == $key['url'] ? 'active' : '' }}">
                                                <a href="{{ $key['url'] }}">{{ $key['menu'] }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @else
                                <li
                                    class="sidebar-item {{ Session::get('menu_active') == 'dashboard' ? 'active' : '' }} ">
                                    <a href="{{ url('/') }}" class='sidebar-link'>
                                        <i class="bi bi-grid-fill"></i>
                                        <span>{{ $item['section'] }}</span>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                        <li class="sidebar-item">
                            <a href="{{ route('logout') }}" class='sidebar-link'
                                onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                                <i class="bi bi-arrow-left-square"></i>
                                <span>Logout</span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>
            @yield('content')

            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                        <p>{{ date('Y') }} &copy; UD Mie Wahyu</p>
                    </div>
                    <div class="float-end">
                        <p>Crafted with <span class="text-danger"><i class="bi bi-heart"></i></span> by <a
                                href="">Mazer</a></p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{ asset('assets/js/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/datatables.js') }}"></script>
    <script src="{{ asset('assets/extensions/toastify-js/src/toastify.js') }}"></script>
    <script src="{{ asset('assets/extensions/choices.js/public/assets/scripts/choices.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form-element-select.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Load jQuery and SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.3/dist/sweetalert2.min.js"></script>

    <script>
        $('.select2').select2({
            dropdownParent: $("#modal_add"),
        });

        function message(title, success = 'true') {
            Toastify({
                text: title,
                duration: 7000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: (success) ? "#61876E" : "#F55050",
            }).showToast();
        }

        $(document).ready(function() {
            $(document).ready(function() {
                $('#datatables').DataTable();
            })

            $(document).ready(function() {
                $('#datatables1').DataTable();
            })
        });
    </script>
    @if (session()->has('message'))
        @php
            $message = Session::get('message');
        @endphp
        <script>
            Toastify({
                text: "{{ $message['content'] }}",
                duration: 7000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: ("{{ $message['type'] }}" == 'success') ? "#61876E" : "#F55050",
            }).showToast();
        </script>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (Session::has('error'))
        <script>
            Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            }).fire({
                icon: 'error',
                text: '{{ session('error') }}',
            });
        </script>
    @endif

    @if (Session::has('success'))
        <script>
            Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            }).fire({
                icon: 'success',
                text: '{{ session('success') }}',
            });
        </script>
    @endif

    @if (Session::has('warning'))
        <script type="text/javascript">
            window.onload = function() {
                @if (Session::has('warning'))
                    Swal.fire({
                        icon: 'warning',
                        text: '{{ Session::get('warning') }}',
                        onClose: () => {
                            window.close();
                        }
                    }).then((result) => {
                        if (!result.dismiss) {
                            window.close();
                        }
                    });
                @endif
            }
        </script>
    @endif

    @stack('js')
</body>

</html>
