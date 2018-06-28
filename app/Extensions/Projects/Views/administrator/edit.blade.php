@extends('administrator.layouts.default')

@section('content')

<div class="main-container" id="page-project-edit">

    @include('administrator.layouts.partial.heading',
    [
        'items' => collect([['url' => url('administrator/projects'), 'title' => __('projects::admin.projects_index_page_title')], ['url' => '', 'title' => __('projects::admin.projects_edit_page_title')]])
    ])

    <div class="main-content">
        <section>
            <div class="page-header">
                <h1>{{ trans('projects::admin.projects_edit_page_title') }}</h1>
                <p class="lead"> {{ trans('projects::admin.projects_edit_page_description') }}</p>
            </div>
            
            @if($errors->count())
            <div class="alert alert-warning">{{ $errors->first() }}</div>
            @endif
            
            {!! Form::open(['class' => 'form-floating', 'url' => url('administrator/projects/' . $project->id)]) !!}
            {{ method_field('PUT') }}
            <div class="well">
                <legend>{{ trans('projects::admin.projects_edit_image') }}</legend>
                <div class="image">
                    <div class="inner">
                    @if($project->filename)
                    <img src="{{ url('upload/projects/covers/' . $project->filename) }}" alt="">
                    @endif
                    </div>
                    <div class="controls">
                        <span class="btn btn-primary upload fileinput-button">
                            <i class="fa fa-upload"></i>
                            <span>{{ trans('projects::admin.projects_edit_add_image') }}</span>
                            <input class="input-cover-image" type="file" data-url="{{ url('administrator/projects/json/cover/' . $project->id) }}" name="image">
                        </span>
                        <span data-id="{{ $project->id }}" data-action="image-remove" class="btn btn-warning{{ $project->filename? '' : ' d-none' }}"><i class="fa fa-trash-alt"></i> {{ trans('admin.remove') }}</span>
                    </div>
                </div>
            </div>
            
            <div class="well">
                <ul class="nav nav-tabs" role="tablist">
                    @foreach($locales as $locale)
                    <li role="presentation"><a href="#variable-{{ $locale->language }}" aria-controls="variable-{{ $locale->language }}" role="tab" data-toggle="tab">{{ $locale->name }} <i class="flag flag-{{ $locale->language }}"></i></a></li>
                    @endforeach
                </ul>

                <div class="tab-content">
                    @foreach($locales as $locale)
                    <div role="tabpanel" class="tab-pane" id="variable-{{ $locale->language }}">
                        <div class="form-group{!! $errors->has('name-' . $locale->language)? ' has-error' : '' !!}">
                            {!! Form::label('name-' . $locale->language, trans('projects::admin.projects_edit_name'), ['class' => 'control-label']) !!}
                            {!! Form::text('name-' . $locale->language, Input::old('name-' . $locale->language, $project->translate($locale->language)->name), ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group{!! $errors->has('description-' . $locale->language)? ' has-error' : '' !!}">
                            {!! Form::textarea('description-' . $locale->language, Input::old('description-' . $locale->language, $project->translate($locale->language)->description), ['class' => 'form-control tinymce']) !!}
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="form-group{!! $errors->has('year')? ' has-error' : '' !!}">
                    {!! Form::label('year', trans('projects::admin.projects_edit_year'), ['class' => 'control-label']) !!}
                    {!! Form::text('year', Input::old('year', $project->year), ['class' => 'form-control']) !!}
                </div>
                @if($partnersExtensionEnabled)
                <div class="form-group{!! $errors->has('partner')? ' has-error' : '' !!}">
                    {!! Form::label('partner', trans('projects::admin.projects_edit_partner'), ['class' => 'control-label']) !!}
                    {!! Form::select('partner', [0 => __('projects::admin.projects_edit_partner_select')] + $partners, Input::old('partner', $project->partner_id), ['class' => 'form-control selectpicker']) !!}
                </div>
                @endif
                
                <div class="form-group">
                    @foreach($tags as $tag)
                        <input type="checkbox" name="tags[]" value="{{ $tag->id }}"{!! $project->tags()->where('tag_id', '=', $tag->id)->get()->count()? ' checked="checked"' : '' !!}> {{ $tag->name }}
                    @endforeach
                </div>

                <div class="form-group">
                    <span class="btn btn-primary fileinput-button">
                        <i class="fa fa-upload"></i>
                        <span>{{ trans('projects::admin.projects_edit_add_image') }}</span>
                        <input class="input-image" type="file" data-url="{{ url('administrator/projects/json/image/' . $project->id) }}" name="image">
                    </span>

                    <div class="project-images clearfix{{ $project->images->count()? '' : ' d-none' }}">
                        @foreach($project->images as $image)
                        <div class="project-image" data-id="{{ $image->id }}">
                            <a href="{{ url('upload/projects/' . $image->filename) }}" target="_blank" class="preview">
                                <img src="{{ url('upload/projects/' . $image->filename) }}" alt="">
                            </a>
                            <a href="#" class="remove"><i class="fas fa-times-circle"></i></a>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="form-group">
                    <button class="btn btn-primary" type="submit">{{ trans('projects::admin.projects_edit_submit') }}</button>
                    <button class="btn btn-default" type="button" onclick="location.href='{{ url('administrator/projects') }}'">{{ trans('admin.cancel') }}</button>
                </div>
            </div>
             {!! Form::close() !!}
        </section>
    </div>
</div>
@endsection