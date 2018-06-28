@extends('administrator.layouts.default')

@section('content')

<div class="main-container" id="page-project-add">

    @include('administrator.layouts.partial.heading',
    [
        'items' => collect([['url' => url('administrator/projects'), 'title' => __('projects::admin.projects_index_page_title')], ['url' => '', 'title' => __('projects::admin.projects_add_page_title')]])
    ])
    
    <div class="main-content">
        <section>
            <div class="page-header">
                <h1>{{ __('projects::admin.projects_add_page_title') }}</h1>
                <p class="lead"> {{ __('projects::admin.projects_add_page_description') }}</p>
            </div>
            
            @if($errors->count())
            <div class="alert alert-warning">{{ $errors->first() }}</div>
            @endif
            
            <div class="well">
                {!! Form::open(['class' => 'form-floating', 'url' => url('administrator/projects')]) !!}
                    <ul class="nav nav-tabs" role="tablist">
                        @foreach($locales as $locale)
                        <li role="presentation"><a href="#variable-{{ $locale->language }}" aria-controls="variable-{{ $locale->language }}" role="tab" data-toggle="tab">{{ $locale->name }} <i class="flag flag-{{ $locale->language }}"></i></a></li>
                        @endforeach
                    </ul>

                    <div class="tab-content">
                        @foreach($locales as $locale)
                        <div role="tabpanel" class="tab-pane" id="variable-{{ $locale->language }}">
                            <div class="form-group{!! $errors->has('name-' . $locale->language)? ' has-error' : '' !!}">
                                {!! Form::label('name-' . $locale->language, __('projects::admin.projects_add_name'), ['class' => 'control-label']) !!}
                                {!! Form::text('name-' . $locale->language, Input::old('name-' . $locale->language), ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group{!! $errors->has('description-' . $locale->language)? ' has-error' : '' !!}">
                                {!! Form::textarea('description-' . $locale->language, Input::old('description-' . $locale->language), ['class' => 'form-control tinymce']) !!}
                            </div>
                        </div>
                        @endforeach
                    </div>
                
                    <div class="form-group{!! $errors->has('year')? ' has-error' : '' !!}">
                        {!! Form::label('year', __('projects::admin.projects_edit_year'), ['class' => 'control-label']) !!}
                        {!! Form::text('year', Input::old('year'), ['class' => 'form-control']) !!}
                    </div>
                
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit">{{ __('projects::admin.projects_add_submit') }}</button>
                        <button class="btn btn-default" type="button" onclick="location.href='{{ url('administrator/projects') }}'">{{ __('admin.cancel') }}</button>
                    </div>
                {!! Form::close() !!}
            </div>
        </section>
    </div>
</div>
@endsection