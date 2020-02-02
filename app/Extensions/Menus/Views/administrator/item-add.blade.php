@extends('administrator.layouts.default')

@section('content')

<div class="main-container" id="page-menus-item-add">
    @include('administrator.layouts.partial.heading',
    [
        'items' => collect([['url' => url('administrator/menus'), 'title' => trans('menus::admin.menus_edit_manage')], ['url' => url('administrator/menus/items/' . $menu->id), 'title' => trans('menus::admin.menus_item_add_items', ['name' => $menu->name])], ['url' => '', 'title' => trans('menus::admin.menus_item_add_page_title')]])
    ])

    <div class="main-content">
        <section>
            <div class="page-header">
                <h2>
                    {{ trans('menus::admin.menus_item_add_page_title') }}
                </h2>
                <p class="lead">{{ trans('menus::admin.menus_item_add_page_description') }}</p>
            </div>
            
            @if($errors->count())
            <div class="alert alert-warning">{{ $errors->first() }}</div>
            @endif
            
            <div class="well">
                {!! Form::open(['class' => 'form-floating']) !!}
                <legend>{{ trans('menus::admin.menus_item_add_basic') }}</legend>
                <ul class="nav nav-tabs" role="tablist">
                    @foreach($locales as $locale)
                    <li role="presentation"><a href="#variable-{{ $locale->language }}" aria-controls="variable-{{ $locale->language }}" role="tab" data-toggle="tab">{{ $locale->name }} <i class="flag flag-{{ $locale->language }}"></i></a></li>
                    @endforeach
                </ul>

                <div class="tab-content">
                    @foreach($locales as $locale)
                    <div role="tabpanel" class="tab-pane" id="variable-{{ $locale->language }}">
                        <div class="form-group{!! $errors->has('name-' . $locale->language)? ' has-error' : '' !!}">
                            {!! Form::label('name-' . $locale->language, trans('menus::admin.menus_item_add_name'), ['class' => 'control-label']) !!}
                            {!! Form::text('name-' . $locale->language, old('name-' . $locale->language), ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group{!! $errors->has('url-' . $locale->language)? ' has-error' : '' !!}">
                            {!! Form::label('url-' . $locale->language, trans('menus::admin.menus_item_add_url'), ['class' => 'control-label']) !!}
                            {!! Form::text('url-' . $locale->language, old('url-' . $locale->language), ['class' => 'form-control', 'placeholder' => trans('menus::admin.menus_item_add_url_placeholder')]) !!}
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="form-group">
                    {!! Form::label('parent', trans('menus::admin.menus_item_add_parent'), ['class' => 'control-label']) !!}
                    {!! Form::select('parent', $parents, 0, ['class' => 'form-control']) !!}
                </div>

                <legend>{{ trans('menus::admin.menus_item_add_more') }}</legend>

                <div class="form-group">
                    {!! Form::label('type', trans('menus::admin.menus_item_add_type'), ['class' => 'control-label']) !!}
                    {!! Form::select('type', $pages, null, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">{{ trans('menus::admin.menus_item_add_submit') }}</button>
                    <button class="btn btn-default" type="button" onclick="location.href='{{ url('administrator/menus/items/' . $menu->id) }}'">{{ trans('menus::admin.menus_item_add_cancel') }}</button>
                </div>
                {!! Form::close() !!}
            </div>
            
        </section>
    </div>
</div>
@endsection
