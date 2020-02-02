@extends('administrator.layouts.default')

@section('content')

<div class="main-container" id="page-settings-statistics-index">

    @include('administrator.layouts.partial.heading',
    [
        'items' => collect([['url' => '', 'title' => __('admin.settings_statistics_index_page_title')]]),
        'buttons' => collect()
    ])

    <div class="main-content">
        <section>
            <div class="page-header">
                <h1>{{ trans('admin.settings_statistics_index_page_title') }}</h1>
                <p class="lead"> {{ trans('admin.settings_statistics_index_page_description') }}</p>
            </div>
            
            @if($errors->count())
            <div class="alert alert-warning">{{ $errors->first() }}</div>
            @endif
            
            @if(Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif
            
            <div class="well white">

                {!! Form::open(['class' => 'form-floating', 'files' => true]) !!}
                
                <div class="form-group{!! $errors->has('analytics')? ' has-error' : '' !!}">
                    {!! Form::label('analytics', trans('admin.settings_statistics_index_analytics'), ['class' => 'control-label']) !!}
                    {!! Form::text('analytics', old('analytics', Settings::get('analytics')), ['class' => 'form-control']) !!}
                </div>

                <div class="form-group{!! $errors->has('analytics')? ' has-error' : '' !!}">
                    {!! Form::label('analytics_view_id', trans('admin.settings_statistics_index_analytics_view_id'), ['class' => 'control-label']) !!}
                    {!! Form::text('analytics_view_id', old('analytics_view_id', Settings::get('analytics_view_id')), ['class' => 'form-control']) !!}
                    <p class="form-text text-muted">
                        @lang('admin.settings_statistics_index_analytics_view_id_description')
                    </p>
                </div>
                
                <div class="form-group{!! $errors->has('analytics')? ' has-error' : '' !!}">
                    {!! Form::label('credentials', trans('admin.settings_statistics_index_google_credentials'), ['class' => 'control-label']) !!}
                    <span class="btn btn-success upload-partner-image fileinput-button">
                        <i class="fa fa-plus"></i>
                        <span>{{ trans('admin.settings_statistics_index_google_credentials') }}</span>
                        <input class="form-control" name="credentials" type="file">
                    </span>

                    <p class="form-text text-muted">
                        @if($credentials)
                        <span class="text-success">@lang('admin.settings_statistics_index_google_credentials_exists')</span>
                        @else
                        <span class="text-warning">@lang('admin.settings_statistics_index_google_credentials_doesnt_exists')</span>
                        @endif
                    </p>
                </div>
                
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">{{ trans('admin.settings_statistics_index_submit') }}</button>                            
                </div>
                {!! Form::close() !!}

            </div>
        </section>
    </div>
</div>
@endsection
