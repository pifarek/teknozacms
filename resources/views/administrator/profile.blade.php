@extends('administrator.layouts.default')

@section('content')

<div class="main-container" id="page-profile">
    @include('administrator.layouts.partial.heading', ['items' => collect([['url' => url('administrator/profile'), 'title' => __('admin.profile_page_title')]])])

    <div class="main-content">
        <section>
            <div class="page-header">
                <h1>{{ __('admin.profile_page_title') }}</h1>
                <p class="lead"> {{ __('admin.profile_page_description') }}</p>
            </div>
            
            @if($errors->count())
            <div class="alert alert-warning">{{ $errors->first() }}</div>
            @endif
            
            @if(Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif
            
            <div class="well">
                {!! Form::open(['class' => 'form-floating', 'files' => true]) !!}
                    <div class="form-group{!! $errors->has('avatar')? ' has-error' : '' !!}">
                        <div class="user-avatar{!! $user->avatar? '' : ' d-none' !!}">
                            <img src="{{ url('upload/users/' . $user->avatar) }}" alt="">
                        </div>
                        
                        <button type="button" class="btn btn-warning{{ $user->avatar? '' : ' d-none' }}" data-action="avatar-remove"><i class="fa fa-trash-alt"></i> {{ __('admin.profile_remove_avatar') }}</button>
                        
                        <span class="btn btn-success fileinput-button">
                            <i class="fa fa-plus"></i>
                            <span>{{ __('admin.profile_select_avatar') }}</span>
                            <input id="fileupload" type="file" name="avatar" data-url="{{ url('administrator/profile/json/avatar') }}">
                        </span>
                    </div>
                
                    <div class="form-group{!! $errors->has('name')? ' has-error' : '' !!}">
                        {!! Form::label('name', __('admin.profile_name'), ['class' => 'control-label']) !!}
                        {!! Form::text('name', Input::old('name', $user->name), ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group{!! $errors->has('name')? ' has-error' : '' !!}">
                        {!! Form::label('surname', __('admin.profile_surname'), ['class' => 'control-label']) !!}
                        {!! Form::text('surname', Input::old('surname', $user->surname), ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group{!! $errors->has('password')? ' has-error' : '' !!}">
                        {!! Form::label('password', __('admin.profile_password'), ['class' => 'control-label']) !!}
                        {!! Form::password('password', ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group{!! $errors->has('repassword')? ' has-error' : '' !!}">
                        {!! Form::label('repassword', __('admin.profile_repassword'), ['class' => 'control-label']) !!}
                        {!! Form::password('repassword', ['class' => 'form-control']) !!}
                        <span class="help-block">{{ __('admin.profile_password_info') }}</span>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit">{{ __('admin.profile_submit') }}</button>
                        <button class="btn btn-default" type="button" onclick="location.href='{{ url('administrator') }}'">{{ __('admin.cancel') }}</button>
                    </div>
                {!! Form::close() !!}
            </div>
        </section>
    </div>
</div>

@endsection