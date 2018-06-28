@extends('administrator.layouts.default')

@section('content')

<div class="main-container" id="page-menus-add">
    @include('administrator.layouts.partial.heading',
    [
        'items' => collect([['url' => url('administrator/menus'), 'title' => trans('menus::admin.menus_edit_manage')], ['url' => '', 'title' => trans('menus::admin.menus_add_page_title')]])
    ])

    <div class="main-content">
        <section>
            <div class="page-header">
                <h2>
                    {{ trans('menus::admin.menus_add_page_title') }}
                </h2>
                <p class="lead"> {{ trans('menus::admin.menus_add_page_description') }}</p>
            </div>
            
            @if($errors->count())
            <div class="alert alert-warning">{{ $errors->first() }}</div>
            @endif
            
            <div class="well">
                {!! Form::open(['class' => 'form-floating']) !!}
                    <div class="form-group{!! $errors->has('name')? ' has-error' : '' !!}">
                        {!! Form::label('name', trans('menus::admin.menus_add_name'), ['class' => 'control-label']) !!}
                        {!! Form::text('name', Input::old('name'), ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group{!! $errors->has('code')? ' has-error' : '' !!}">
                        {!! Form::label('code', trans('menus::admin.menus_add_short'), ['class' => 'control-label']) !!}
                        {!! Form::text('code', Input::old('code'), ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit">{{ trans('menus::admin.menus_add_submit') }}</button>
                        <button class="btn btn-default" type="button" onclick="location.href='{{ url('administrator/menus') }}'">{{ trans('menus::admin.menus_add_cancel') }}</button>
                    </div>
                {!! Form::close() !!}
            </div>
            
        </section>
    </div>
</div>
@endsection