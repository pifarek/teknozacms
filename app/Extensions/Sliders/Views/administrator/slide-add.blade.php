@extends('administrator.layouts.default')

@section('content')

<div class="main-container" id="page-sliders-slide-add">

    @include('administrator.layouts.partial.heading',
        [
            'items' => collect([['url' => url('administrator/sliders'), 'title' => __('sliders::admin.index_page_title')], ['url' => '', 'title' => __('sliders::admin.slide_add_page_title')]]),
            'buttons' => collect()
        ])

    <div class="main-content">
        <section>
            <div class="page-header">
                <h1>{{ trans('sliders::admin.slide_add_page_title') }}</h1>
                <p class="lead"> {{ trans('sliders::admin.slide_add_page_description') }}</p>
            </div>
            
            @if($errors->count())
            <div class="alert alert-warning">{{ $errors->first() }}</div>
            @endif

            {!! Form::open(['class' => 'form-floating', 'files' => true, 'url' => url('administrator/sliders/slides')]) !!}
            <div class="well">
                <div class="languages-selector">

                    @include('administrator.partial.multiple_language_selector', ['locales' => $locales, 'title' => __('sliders::admin.slide_add_language')])

                    <ul class="nav nav-tabs d-none" role="tablist">
                        @foreach($locales as $locale)
                        <li role="presentation" data-locale="{{ $locale->id }}"><a href="#locale-{{ $locale->id }}" aria-controls="variable-{{ $locale->language }}" role="tab" data-toggle="tab">{{ $locale->name }} <i class="flag flag-{{ $locale->language }}"></i></a></li>
                        @endforeach
                    </ul>

                    <div class="tab-content d-none">
                        @foreach($locales as $locale)
                        <div role="tabpanel" class="tab-pane" id="locale-{{ $locale->id }}" data-locale="{{ $locale->id }}">
                            <div class="form-group{!! $errors->has('name-' . $locale->language)? ' has-error' : '' !!}">
                                {!! Form::label('name-' . $locale->language, trans('sliders::admin.slide_add_name'), ['class' => 'control-label']) !!}
                                {!! Form::text('name-' . $locale->language, old('name-' . $locale->language), ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group{!! $errors->has('description-' . $locale->language)? ' has-error' : '' !!}">
                                {!! Form::label('description-' . $locale->language, trans('sliders::admin.slide_add_description'), ['class' => 'control-label']) !!}
                                {!! Form::textarea('description-' . $locale->language, old('description-' . $locale->language), ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                @if($slider_id)
                <input type="hidden" name="slider" value="{{ $slider_id }}">
                @else
                <div class="form-group{!! $errors->has('slider')? ' has-error' : '' !!}">
                    {!! Form::label('slider', trans('sliders::admin.slide_add_slider'), ['class' => 'control-label']) !!}
                    {!! Form::select('slider', $sliders, old('slider'), ['class' => 'form-control selectpicker']) !!}
                </div>
                @endif
                <div class="form-group{!! $errors->has('url')? ' has-error' : '' !!}">
                    {!! Form::label('url', trans('sliders::admin.slide_add_url'), ['class' => 'control-label']) !!}
                    {!! Form::text('url', old('url'), ['class' => 'form-control']) !!}
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
                                        {!! Form::label('button-' . $locale->language, trans('sliders::admin.slide_add_button'), ['class' => 'control-label']) !!}
                                        {!! Form::text('button-' . $locale->language, old('button-' . $locale->language), ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="form-group{!! $errors->has('blank')? ' has-error' : '' !!}">
                        <label>
                            {!! Form::checkbox('blank', '1') !!} {{ trans('sliders::admin.slide_add_blank') }}
                        </label>
                    </div>
                </div>

                <div class="form-group{!! $errors->has('available_date')? ' has-error' : '' !!}">
                    {!! Form::label('available_date', trans('sliders::admin.slide_add_available'), ['class' => 'control-label']) !!}
                    {!! Form::select('available_date', [0 => trans('sliders::admin.slide_add_available_0'), 1 => trans('sliders::admin.slide_add_available_1')], old('available_date'), ['class' => 'form-control selectpicker']) !!}
                </div>
                <div class="available-date d-none">
                    <div class="form-group{!! $errors->has('start_date')? ' has-error' : '' !!}">
                        {!! Form::label('start_date', trans('sliders::admin.slide_add_start'), ['class' => 'control-label']) !!}
                        {!! Form::text('start_date', old('start_date', date('d-m-Y H:i:s')), ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group{!! $errors->has('end_date')? ' has-error' : '' !!}">
                        {!! Form::label('end_date', trans('sliders::admin.slide_add_end'), ['class' => 'control-label']) !!}
                        {!! Form::text('end_date', old('end_date', date('d-m-Y H:i:s')), ['class' => 'form-control']) !!}
                    </div>
                </div>

                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation"><a href="#image" aria-controls="image" role="tab" data-toggle="tab"><i class="fa fa-image"></i> {{ trans('sliders::admin.slide_add_type_image') }}</a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane" id="image">
                        <div class="form-group">
                            <div class="slide-preview">
                                <img src="" alt="">

                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group{!! $errors->has('image')? ' has-error' : '' !!}">
                            <span class="btn btn-success fileinput-button">
                                <i class="fa fa-plus"></i> <span>{{ trans('sliders::admin.slide_add_select_image') }}</span>
                                <input id="fileupload" type="file" name="tmp" data-url="{{ url('administrator/sliders/json/image-tmp') }}">
                                <input type="hidden" value="" name="image">
                            </span>
                            
                            <span class="help-block">{{ trans('sliders::admin.slide_add_max_upload', array('upload_max_filesize' => ini_get('upload_max_filesize'))) }}</span>
                        </div>
                    </div>
                </div>
                  
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">{{ trans('sliders::admin.slide_add_page_title') }}</button>
                    <button class="btn btn-default" type="button" onclick="location.href='{{ url('administrator/sliders') }}'">{{ trans('admin.cancel') }}</button>
                </div>
            </div>            
            {!! Form::close() !!}
        </section>
    </div>
</div>
@endsection
