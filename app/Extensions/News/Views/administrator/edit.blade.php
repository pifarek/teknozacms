@extends('administrator.layouts.default')

@section('content')

<div class="main-container" id="page-news-edit">

    @include('administrator.layouts.partial.heading',
    [
        'items' => collect([['url' => url('administrator/news'), 'title' => __('news::admin.news_index_page_title')], ['url' => url('administrator/news/' . $news->id . '/edit'), 'title' => __('news::admin.news_edit_page_title')]])
    ])

    <div class="main-content">
        <section>
            <div class="page-header">
                <h1>{{ __('news::admin.news_edit_page_title') }}</h1>
                <p class="lead"> {{ __('news::admin.news_edit_page_description') }}</p>
            </div>
            
            @if($errors->count())
            <div class="alert alert-warning">{{ $errors->first() }}</div>
            @endif
            
            @if(Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif
            
            {!! Form::open(['class' => 'form-floating', 'url' => 'administrator/news/' . $news->id]) !!}
            {{ method_field('PUT') }}
            <div class="row">
                <div class="col-md-9">
                    <div class="well">
                        <?php
                        function findLocale($news, $locale_id){
                            $found = false;
                            foreach($news->locales() as $locale){
                                if($locale->id == $locale_id){
                                    $found = true;
                                    break;
                                }
                            }
                            return $found;
                        }
                        ?>
                        
                        <div class="languages-selector">
                            <div class="form-group filled">
                                {!! Form::label('languages', __('news::admin.news_edit_language'), ['class' => 'control-label']) !!}
                                <div class="languages-available">
                                    @foreach($locales as $locale)
                                    <div><label><input type="checkbox" name="locales[]" value="{{ $locale->id }}"{!! findLocale($news, $locale->id)? ' checked="checked"' : '' !!}> <img src="{{ url('assets/administrator/images/flags/' . $locale->language . '.png') }}" alt=""> {{ $locale->name }}</label></div>
                                    @endforeach
                                </div>
                            </div>

                            <ul class="nav nav-tabs" role="tablist">
                                @foreach($locales as $locale)
                                <li{!! findLocale($news, $locale->id)? '' : ' class="d-none"' !!} role="presentation" data-locale="{{ $locale->id }}"><a href="#locale-{{ $locale->id }}" aria-controls="locale-{{ $locale->language }}" role="tab" data-toggle="tab">{{ $locale->name }} <i class="flag flag-{{ $locale->language }}"></i></a></li>
                                @endforeach
                            </ul>

                            <div class="tab-content">
                                @foreach($locales as $locale)
                                <div role="tabpanel" class="tab-pane{!! findLocale($news, $locale->id)? '' : ' d-none' !!}" id="locale-{{ $locale->id }}" data-locale="{{ $locale->id }}">
                                    <div class="form-group{!! $errors->has('title-' . $locale->language)? ' has-error' : '' !!}">
                                        {!! Form::label('title-' . $locale->language, __('news::admin.news_edit_title'), ['class' => 'control-label']) !!}
                                        {!! Form::text('title-' . $locale->language, old('title-' . $locale->language, $news->translate($locale->language)? $news->translate($locale->language)->title : ''), ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="form-group{!! $errors->has('content-' . $locale->language)? ' has-error' : '' !!}">
                                        {!! Form::textarea('content-' . $locale->language, old('content-' . $locale->language, $news->translate($locale->language)? $news->translate($locale->language)->content : ''), ['class' => 'form-control tinymce']) !!}
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('category', __('news::admin.news_edit_category'), ['class' => 'control-label']) !!}
                            {!! Form::select('category', ['0' => __('news::admin.news_category_not_selected')] + $categories, old('category', $news->category_id), ['class' => 'form-control selectpicker']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('date', __('news::admin.news_edit_date'), ['class' => 'control-label']) !!}
                            {!! Form::text('date', old('date', date('d-m-Y, H:i:s', strtotime($news->created_at))), ['class' => 'form-control news-date']) !!}
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">{{ __('news::admin.news_edit_submit') }}</button>
                            <button class="btn btn-default" type="button" onclick="location.href='{{ url('administrator/news') }}'">{{ __('admin.cancel') }}</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="well">
                        <h3>{{ __('news::admin.news_edit_image_label') }}</h3>

                        <div class="progress d-none" id="news-cover-progressbar">
                            <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                        </div>

                        <div class="news-image">
                            <div class="image{{ $news->filename? '' : ' d-none' }}">
                                @if($news->filename)
                                <a href="{{ url('upload/news/n/' . $news->filename) }}" data-fancybox="preview"><img src="{{ url('upload/news/s/' . $news->filename) }}" alt=""></a>
                                @endif
                            </div>
                            <button class="btn btn-warning remove-image{{ $news->filename? '' : ' d-none' }}" data-id="{{ $news->id }}"><i class="fa fa-trash-alt"></i> {{ __('news::admin.news_edit_image_remove') }}</button>
                            <span class="btn btn-success upload-news-image fileinput-button{{ $news->filename? ' d-none' : '' }}">
                                <i class="glyphicon glyphicon-plus"></i>
                                <span><i class="fa fa-plus"></i> {{ __('news::admin.news_edit_image_upload') }}</span>
                                <input class="form-control input-news-image" type="file" name="image" data-url="{{ url('administrator/news/json/image-upload/' . $news->id) }}">
                            </span>
                        </div>
                    </div>

                    @if($multimediaExtensionEnabled)
                    <div class="well">
                        <h3>{{ __('news::admin.news_edit_album_label') }}</h3>
                        
                        {{ Form::select('album', [0 => 'Not Selected'] + $albums, $news->album_id, ['class' => 'form-control selectpicker']) }}
                    </div>
                    @endif
                </div>
            </div>
            {!! Form::close() !!}
        </section>
    </div>
    
</div>
@endsection
