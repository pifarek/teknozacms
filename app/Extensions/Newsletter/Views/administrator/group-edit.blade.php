@extends('administrator.layouts.default')

@section('content')

<div class="main-container" id="page-newsletter-group-edit">

    @include('administrator.layouts.partial.heading',
    [
        'items' => collect([['url' => url('administrator/newsletter/groups'), 'title' => __('newsletter::admin.groups_page_title')], ['url' => '', 'title' => __('newsletter::admin.groups_page_title')]]),
        'buttons' => collect()
    ])

    <div class="main-content">
        <section>
            <div class="page-header">
                <h1>{{ trans('newsletter::admin.group_edit_page_title') }}</h1>
                <p class="lead"> {{ trans('newsletter::admin.group_edit_page_description') }}</p>
            </div>
            
            @if($errors->count())
            <div class="alert alert-warning">{{ $errors->first() }}</div>
            @endif
            
            @if(Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif
            
            <div class="well white">
                {!! Form::open(['class' => 'form-floating', 'url' => url('administrator/newsletter/groups/' . $group->id)]) !!}
                {{ method_field('PUT') }}
                    <div class="form-group{!! $errors->has('name')? ' has-error' : '' !!}">
                        {!! Form::label('name', trans('newsletter::admin.group_edit_name'), ['class' => 'control-label']) !!}
                        {!! Form::text('name', old('name', $group->name), ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit">{{ trans('newsletter::admin.group_edit_submit') }}</button>
                        <button class="btn btn-default" type="button" onclick="location.href='{{ url('administrator/newsletter/groups') }}'">{{ trans('admin.cancel') }}</button>
                    </div>
                {!! Form::close() !!}
            </div>
        </section>
    </div>
</div>
@endsection
