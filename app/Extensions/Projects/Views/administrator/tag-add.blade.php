@extends('administrator.layouts.default')

@section('content')

<div class="main-container" id="page-projects-tag-add">

    @include('administrator.layouts.partial.heading',
    [
        'items' => collect([['url' => url('administrator/projects/tags'), 'title' => __('projects::admin.projects_tags_page_title')], ['url' => '', 'title' => __('projects::admin.projects_tag_add_page_title')]])
    ])

    <div class="main-content">
        <section>
            <div class="page-header">
                <h1>{{ trans('projects::admin.projects_tag_add_page_title') }}</h1>
                <p class="lead"> {{ trans('projects::admin.projects_tag_add_page_description') }}</p>
            </div>
            
            @if($errors->count())
            <div class="alert alert-warning">{{ $errors->first() }}</div>
            @endif
            
            <div class="well">
                {!! Form::open(['class' => 'form-floating', 'url' => url('administrator/projects/tags')]) !!}
                    <ul class="nav nav-tabs" role="tablist">
                        @foreach($locales as $locale)
                        <li role="presentation"><a href="#variable-{{ $locale->language }}" aria-controls="variable-{{ $locale->language }}" role="tab" data-toggle="tab">{{ $locale->name }} <i class="flag flag-{{ $locale->language }}"></i></a></li>
                        @endforeach
                    </ul>

                    <div class="tab-content">
                        @foreach($locales as $locale)
                        <div role="tabpanel" class="tab-pane" id="variable-{{ $locale->language }}">
                            <div class="form-group{!! $errors->has('name-' . $locale->language)? ' has-error' : '' !!}">
                                {!! Form::label('name-' . $locale->language, trans('projects::admin.projects_tag_add_name'), ['class' => 'control-label']) !!}
                                {!! Form::text('name-' . $locale->language, old('name-' . $locale->language), ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit">{{ trans('projects::admin.projects_tag_add_submit') }}</button>
                        <button class="btn btn-default" type="button" onclick="location.href='{{ url('administrator/projects/tags') }}'">{{ trans('admin.cancel') }}</button>
                    </div>
                {!! Form::close() !!}
            </div>
        </section>
    </div>
</div>

@stop

@section('scripts')
<script src="{{ url('assets/administrator/js/modules/projects.module.js') }}"></script>
@stop
