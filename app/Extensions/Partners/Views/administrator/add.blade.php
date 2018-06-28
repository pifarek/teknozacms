@extends('administrator.layouts.default')

@section('content')

<div class="main-container" id="page-partner-add">

    @include('administrator.layouts.partial.heading',
    [
        'items' => collect([['url' => url('administrator/partners'), 'title' => __('partners::admin.partners_index_page_title')], ['url' => '', 'title' => __('partners::admin.partners_add_page_title')]]),
        'buttons' => collect()
    ])

    <div class="main-content">
        <section>
            <div class="page-header">
                <h1>{{ trans('partners::admin.partners_add_page_title') }}</h1>
                <p class="lead"> {{ trans('partners::admin.partners_add_page_description') }}</p>
            </div>
            
            @if($errors->count())
            <div class="alert alert-warning">{{ $errors->first() }}</div>
            @endif
            
            <div class="well">
                {!! Form::open(['class' => 'form-floating', 'url' => url('administrator/partners')]) !!}
                <div class="form-group">
                    <div class="form-group">
                        {!! Form::label('name', trans('partners::admin.partners_add_name'), ['class' => 'control-label']) !!}
                        {!! Form::text('name', Input::old('name'), ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">{{ trans('partners::admin.partners_add_submit') }}</button>
                    <button class="btn btn-default" type="button" onclick="location.href='{{ url('administrator/partners') }}'">{{ trans('admin.cancel') }}</button>
                </div>
                {!! Form::close() !!}
            </div>
        </section>
    </div>
</div>
@endsection