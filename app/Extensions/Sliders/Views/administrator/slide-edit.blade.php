@extends('administrator.layouts.default')

@section('content')

<div class="main-container" id="page-sliders-slide-edit">

    @include('administrator.layouts.partial.heading',
        [
            'items' => collect([['url' => url('administrator/sliders'), 'title' => __('sliders::admin.index_page_title')], ['url' => '', 'title' => __('sliders::admin.slide_edit_page_title')]]),
            'buttons' => collect()
        ])

    <div class="main-content">
        <section>
            <div class="page-header">
                <h1>{{ trans('sliders::admin.slide_edit_page_title') }}</h1>
                <p class="lead"> {{ trans('sliders::admin.slide_edit_page_description') }}</p>
            </div>
            
            @if($errors->count())
            <div class="alert alert-warning">{{ $errors->first() }}</div>
            @endif
            
            {!! Form::open(['class' => 'form-floating', 'files' => true, 'url' => url('administrator/sliders/slides/' . $slide->id)]) !!}
            {{ method_field('PUT') }}
            <div class="well">
                <?php
                function findLocale($slide, $locale_id){
                    $found = false;
                    foreach($slide->locales() as $locale){
                        if($locale->id == $locale_id){
                            $found = true;
                            break;
                        }
                    }
                    return $found;
                }
                ?>
                
                <div class="languages-selector">

                    @include('administrator.partial.multiple_language_selector', ['locales' => $locales, 'selected' => $slide->locales(), 'title' => __('sliders::admin.slide_edit_language')])

                    <ul class="nav nav-tabs" role="tablist">
                        @foreach($locales as $locale)
                        <li{!! findLocale($slide, $locale->id)? '' : ' class="d-none"' !!} role="presentation" data-locale="{{ $locale->id }}"><a href="#locale-{{ $locale->id }}" aria-controls="locale-{{ $locale->language }}" role="tab" data-toggle="tab">{{ $locale->name }} <i class="flag flag-{{ $locale->language }}"></i></a></li>
                        @endforeach
                    </ul>

                    <div class="tab-content">
                        @foreach($locales as $locale)
                        <div role="tabpanel" class="tab-pane{!! findLocale($slide, $locale->id)? '' : ' d-none' !!}" id="locale-{{ $locale->id }}" data-locale="{{ $locale->id }}">
                            <div class="form-group{!! $errors->has('name-' . $locale->language)? ' has-error' : '' !!}">
                                {!! Form::label('name-' . $locale->language, trans('sliders::admin.slide_edit_name'), ['class' => 'control-label']) !!}
                                {!! Form::text('name-' . $locale->language, Input::old('name-' . $locale->language, $slide->translate($locale->language)? $slide->translate($locale->language)->name : ''), ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group{!! $errors->has('description-' . $locale->language)? ' has-error' : '' !!}">
                                {!! Form::label('description-' . $locale->language, trans('sliders::admin.slide_edit_description'), ['class' => 'control-label']) !!}
                                {!! Form::textarea('description-' . $locale->language, Input::old('description-' . $locale->language, $slide->translate($locale->language)? $slide->translate($locale->language)->description : ''), ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="form-group{!! $errors->has('slider')? ' has-error' : '' !!}">
                    {!! Form::label('slider', trans('sliders::admin.slide_edit_slider'), ['class' => 'control-label']) !!}
                    {!! Form::select('slider', $sliders, Input::old('slider', $slide->slider_id), ['class' => 'form-control selectpicker']) !!}
                </div>
                <div class="form-group{!! $errors->has('url')? ' has-error' : '' !!}">
                    {!! Form::label('url', trans('sliders::admin.slide_edit_url'), ['class' => 'control-label']) !!}
                    {!! Form::text('url', Input::old('url', $slide->url), ['class' => 'form-control']) !!}
                </div>
                <div class="slide-url d-none">
                    <div class="languages-selector">

                        <ul class="nav nav-tabs d-none" role="tablist">
                            @foreach($locales as $locale)
                                <li role="presentation" data-locale="{{ $locale->id }}"><a href="#url-locale-{{ $locale->id }}" aria-controls="url-locale-{{ $locale->language }}" role="tab" data-toggle="tab">{{ $locale->name }} <i class="flag flag-{{ $locale->language }}"></i></a></li>
                            @endforeach
                        </ul>

                        <div class="tab-content d-none">
                            @foreach($locales as $locale)
                                <div role="tabpanel" class="tab-pane" id="url-locale-{{ $locale->id }}" data-locale="{{ $locale->id }}">
                                    <div class="form-group{!! $errors->has('button-' . $locale->language)? ' has-error' : '' !!}">
                                        {!! Form::label('button-' . $locale->language, trans('sliders::admin.slide_edit_button'), ['class' => 'control-label']) !!}
                                        {!! Form::text('button-' . $locale->language, Input::old('button-' . $locale->language, $slide->translate($locale->language)? $slide->translate($locale->language)->button_label : ''), ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="form-group{!! $errors->has('blank')? ' has-error' : '' !!}">
                    <label>
                        {!! Form::checkbox('blank', '1', $slide->blank) !!} {{ trans('sliders::admin.slide_edit_blank') }}
                    </label>
                </div>
                <div class="form-group{!! $errors->has('available_date')? ' has-error' : '' !!}">
                    {!! Form::label('available_date', trans('sliders::admin.slide_edit_available'), ['class' => 'control-label']) !!}
                    {!! Form::select('available_date', [0 => trans('sliders::admin.slide_edit_available_0'), 1 => trans('sliders::admin.slide_edit_available_1')], Input::old('available_date', $slide->available_date), ['class' => 'form-control selectpicker']) !!}
                </div>
                <div class="available-date d-none">
                    <div class="form-group{!! $errors->has('start_date')? ' has-error' : '' !!}">
                        {!! Form::label('start_date', trans('sliders::admin.slide_edit_start'), ['class' => 'control-label']) !!}
                        {!! Form::text('start_date', Input::old('start_date', date('d-m-Y H:i:s', $slide->start_date)), ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group{!! $errors->has('end_date')? ' has-error' : '' !!}">
                        {!! Form::label('end_date', trans('sliders::admin.slide_edit_end'), ['class' => 'control-label']) !!}
                        {!! Form::text('end_date', Input::old('end_date', date('d-m-Y H:i:s', $slide->end_date)), ['class' => 'form-control']) !!}
                    </div>
                </div>
                
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation"><a href="#image" aria-controls="image" role="tab" data-toggle="tab"><i class="fa fa-image"></i> {{ trans('sliders::admin.slide_edit_type_image') }}</a></li>
                </ul>
                
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane" id="image">
                        
                        <div class="form-group">
                            <div class="slide-preview">
                                <img src="{{ url('upload/slides/' . $slide->filename) }}" alt="">

                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group{!! $errors->has('image')? ' has-error' : '' !!}">
                            <span class="btn btn-success fileinput-button">
                                <i class="fa fa-plus"></i> <span>{{ trans('sliders::admin.slide_edit_select_image') }}</span>
                                <input id="fileupload" type="file" name="image" data-url="{{ url('administrator/sliders/json/image/' . $slide->id) }}">
                            </span>
                            
                            <span class="help-block">{{ trans('sliders::admin.slide_edit_max_upload', array('upload_max_filesize' => ini_get('upload_max_filesize'))) }}</span>
                        </div>
                    </div>
                </div>
                  
                <div class="form-group">
                    <button class="btn btn-primary" type="submit" name="type" value="{{ $slide->type }}">{{ trans('sliders::admin.slide_edit_submit') }}</button>
                    <button class="btn btn-default" type="button" onclick="location.href='{{ url('administrator/sliders') }}'">{{ trans('admin.cancel') }}</button>
                </div>
            </div>            
            {!! Form::close() !!}
        </section>
    </div>
</div>
@endsection