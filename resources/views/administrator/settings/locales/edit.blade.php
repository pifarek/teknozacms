@extends('administrator.layouts.default')

@section('content')

<div class="main-container" id="page-settings-locales-edit">

    @include('administrator.layouts.partial.heading',
    [
        'items' => collect([['url' => url('administrator/settings/locales/list'), 'title' => __('admin.settings_locales_page_title')], ['url' => '', 'title' => __('admin.settings_locale_edit_page_title')]])
    ])

    <div class="main-content">
        <section>
            <div class="page-header">
                <h1><i class="md md-list"></i> {{ trans('admin.settings_locale_edit_page_title') }}</h1>
                <p class="lead"> {{ trans('admin.settings_locale_edit_page_description') }}</p>
            </div>
            
            @if($errors->count())
            <div class="alert alert-warning">{{ $errors->first() }}</div>
            @endif
            
            @if(Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif

            <div class="well">
                {!! Form::open(['class' => 'form-floating']) !!}
                    <div class="form-group{!! $errors->has('name')? ' has-error' : '' !!}">
                        {!! Form::label('name', trans('admin.settings_locale_edit_name'), ['class' => 'control-label']) !!}
                        {!! Form::text('name', old('name', $locale->name), ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group{!! $errors->has('language')? ' has-error' : '' !!}">
                        {!! Form::label('language', trans('admin.settings_locale_edit_code'), ['class' => 'control-label']) !!}
                        {!! Form::text('language', old('language', $locale->language), ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            {!! Form::text('accept', '', ['class' => 'form-control col-md-3', 'placeholder' => __('admin.settings_locale_edit_accept_code')]) !!}
                            <span class="input-group-btn">
                                <button class="btn btn-success ml-3" data-action="accept-add" type="button">@lang('admin.settings_locale_edit_accept_code_add')</button>
                            </span>
                        </div>
                        <small id="passwordHelpBlock" class="form-text text-muted">
                            @lang('admin.settings_locale_edit_accept_info')
                        </small>
                    </div>
                    <div class="form-group">

                        <div class="locale-accept mt-3">
                            @if($locale->accept->count())
                            @foreach($locale->accept as $accept)
                                <span class="badge badge-info"><span class="accept-name">{{ $accept->name }}</span><a href="#" data-action="accept-remove"><i class="fas fa-times"></i></a></span>
                            @endforeach
                            @endif
                        </div>
                        <div class="locale-accept-hidden d-none">
                            @if($locale->accept->count())
                                @foreach($locale->accept as $accept)
                                    <input type="hidden" name="accept_code[]" value="{{ $accept->name }}">
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit">{{ trans('admin.settings_locale_edit_submit') }}</button>
                        <button class="btn btn-default" type="button" onclick="location.href='{{ url('administrator/settings/locales/list') }}'">{{ trans('admin.cancel') }}</button>
                    </div>
                {!! Form::close() !!}
            </div>
            
        </section>
    </div>
</div>
@endsection
