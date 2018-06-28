@extends('administrator.layouts.default')

@section('content')

<div class="main-container" id="page-news-add">
    @include('administrator.layouts.partial.heading',
    [
        'items' => collect([['url' => url('administrator/news'), 'title' => trans('news::admin.news_index_page_title')], ['url' => url('administrator/news/create'), 'title' => trans('news::admin.news_add_page_title')]])
    ])

    <div class="main-content">
        <section>
            <div class="page-header">
                <h1>{{ trans('news::admin.news_add_page_title') }}</h1>
                <p class="lead"> {{ trans('news::admin.news_add_page_description') }}</p>
            </div>
            
            @if($errors->count())
            <div class="alert alert-warning">{{ $errors->first() }}</div>
            @endif
            
            @if(Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif
            
            {!! Form::open(['class' => 'form-floating', 'url' => 'administrator/news']) !!}
            <div class="well white">
                <div class="languages-selector">
                    <div class="form-group filled">
                        {!! Form::label('languages', trans('news::admin.news_add_language'), ['class' => 'control-label']) !!}
                        <div class="languages-available">
                            @foreach($locales as $locale)
                            <div><label><input type="checkbox" name="locales[]" value="{{ $locale->id }}"> <img src="{{ url('assets/administrator/images/flags/' . $locale->language . '.png') }}" alt=""> {{ $locale->name }}</label></div>
                            @endforeach
                        </div>
                    </div>

                    <ul class="nav nav-tabs d-none" role="tablist">
                        @foreach($locales as $locale)
                        <li role="presentation" data-locale="{{ $locale->id }}"><a href="#locale-{{ $locale->id }}" aria-controls="variable-{{ $locale->language }}" role="tab" data-toggle="tab">{{ $locale->name }} <i class="flag flag-{{ $locale->language }}"></i></a></li>
                        @endforeach
                    </ul>

                    <div class="tab-content d-none">
                        @foreach($locales as $locale)
                        <div role="tabpanel" class="tab-pane" id="locale-{{ $locale->id }}" data-locale="{{ $locale->id }}">
                            <div class="form-group{!! $errors->has('title-' . $locale->language)? ' has-error' : '' !!}">
                                {!! Form::label('title-' . $locale->language, trans('news::admin.news_add_title'), ['class' => 'control-label']) !!}
                                {!! Form::text('title-' . $locale->language, Input::old('title-' . $locale->language), ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group{!! $errors->has('content-' . $locale->language)? ' has-error' : '' !!}">
                                {!! Form::textarea('content-' . $locale->language, Input::old('content-' . $locale->language), ['class' => 'form-control tinymce']) !!}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('category', trans('news::admin.news_add_category'), ['class' => 'control-label']) !!}
                    {!! Form::select('category', ['0' => trans('news::admin.news_category_not_selected')] + $categories, Input::old('category', 0), ['class' => 'form-control selectpicker']) !!}
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">{{ trans('news::admin.news_index_add') }}</button>
                    <button class="btn btn-default" type="button" onclick="location.href='{{ url('administrator/news') }}'">{{ trans('admin.cancel') }}</button>
                </div>
            </div>
            {!! Form::close() !!}
        </section>
    </div>
    
</div>
@endsection