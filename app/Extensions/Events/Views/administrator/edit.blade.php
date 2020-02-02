@extends('administrator.layouts.default')

@section('content')

<div class="main-container" id="page-events-edit">

    @include('administrator.layouts.partial.heading',
    [
        'items' => collect([['url' => url('administrator/events'), 'title' => __('events::admin.add_events')], ['url' => '', 'title' => __('events::admin.edit_page_title')]]),
        'buttons' => collect()
    ])

    <div class="main-content">
        <section>
            <div class="page-header">
                <h1>{{ trans('events::admin.edit_page_title') }}</h1>
                <p class="lead"> {{ trans('events::admin.edit_page_description') }}</p>
            </div>
            
            @if($errors->count())
            <div class="alert alert-warning">{{ $errors->first() }}</div>
            @endif
            
            @if(Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif
            
            {!! Form::open(['class' => 'form-floating', 'url' => url('administrator/events/' . $event->id)]) !!}
            {{ method_field('PUT') }}
            <div class="well white">
                <legend>{{ trans('events::admin.edit_image') }}</legend>
                <div class="image">
                    <div class="inner">
                    @if($event->filename)
                    <img src="{{ url('upload/events/' . $event->filename) }}" alt="">
                    @endif
                    </div>
                    <div class="controls">
                        <span class="btn btn-primary upload fileinput-button">
                            <i class="fa fa-upload"></i>
                            <span>{{ trans('events::admin.edit_add_image') }}</span>
                            <input class="input-cover-image" type="file" data-url="{{ url('administrator/events/json/image/' . $event->id) }}" name="image">
                        </span>
                        <span data-id="{{ $event->id }}" class="btn btn-secondary{{ $event->filename? '' : ' d-none' }}" data-action="remove-image"><i class="fa fa-trash-alt"></i> {{ trans('admin.remove') }}</span>
                    </div>
                </div>
            </div>

            <div class="well">

                <legend>{{ trans('events::admin.edit_details') }}</legend>

                <ul class="nav nav-tabs" role="tablist">
                    @foreach($locales as $locale)
                    <li role="presentation"><a href="#variable-{{ $locale->language }}" aria-controls="variable-{{ $locale->language }}" role="tab" data-toggle="tab">{{ $locale->name }} <i class="flag flag-{{ $locale->language }}"></i></a></li>
                    @endforeach
                </ul>

                <div class="tab-content">
                    @foreach($locales as $locale)
                    <div role="tabpanel" class="tab-pane" id="variable-{{ $locale->language }}">
                        <div class="form-group{!! $errors->has('name-' . $locale->language)? ' has-error' : '' !!}">
                            {!! Form::label('name-' . $locale->language, trans('events::admin.edit_name'), ['class' => 'control-label']) !!}
                            {!! Form::text('name-' . $locale->language, old('name-' . $locale->language, $event->translate($locale->language)->name), ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group{!! $errors->has('description-' . $locale->language)? ' has-error' : '' !!}">
                            {!! Form::textarea('description-' . $locale->language, old('description-' . $locale->language, $event->translate($locale->language)->description), ['class' => 'form-control tinymce']) !!}
                        </div>
                    </div>
                    @endforeach
                </div>

                <legend>{{ trans('events::admin.edit_more_details') }}</legend>
                <div class="form-group{!! $errors->has('url')? ' has-error' : '' !!}">
                    {!! Form::label('url', trans('events::admin.edit_url'), ['class' => 'control-label']) !!}
                    {!! Form::text('url', old('url', $event->url), ['class' => 'form-control']) !!}
                </div>

                <div class="form-group{!! $errors->has('start')? ' has-error' : '' !!}">
                    {!! Form::label('start', trans('events::admin.edit_start'), ['class' => 'control-label']) !!}
                    {!! Form::text('start', old('start', date('d-m-Y, H:i', $event->start_time > 0 ? $event->start_time : time())), ['class' => 'form-control start-time']) !!}
                </div>
                <div class="form-group{!! $errors->has('end')? ' has-error' : '' !!}">
                    {!! Form::label('end', trans('events::admin.edit_end'), ['class' => 'control-label']) !!}
                    {!! Form::text('end', old('end', date('d-m-Y, H:i', $event->end_time > 0 ? $event->end_time : time())), ['class' => 'form-control end-time']) !!}
                </div>
                <div class="form-group{!! $errors->has('address')? ' has-error' : '' !!}">
                    {!! Form::label('address', trans('events::admin.edit_address'), ['class' => 'control-label']) !!}
                    {!! Form::text('address', old('address', $event->address), ['class' => 'form-control']) !!}
                </div>
                <div class="form-group{!! $errors->has('status')? ' has-error' : '' !!}">
                    {!! Form::label('status', trans('events::admin.edit_status'), ['class' => 'control-label']) !!}
                    {!! Form::select('status', [0 => trans('events::admin.edit_status_0'), 1 => trans('events::admin.edit_status_1')], old('status', $event->status), ['class' => 'form-control selectpicker']) !!}
                </div>
                
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">{{ trans('events::admin.edit_submit') }}</button>
                    <button class="btn btn-default" type="button" onclick="location.href='{{ url('administrator/events') }}'">{{ trans('events::admin.edit_cancel') }}</button>
                </div>
            </div>

            {!! Form::close() !!}
        </section>
    </div>
</div>
@endsection
