@extends('layouts.dashboard')

@section('content')
    <main>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-header"><h3 class="text-center font-weight-light my-4">Create Account</h3>
                        </div>
                        <div class="card-body">
                            <form id="register-form" method="POST" action="{{ route('register') }}">
                                @csrf
                                <div class="form-floating mb-3">
                                    <input class="form-control" name="name" id="inputEmail" type="text"
                                           placeholder="name@example.com" value="{{ old('name') }}"/>
                                    <label for="inputEmail">Name</label>
                                </div>
                                @error('name')
                                <div class="mb-3 alert alert-danger">{{ $message }}</div>
                                @enderror
                                <div class="form-floating mb-3">
                                    <input class="form-control" name="email" value="{{ old('email') }}" id="inputEmail" type="email"
                                           placeholder="name@example.com"/>
                                    <label for="inputEmail">Email address</label>
                                </div>
                                @error('email')
                                <div class="mb-3 alert alert-danger">{{ $message }}</div>
                                @enderror
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" name="password" id="inputPassword" type="password"
                                                   placeholder="Create a password"/>
                                            <label for="inputPassword">Password</label>
                                        </div>
                                        @error('password')
                                        <div class="mb-3 mt-3 alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" name="password_confirmation" id="inputPasswordConfirm" type="password"
                                                   placeholder="Confirm password"/>
                                            <label for="inputPasswordConfirm">Confirm Password</label>
                                        </div>
                                        @error('password_confirmation')
                                        <div class="mb-3 mt-3 alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                                <div class="mt-4 mb-0">
                                    <div class="d-grid">
                                        <input type="submit" class="btn btn-primary btn-block" value="CREATE USER">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer text-center py-3">
                            <div class="small"><a href="{{ route('login') }}">Have an account? Go to login</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    {{--<div class="container">--}}
    {{--    <div class="row justify-content-center">--}}
    {{--        <div class="col-md-8">--}}
    {{--            <div class="card">--}}
    {{--                <div class="card-header">{{ __('Register') }}</div>--}}

    {{--                <div class="card-body">--}}
    {{--                    <form >--}}
    {{--                        --}}
    {{--                        --}}

    {{--                        <div class="row mb-0">--}}
    {{--                            <div class="col-md-6 offset-md-4">--}}
    {{--                                <button type="submit" class="btn btn-primary">--}}
    {{--                                    {{ __('Register') }}--}}
    {{--                                </button>--}}
    {{--                            </div>--}}
    {{--                        </div>--}}
    {{--                    </form>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}
    {{--</div>--}}
@endsection
