@extends('layouts.auth')

@section('content')
    {{-- <style>
        .bg {
            background: #6a11cb;

            background: -webkit-linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1));

            background: linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1))
        }
    </style> --}}

    <div class="bg min-vh-100 d-flex flex-column align-items-center justify-content-center py-4" id="auth">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-7 col-9 d-flex flex-column justify-content-center">
                    <div class="card shadow-lg">
                        <div class="card-body">
                            <div class="d-flex justify-content-center py-4">
                                <a href="" class="logo d-flex align-items-center w-auto">
                                    <h1 class="auth-title align-items-center">UD Mie Wahyu</h1>
                                </a>
                            </div>
                            <div class="d-flex justify-content-center">
                                <p class="mb-4">Masukkan username dan password untuk mendapatkan akses</p>
                            </div>

                            <form action="{{ route('login') }}" method="POST">
                                @csrf
                                <label>Username</label>
                                <div class="form-group position-relative has-icon-left mb-4">
                                    <input type="text" class="form-control form-control" name="username"
                                        placeholder="Username" value="{{ old('username') }}">
                                    <div class="form-control-icon">
                                        <i class="bi bi-person"></i>
                                    </div>
                                    @error('username')
                                        <span class="invalid-feedback" role="alert" style="display: inline-block !important;">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <label>Password</label>
                                <div class="form-group position-relative has-icon-left mb-4">
                                    <input type="password" class="form-control form-control" name="password"
                                        placeholder="Password" value="{{ old('password') }}">
                                    <div class="form-control-icon">
                                        <i class="bi bi-shield-lock"></i>
                                    </div>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert" style="display: inline-block !important;">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <button class="btn btn-primary btn-block btn-md shadow-md mt-4">Login</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
