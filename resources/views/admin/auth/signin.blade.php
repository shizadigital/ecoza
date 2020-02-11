@extends('admin.layouts.auth')

@section('title', 'Signin')

@section('content')

@csrf

<div class="air__auth__container pl-5 pr-5 pt-5 pb-5 bg-white text-center">
    <div class="text-dark font-size-30 mb-4">Login ke Administrator</div>

    {!! alertShow(\Session::get('success'), 'success') !!}
    {!! alertShow(\Session::get('failed'), 'failed') !!}

    <form action="{{ route('admin.auth.signin.process') }}" method="POST" enctype="multipart/form-data" class="mb-4">
        <div class="form-group mb-4">
            <input type="text" name="user" class="form-control" placeholder="Username" value="{{ old('user') }}" />
            {!! fieldError('user') !!}
            <div class="form-control-feedback">
                <i class="icon-user text-muted"></i>
            </div>
        </div>
        <div class="form-group mb-4">
            <input type="password" name="pass" class="form-control" placeholder="Password" />
            {!! fieldError('pass') !!}
            <div class="form-control-feedback">
                <i class="icon-lock2 text-muted"></i>
            </div>
        </div>
        <button class="text-center btn btn-success w-100 font-weight-bold font-size-18">@lang('button.signin')</button>
    </form>
    
    <a href="#" class="text-blue font-weight-bold font-size-18">Forgot password?</a>
</div>

@endsection