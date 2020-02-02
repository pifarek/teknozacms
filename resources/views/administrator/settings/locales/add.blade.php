@extends('administrator.layouts.default')

@section('content')

<div class="main-container" id="page-settings-locales-add">

    @include('administrator.layouts.partial.heading',
    [
        'items' => collect([['url' => url('administrator/settings/locales/list'), 'title' => __('admin.settings_locales_page_title')], ['url' => '', 'title' => __('admin.settings_locale_add_page_title')]])
    ])

    <div class="main-content" autoscroll="true">
        <section>
            <div class="page-header">
                <h1>{{ trans('admin.settings_locale_add_page_title') }}</h1>
                <p class="lead"> {{ trans('admin.settings_locale_add_page_description') }}</p>
            </div>
            
            @if($errors->count())
            <div class="alert alert-warning">{{ $errors->first() }}</div>
            @endif
            
            <div class="well">
                {!! Form::open(['class' => 'form-floating']) !!}
                    <div class="form-group{!! $errors->has('name')? ' has-error' : '' !!}">
                        {!! Form::label('name', trans('admin.settings_locale_add_name'), ['class' => 'control-label']) !!}
                        {!! Form::text('name', old('name'), ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group{!! $errors->has('language')? ' has-error' : '' !!}">
                        {!! Form::label('language', trans('admin.settings_locale_add_code'), ['class' => 'control-label']) !!}
                        {!! Form::text('language', old('language'), ['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group">
                        <button class="btn btn-primary" type="submit">{{ trans('admin.settings_locale_add_submit') }}</button>
                        <button class="btn btn-default" type="button" onclick="location.href='{{ url('administrator/settings/locales/list') }}'">{{ trans('admin.cancel') }}</button>
                    </div>
                {!! Form::close() !!}
            </div>
            
        </section>
    </div>
</div>
@endsection
