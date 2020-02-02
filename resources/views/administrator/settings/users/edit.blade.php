@extends('administrator.layouts.default')

@section('content')

<div class="main-container" id="page-settings-user-edit">

    @include('administrator.layouts.partial.heading',
    [
        'items' => collect([['url' => url('administrator/settings/users/list'), 'title' => __('admin.settings_users_index_page_title')], ['url' => '', 'title' => __('admin.settings_users_edit_page_title')]])
    ])

    <div class="main-content">
        <section>
            <div class="page-header">
                <h1><i class="md md-list"></i> @lang('admin.settings_users_edit_page_title')</h1>
                <p class="lead"> @lang('admin.settings_users_edit_page_description')</p>
            </div>
            
            @if($errors->count())
            <div class="alert alert-warning">{{ $errors->first() }}</div>
            @endif
            
            @if(Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif

            <div class="well">
                {!! Form::open(['class' => 'form-floating']) !!}
                    <div class="form-group{!! $errors->has('email')? ' has-error' : '' !!}">
                        {!! Form::label('email', __('admin.settings_users_edit_email'), ['class' => 'control-label']) !!}
                        {!! Form::text('email', old('email', $user->email), ['class' => 'form-control', 'disabled' => 'disabled']) !!}
                    </div>
                    <div class="form-group{!! $errors->has('password')? ' has-error' : '' !!}">
                        {!! Form::label('password', __('admin.settings_users_edit_password'), ['class' => 'control-label']) !!}
                        {!! Form::password('password', ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group{!! $errors->has('password_confirmation')? ' has-error' : '' !!}">
                        {!! Form::label('password_confirmation', __('admin.settings_users_edit_repassword'), ['class' => 'control-label']) !!}
                        {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit">@lang('admin.settings_users_edit_submit')</button>
                        <button class="btn btn-default" type="button" onclick="location.href='{{ url('administrator/settings/users/list') }}'">@lang('admin.cancel')</button>
                    </div>
                {!! Form::close() !!}
            </div>
            
        </section>
    </div>
</div>
@endsection
