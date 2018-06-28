@extends('administrator.layouts.default')

@section('content')

<div class="main-container" id="page-menus-item-edit">
    @include('administrator.layouts.partial.heading',
    [
        'items' => collect([
            ['url' => url('administrator/menus'), 'title' => trans('menus::admin.menus_item_edit_manage')],
            ['url' => url('administrator/menus/items/' . $item->menu->id), 'title' => trans('menus::admin.menus_item_edit_items', ['name' => $menu->name])],
            ['url' => '', 'title' => trans('menus::admin.menus_item_edit_page_title')],
        ])
    ])

    <div class="main-content">
        <section>
            <div class="page-header">
                <h1>
                    {{ trans('menus::admin.menus_item_edit_page_title') }}
                </h1>
                <p class="lead"> {{ trans('menus::admin.menus_item_edit_page_description') }}</p>
            </div>
            
            @if($errors->count())
            <div class="alert alert-warning">{{ $errors->first() }}</div>
            @endif
            
            @if(Session::has('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif
            
            <div class="well white">
                {!! Form::open(['class' => 'form-floating']) !!}
                <legend>{{ trans('menus::admin.menus_item_edit_basic') }}</legend>
                <ul class="nav nav-tabs" role="tablist">
                    @foreach($locales as $locale)
                    <li role="presentation"><a href="#variable-{{ $locale->language }}" aria-controls="variable-{{ $locale->language }}" role="tab" data-toggle="tab">{{ $locale->name }} <i class="flag flag-{{ $locale->language }}"></i></a></li>
                    @endforeach
                </ul>

                <div class="tab-content">
                    @foreach($locales as $locale)
                    <div role="tabpanel" class="tab-pane" id="variable-{{ $locale->language }}">
                        <div class="form-group{!! $errors->has('name-' . $locale->language)? ' has-error' : '' !!}">
                            {!! Form::label('name-' . $locale->language, trans('menus::admin.menus_item_edit_name'), ['class' => 'control-label']) !!}
                            {!! Form::text('name-' . $locale->language, Input::old('name-' . $locale->language, $item->translate($locale->language)->name), ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group{!! $errors->has('url-' . $locale->language)? ' has-error' : '' !!}">
                            {!! Form::label('url-' . $locale->language, trans('menus::admin.menus_item_edit_url'), ['class' => 'control-label']) !!}
                            {!! Form::text('url-' . $locale->language, Input::old('url-' . $locale->language, $item->translate($locale->language)->url), ['class' => 'form-control', 'placeholder' => trans('menus::admin.menus_item_edit_url_placeholder')]) !!}
                        </div>
                        <div class="form-group{!! $errors->has('route-' . $locale->language)? ' has-error' : '' !!}">
                            {!! Form::label('route-' . $locale->language, trans('menus::admin.menus_item_edit_route'), ['class' => 'control-label']) !!}
                            {!! Form::text('route-' . $locale->language, url('/') . '/' . Input::old('route-' . $locale->language, $item->translate($locale->language)->route), ['class' => 'form-control', 'disabled' => 'disabled']) !!}
                        </div>
                    </div>
                    @endforeach
                </div>                        
                <div class="form-group">
                    {!! Form::label('parent', trans('menus::admin.menus_item_edit_parent'), ['class' => 'control-label']) !!}
                    {!! Form::select('parent', $parents, Input::old('parent', $item->parent_id), ['class' => 'form-control selectpicker']) !!}
                </div>

                <legend>{{ trans('menus::admin.menus_item_edit_more') }}</legend>

                <div class="form-group">
                    {!! Form::label('type', trans('menus::admin.menus_item_edit_type'), ['class' => 'control-label']) !!}
                    {!! Form::select('type', $pages, $item->type, ['class' => 'form-control selectpicker']) !!}
                </div>
                
                <div class="form-group">
                    <div class="shortcut-button"></div>
                </div>

                <div class="form-group">
                    <span class="btn btn-success upload-intro-image fileinput-button{{ $item->image? ' d-none' : ''}}">
                        <i class="fa fa-plus"></i>
                        <span>{{ trans('menus::admin.menus_item_edit_upload_image') }}</span>
                        {!! Form::file('image', ['class' => 'form-control input-intro-image', 'data-url' => url('administrator/menus/json/item-intro-image/' . $item->id)]) !!}
                    </span>

                    <div class="intro-image{{ $item->image? '' : ' d-none'}}">
                        <button type="button" class="btn btn-danger remove-intro-image" data-id="{{ $item->id }}"><i class="fa fa-minus"></i> {{ trans('menus::admin.menus_item_edit_remove_image') }}</button>
                        <div class="inner">
                            @if($item->image)
                            <img src="{{ url('upload/menus/' . $item->image) }}" alt="">
                            @endif
                        </div>
                    </div>
                </div>

                @if($page->fields())
                @foreach($page->fields() as $field)

                    @if($field->multilanguage === false)
                        <?php
                            $value = false;
                            if($custom = $item->custom($field->name)->first()){
                                $value = $custom->value;
                            }
                        ?>

                        <div class="form-group{!! $errors->has('field-' . $field->name)? ' has-error' : '' !!}">
                        {{-- Display only single form element --}}

                        {!! Form::label('field-' . $field->name, $field->label, ['class' => 'control-label']) !!}

                        @if($field->type === 'textarea')

                        {!! Form::textarea('field-' . $field->name, Input::old('field-' . $field->name, $value), ['class' => 'form-control tinymce']) !!}

                        @elseif($field->type === 'text')

                        {!! Form::text('field-' . $field->name, Input::old('field-' . $field->name, $value), ['class' => 'form-control']) !!}

                        @elseif($field->type === 'select')

                        {!! Form::select('field-' . $field->name, $field->options, Input::old('field-' . $field->name, $value), ['class' => 'form-control selectpicker']) !!}

                        @endif
                        </div>
                    @else
                        {{-- Display tabs with language switcher --}}



                        <ul class="nav nav-tabs" role="tablist">
                            @foreach($locales as $locale)
                            <li role="presentation"><a href="#ftab-{{ $locale->language }}" aria-controls="ftab-{{ $locale->language }}" role="tab" data-toggle="tab">{{ $locale->name }} <i class="flag flag-{{ $locale->language }}"></i></a></li>
                            @endforeach
                        </ul>

                        <div class="tab-content">
                            @foreach($locales as $locale)

                            <?php
                                $value = false;
                                if($custom = $item->custom($field->name, $locale->language)->first()){
                                    $value = $custom->value;
                                }
                            ?>

                            <div role="tabpanel" class="tab-pane" id="ftab-{{ $locale->language }}">
                                <div class="form-group{!! $errors->has('field-' . $field->name . '-' . $locale->language)? ' has-error' : '' !!}">

                                    @if($field->type === 'text')

                                    {!! Form::label('field-' . $field->name . '-' . $locale->language, trans('menus::admin.menus_item_edit_name'), ['class' => 'control-label']) !!}
                                    {!! Form::text('field-' . $field->name . '-' . $locale->language, Input::old('field-' . $field->name . '-' . $locale->language, $value), ['class' => 'form-control']) !!}

                                    @elseif($field->type === 'textarea')

                                    {!! Form::textarea('field-' . $field->name . '-' . $locale->language, Input::old('field-' . $field->name . '-' . $locale->language, $value), ['class' => 'form-control tinymce']) !!}

                                    @elseif($field->type === 'select')



                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif

                @endforeach
                @endif

                <div class="form-group">
                    <button class="btn btn-primary" type="submit">{{ trans('menus::admin.menus_item_edit_submit') }}</button>
                    <button class="btn btn-default" type="button" onclick="location.href='{{ url('administrator/menus/items/' . $item->menu->id) }}'">{{ trans('admin.cancel') }}</button>
                </div>
                {!! Form::close() !!}
            </div>
            
        </section>
    </div>
</div>
@endsection