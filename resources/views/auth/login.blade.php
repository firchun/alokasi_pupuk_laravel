@extends('layouts.auth.app')

@section('content')
    <div class="card" style="border:2px solid #71dd37; box-shadow:0 5px 6px 0 rgba(67, 251, 1, 0.439); border-radius:30px;">
        <div class="card-body">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <!-- Logo -->
                <div class="app-brand justify-content-center mb-3">
                    <a href="{{ url('/') }}" class="app-brand-link  text-success">
                        <span class="app-brand-text demo fw-bolder text-success">{{ env('APP_NAME') ?? 'LARAVEL' }}</span>
                    </a>
                </div>
                <!-- /Logo -->
                <p class="mb-4 text-center">Silahkan login terlebih dahulu</p>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" class="form-control" id="email" name="email"
                        placeholder="Enter your email address" autofocus />
                    @error('email')
                        <span class="text-danger" role="alert">
                            <small>{{ $message }}</small>
                        </span>
                    @enderror
                </div>
                <div class="mb-3 form-password-toggle">
                    <div class="d-flex justify-content-between">
                        <label class="form-label" for="password">Password</label>
                        {{-- <a href="auth-forgot-password-basic.html">
                            <small>Forgot Password?</small>
                        </a> --}}
                    </div>
                    <div class="input-group input-group-merge">
                        <input type="password" id="password" class="form-control" name="password"
                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                            aria-describedby="password" />
                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                        @error('password')
                            <span class="text-danger" role="alert">
                                <small>{{ $message }}</small>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                            {{ old('remember') ? 'checked' : '' }} />
                        <label class="form-check-label" for="remember-me"> Ingat Login </label>
                    </div>
                </div>
                <div class="mb-3">
                    <button class="btn btn-success d-grid w-100" type="submit">Masuk</button>
                </div>
                <p class="text-center">
                    <span>Belum memiliki akun ?</span>
                    <a href="{{ route('register') }}">
                        <span>Daftar Menjadi Distributor</span>
                    </a>
                </p>
            </form>
        </div>
    </div>
@endsection
