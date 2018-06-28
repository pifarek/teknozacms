@extends('administrator.layouts.login')

@section('content')


<div class="card">
    <img class="card-img-top" src="{{ url('assets/administrator/images/login_logo.png') }}" alt="Teknoza CMS">
    <div class="card-body">

        @if($errors->count())
        <div class="alert alert-warning">{{ trans('admin.auth_login_errors') }}</div>
        @endif

        @if(session('reset_link_sent'))
            <div class="alert alert-info">{{ trans('admin.auth_login_reset_sent') }}</div>
        @endif

        @if(session('reset'))
        <div class="alert alert-info">{{ trans('admin.auth_login_reset_success') }}</div>
        @endif

        <div class="m-b-30">
            <p class="card-title-desc">{{ trans('admin.auth_login_description') }}</p>
        </div>

        {!! Form::open(['class' => 'form-floating']) !!}

        <div class="form-group{{ $errors->count()? ' has-error' : '' }}">
            {!! Form::label('email', trans('admin.auth_login_email'), ['class' => 'control-label']) !!}
            {!! Form::text('email', Input::old('email'), ['class' => 'form-control']) !!}
        </div>
        <div class="form-group{{ $errors->count()? ' has-error' : '' }}">
            {!! Form::label('password', trans('admin.auth_login_password'), ['class' => 'control-label']) !!}
            {!! Form::password('password', ['class' => 'form-control']) !!}
        </div>

        <div class="float-right">
            <a href="{{ url('administrator/auth/reset') }}" class="btn btn-primary"><i class="fa fa-bell"></i> {{ trans('admin.auth_login_forgot') }}</a>
            <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> {{ trans('admin.auth_login_submit') }}</button>
        </div>
        {!! Form::close() !!}
    </div>
</div>


<script>
    window.onload = function(){
        document.getElementById("email").focus();
    };
</script>
@endsection
