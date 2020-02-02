@extends('administrator.layouts.default')

@section('content')

<div class="main-container" id="page-newsletter-group-add">

    @include('administrator.layouts.partial.heading',
    [
        'items' => collect([['url' => url('administrator/newsletter/groups'), 'title' => __('newsletter::admin.groups_page_title')], ['url' => '', 'title' => __('newsletter::admin.group_add_page_title')]]),
        'buttons' => collect()
    ])

    <div class="main-content">
        <section>
            <div class="page-header">
                <h1>{{ trans('newsletter::admin.group_add_page_title') }}</h1>
                <p class="lead"> {{ trans('newsletter::admin.group_add_page_description') }}</p>
            </div>
            
            @if($errors->count())
            <div class="alert alert-warning">{{ $errors->first() }}</div>
            @endif
            
            <div class="well">
                {!! Form::open(['class' => 'form-floating', 'url' => url('administrator/newsletter/groups')]) !!}
                    <div class="form-group{!! $errors->has('name')? ' has-error' : '' !!}">
                        {!! Form::label('name', trans('newsletter::admin.group_add_name'), ['class' => 'control-label']) !!}
                        {!! Form::text('name', old('name'), ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit">{{ trans('newsletter::admin.group_add_submit') }}</button>
                        <button class="btn btn-default" type="button" onclick="location.href='{{ url('administrator/newsletter/groups') }}'">{{ trans('admin.cancel') }}</button>
                    </div>
                {!! Form::close() !!}
            </div>
        </section>
    </div>
</div>
@endsection
