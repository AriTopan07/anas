<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UD Mie Wahyu</title>

    <link rel="stylesheet" href="{{ asset('assets/css/main/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/auth.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/extensions/toastify-js/src/toastify.css') }}">

</head>

<body>
    @yield('content')
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/toastify-js/src/toastify.js') }}"></script>
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
</body>

</html>
