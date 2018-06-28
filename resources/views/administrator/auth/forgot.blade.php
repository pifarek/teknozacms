@extends('administrator.layouts.login')

@section('content')


    <div class="card">
        <img class="card-img-top" src="{{ url('assets/administrator/images/login_logo.png') }}" alt="Teknoza CMS">
        <div class="card-body">
            @if(\Session::has('success'))
            <div class="alert alert-success">{{ trans('admin.auth_forgot_success') }}</div>
            
            <div class="card-action clearfix">
                <div class="pull-right">
                    <button type="button" onclick="window.location.href='{{ url('administrator') }}';" class="btn btn-link black-text">{{ trans('admin.auth_forgot_back') }}</button>
                </div>
            </div>
            @else
            
            @if($errors->count())
            <div class="alert alert-warning">{{ trans('admin.auth_forgot_errors') }}</div>
            @endif

                <h6 class="card-subtitle mb-2 text-muted">{{ trans('admin.auth_forgot_description') }}</h6>

            {!! Form::open(['class' => 'form-floating']) !!}

            <div class="form-group{{ $errors->count()? ' has-error' : '' }}">
                {!! Form::label('email', trans('admin.auth_forgot_email'), ['class' => 'control-label']) !!}
                {!! Form::text('email', Input::old('email'), ['class' => 'form-control']) !!}
            </div>
                

            <div class="float-right">
                <a href="{{ url('administrator') }}" class="btn btn-primary"><i class="fa fa-arrow-alt-circle-left"></i> {{ trans('admin.auth_forgot_back') }}</a>
                <button type="submit" class="btn btn-success"><i class="fa fa-bell"></i> {{ trans('admin.auth_forgot_submit') }}</button>
            </div>
            
            {!! Form::close() !!}
            @endif
        </div>
    </div>

@stop
