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

            <div class="well white">
                {!! Form::open(['class' => 'form-floating']) !!}
                    <div class="form-group{!! $errors->has('name')? ' has-error' : '' !!}">
                        {!! Form::label('name', trans('admin.settings_locale_edit_name'), ['class' => 'control-label']) !!}
                        {!! Form::text('name', Input::old('name', $locale->name), ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group{!! $errors->has('language')? ' has-error' : '' !!}">
                        {!! Form::label('language', trans('admin.settings_locale_edit_code'), ['class' => 'control-label']) !!}
                        {!! Form::text('language', Input::old('language', $locale->language), ['class' => 'form-control']) !!}
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