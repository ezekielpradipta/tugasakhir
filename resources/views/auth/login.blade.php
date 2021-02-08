@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-info">
                </div>
                <div class="row">
                    <div class="col-lg-3">
                            <div class="card-body">
                                <h5 class="card-title">SELAMAT DATANG</h5>
                            </div>
                    </div>
                    <div class="col-lg-9">
                            <div class="card-body">
                                @if (session('error'))
                                    <div class="alert alert-danger">{{session('error')}}</div>
                                @endif
                                @if(session('success'))
                                    <div class="alert alert-success">
                                        {!! session('success') !!}
                                    </div>
                                @endif
                                @if(session('fail'))
                                    <div class="alert alert-danger">
                                        {!! session('fail') !!}
                                    </div>
                                @endif

                                <nav class="mb-5">
                                  <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link active" id="login-form-link">Masuk</a>
                                  </div>
                                </nav>
                                <form id="login-form" style="display: block;" method="POST" action="{{ route('login') }}">
                                    @csrf                          
                                    <div class="form-group row">
                                        <label for="username" class="col-md-4 col-form-label text-md-right">Username/Email</label>

                                        <div class="col-md-6">
                                            <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

                                            @error('username')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                        <div class="col-md-6">
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <div class="col-md-8 offset-md-4">
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Masuk') }}
                                            </button>

                                            @if (Route::has('password.request'))
                                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                                    {{ __('Forgot Your Password?') }}
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </form>

                            </div>
                    </div>
                </div>

                <div class="card-footer bg-info text-white">
                    <small>Copyright &copy; 2020. All rights reserved.</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
