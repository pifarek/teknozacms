@extends('administrator.layouts.default')

@section('content')

<div class="main-container" id="page-events-add">

    @include('administrator.layouts.partial.heading',
    [
        'items' => collect([['url' => url('administrator/newsletter'), 'title' => __('newsletter::admin.index_page_title')], ['url' => '', 'title' => __('newsletter::admin.edit_page_title')]]),
        'buttons' => collect()
    ])

    <div class="main-content">
        <section>
            <div class="page-header">
                <h1>{{ trans('newsletter::admin.edit_page_title') }}</h1>
                <p class="lead"> {{ trans('newsletter::admin.edit_page_description') }}</p>
            </div>
            
            @if($errors->count())
            <div class="alert alert-warning">{{ $errors->first() }}</div>
            @endif
            
            @if(Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif
            
            <div class="well">
                {!! Form::open(['class' => 'form-floating', 'url' => url('administrator/newsletter/' . $newsletter->id)]) !!}
                {{ method_field('PUT') }}
                    <div class="form-group{!! $errors->has('email')? ' has-error' : '' !!}">
                        {!! Form::label('email', trans('newsletter::admin.edit_email'), ['class' => 'control-label']) !!}
                        {!! Form::text('email', old('email', $newsletter->email), ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group{!! $errors->has('group')? ' has-error' : '' !!}">
                        {!! Form::label('group', trans('newsletter::admin.edit_group'), ['class' => 'control-label']) !!}
                        {!! Form::select('group', [0 => trans('newsletter::admin.edit_uncategorized')] + $groups, old('group', $newsletter->group_id), ['class' => 'form-control selectpicker']) !!}
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit">{{ trans('newsletter::admin.edit_submit') }}</button>
                        <button class="btn btn-default" type="button" onclick="location.href='{{ url('administrator/newsletter') }}'">{{ trans('admin.cancel') }}</button>
                    </div>
                {!! Form::close() !!}
            </div>
        </section>
    </div>
</div>
@endsection
