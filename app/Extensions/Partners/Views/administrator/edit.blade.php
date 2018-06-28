@extends('administrator.layouts.default')

@section('content')

<div class="main-container" id="page-partner-edit">

    @include('administrator.layouts.partial.heading',
    [
        'items' => collect([['url' => url('administrator/partners'), 'title' => __('partners::admin.partners_index_page_title')], ['url' => '', 'title' => __('partners::admin.partners_edit_page_title')]]),
        'buttons' => collect()
    ])
    
    <div class="main-content">
        <section>
            <div class="page-header">
                <h1>{{ __('partners::admin.partners_edit_page_title') }}</h1>
                <p class="lead"> {{ __('partners::admin.partners_edit_page_description') }}</p>
            </div>
            
            @if($errors->count())
            <div class="alert alert-warning">{{ $errors->first() }}</div>
            @endif
            
            <div class="well">
                {!! Form::open(['class' => 'form-floating', 'url' => url('administrator/partners/' . $partner->id)]) !!}
                {{ method_field('PUT') }}
                <div class="form-group partner-image-preview{{ $partner->filename? '' : ' d-none' }}">
                    @if($partner->filename)
                    <img src="{{ url('upload/partners/' . $partner->filename) }}" alt="">
                    @endif
                </div>
                
                <div class="form-group">
                    <span class="btn btn-success upload-partner-image fileinput-button{{ $partner->filename? ' d-none' : '' }}">
                        <i class="fa fa-plus"></i>
                        <span>{{ __('partners::admin.partners_edit_image_upload') }}</span>
                        <input class="form-control partner-image" type="file" name="image" data-url="{{ url('administrator/partners/json/image-upload/' . $partner->id) }}">
                    </span>
                    
                    <button class="btn btn-warning remove-partner-image{{ $partner->filename? '' : ' d-none' }}" data-id="{{ $partner->id }}"><i class="fa fa-trash-alt"></i> {{ __('partners::admin.partners_edit_image_remove') }}</button>
                </div>
                <div class="form-group">
                    <div class="form-group">
                        {!! Form::label('name', __('partners::admin.partners_edit_name'), ['class' => 'control-label']) !!}
                        {!! Form::text('name', Input::old('name', $partner->name), ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-group">
                        {!! Form::label('url', __('partners::admin.partners_edit_url'), ['class' => 'control-label']) !!}
                        {!! Form::text('url', Input::old('url', $partner->url), ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">{{ __('partners::admin.partners_edit_submit') }}</button>
                    <button class="btn btn-default" type="button" onclick="location.href='{{ url('administrator/partners') }}'">{{ __('admin.cancel') }}</button>
                </div>
                {!! Form::close() !!}
            </div>
        </section>
    </div>
</div>
@endsection