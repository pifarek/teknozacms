@extends('administrator.layouts.default')

@section('content')

<div class="main-container" id="page-settings-emails-edit">
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header pull-left">
                <button type="button" class="navbar-toggle pull-left m-15" data-activates=".sidebar"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                <ul class="breadcrumb">
                    <li><a href="{{ url('administrator') }}">{{ trans('admin.title') }}</a></li>
                    <li><a href="{{ url('administrator/settings/emails') }}">{{ trans('admin.settings_emails_page_title') }}</a></li>
                    <li class="active">{{ trans('admin.settings_emails_edit_page_title') }}</li>
                </ul>
            </div> 
            <ul class="nav navbar-nav navbar-right navbar-right-no-collapse">
                @include('administrator.layouts.partial.header-menu')
            </ul>
        </div>
    </nav>
    <div class="main-content" init-ripples="" bs-affix-target="" autoscroll="true">
        <section>
            <div class="page-header">
                <h1><i class="md md-list"></i> {{ trans('admin.settings_emails_edit_page_title') }}</h1>
                <p class="lead"> {{ trans('admin.settings_emails_edit_page_description') }}</p>
            </div>
            
            @if($errors->has())
            <div class="alert alert-warning">{{ $errors->first() }}</div>
            @endif
            
            @if(Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif
            
            <div class="well white">
                {!! Form::open(['class' => 'form-floating']) !!}
                    <div class="form-group{!! $errors->has('tag')? ' has-error' : '' !!}">
                        {!! Form::label('tag', trans('admin.settings_emails_edit_tag'), ['class' => 'control-label']) !!}
                        <input type="text" name="tag" id="tag" class="form-control" value="{{ old('tag', $email->tag) }}"{!! $email->isStatic()? ' disabled="disabled"' : '' !!}>
                    </div>
                
                    <ul class="nav nav-tabs" role="tablist">
                        @foreach($locales as $locale)
                        <li role="presentation"><a href="#tab-{{ $locale->language }}" aria-controls="tab-{{ $locale->language }}" role="tab" data-toggle="tab">{{ $locale->name }} <i class="flag flag-{{ $locale->language }}"></i></a></li>
                        @endforeach
                    </ul>
                
                    <div class="tab-content">
                        @foreach($locales as $locale)
                        <div role="tabpanel" class="tab-pane" id="tab-{{ $locale->language }}">
                            <div class="form-group{!! $errors->has('subject-' . $locale->language)? ' has-error' : '' !!}">
                                {!! Form::label('subject-' . $locale->language, trans('admin.settings_emails_edit_subject'), ['class' => 'control-label']) !!}
                                {!! Form::text('subject-' . $locale->language, old('subject', $email->translate($locale->language)->subject), ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group{!! $errors->has('tag-' . $locale->language)? ' has-error' : '' !!}">
                                {!! Form::label('content-' . $locale->language, trans('admin.settings_emails_edit_content'), ['class' => 'control-label']) !!}
                                {!! Form::textarea('content-' . $locale->language, old('content', $email->translate($locale->language)->content), ['class' => 'form-control']) !!}
                                <span id="helpBlock" class="help-block">
                                    @if(isset($shortcodes[$email->tag]) && sizeof($shortcodes[$email->tag]))
                                    {{ trans('admin.settings_emails_edit_info') }}
                                    @foreach($shortcodes[$email->tag] as $shortcode)
                                    <a href="#" class="shorttag" data-tag=":{{ $shortcode }}">:{{ $shortcode }}</a>
                                    @endforeach
                                    
                                    @endif
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="form-group">
                        <button class="btn btn-primary" type="submit">{{ trans('admin.settings_emails_edit_submit') }}</button>
                        <button class="btn btn-default" type="button" onclick="location.href='{{ url('administrator/settings/emails') }}'">{{ trans('admin.cancel') }}</button>
                    </div>
                {!! Form::close() !!}
            </div>
            
        </section>
    </div>
</div>

@stop

