@extends('administrator.layouts.default')

@section('content')

<div class="main-container" id="page-sliders-add">

    @include('administrator.layouts.partial.heading',
        [
            'items' => collect([['url' => url('administrator/sliders'), 'title' => __('sliders::admin.index_page_title')], ['url' => '', 'title' => __('sliders::admin.index_page_title')]]),
            'buttons' => collect()
        ])

    <div class="main-content">
        <section>
            <div class="page-header">
                <h1>{{ trans('sliders::admin.add_page_title') }}</h1>
                <p class="lead"> {{ trans('sliders::admin.add_page_description') }}</p>
            </div>
            
            @if($errors->count())
            <div class="alert alert-warning">{{ $errors->first() }}</div>
            @endif
            
            <div class="well">
                {!! Form::open(['class' => 'form-floating', 'url' => url('administrator/sliders')]) !!}
                    <div class="form-group{!! $errors->has('short')? ' has-error' : '' !!}">
                        {!! Form::label('short', trans('sliders::admin.add_shortcode'), ['class' => 'control-label']) !!}
                        {!! Form::text('short', old('short'), ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit">{{ trans('sliders::admin.add_page_title') }}</button>
                        <button class="btn btn-default" type="button" onclick="location.href='{{ url('administrator/sliders') }}'">{{ trans('admin.cancel') }}</button>
                    </div>
                {!! Form::close() !!}
            </div>
            
        </section>
    </div>
</div>
@endsection
