@extends('admin.layouts.auth')

@section('title', 'Signin')

@section('content')

<!-- Login form -->
<form action="{{ route('admin.auth.signin.process') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card mb-0">
        <div class="card-body">
            <div class="text-center mb-3">
                <i class="icon-reading icon-2x text-slate-300 border-slate-300 border-3 rounded-round p-3 mb-3 mt-1"></i>
                <h5 class="mb-0">Login ke Administrator</h5>
                <span class="d-block text-muted">Masukkan informasi akun Anda di bawah ini</span>
            </div>

            {!! alertShow(\Session::get('success'), 'success') !!}
            {!! alertShow(\Session::get('failed'), 'failed') !!}

            <div class="form-group form-group-feedback form-group-feedback-left">
                <input type="text" name="user" class="form-control" placeholder="Username" value="{{ old('user') }}">
                {!! fieldError('user') !!}
                <div class="form-control-feedback">
                    <i class="icon-user text-muted"></i>
                </div>
            </div>

            <div class="form-group form-group-feedback form-group-feedback-left">
                <input type="password" name="pass" class="form-control" placeholder="Password">
                {!! fieldError('pass') !!}
                <div class="form-control-feedback">
                    <i class="icon-lock2 text-muted"></i>
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">@lang('button.signin') <i class="icon-circle-right2 ml-2"></i></button>
            </div>
        </div>
    </div>
</form>
<!-- /login form -->
@endsection