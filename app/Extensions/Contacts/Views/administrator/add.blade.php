@extends('administrator.layouts.default')

@section('content')

<div class="main-container" id="page-contacts-add">

    @include('administrator.layouts.partial.heading',
    [
        'items' => collect([['url' => url('administrator/contacts'), 'title' => __('contacts::admin.add_contacts')], ['url' => '', 'title' => trans('contacts::admin.add_page_title')]]),
        'buttons' => collect([['url' => url('administrator/menus/add'), 'title' => 'Add Menu', 'icon' => 'plus']])
    ])

    <div class="main-content">
        <section>
            <div class="page-header">
                <h1>{{ trans('contacts::admin.add_page_title') }}</h1>
                <p class="lead"> {{ trans('contacts::admin.add_page_description') }}</p>
            </div>
            
            @if($errors->count())
            <div class="alert alert-warning">{{ $errors->first() }}</div>
            @endif
            
            <div class="well white">
                {!! Form::open(['class' => 'form-floating', 'url' => url('administrator/contacts')]) !!}
                <ul class="nav nav-tabs" role="tablist">
                    @foreach($locales as $locale)
                    <li role="presentation"><a href="#variable-{{ $locale->language }}" aria-controls="variable-{{ $locale->language }}" role="tab" data-toggle="tab">{{ $locale->name }} <i class="flag flag-{{ $locale->language }}"></i></a></li>
                    @endforeach
                </ul>

                <div class="tab-content">
                    @foreach($locales as $locale)
                    <div role="tabpanel" class="tab-pane" id="variable-{{ $locale->language }}">
                        <div class="form-group{!! $errors->has('name-' . $locale->language)? ' has-error' : '' !!}">
                            {!! Form::label('name-' . $locale->language, trans('contacts::admin.add_name'), ['class' => 'control-label']) !!}
                            {!! Form::text('name-' . $locale->language, old('name-' . $locale->language), ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group{!! $errors->has('description-' . $locale->language)? ' has-error' : '' !!}">
                            {!! Form::label('description-' . $locale->language, trans('contacts::admin.add_description'), ['class' => 'control-label']) !!}
                            {!! Form::textarea('description-' . $locale->language, old('description-' . $locale->language), ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="form-group">
                    {!! Form::label('street', trans('contacts::admin.add_street'), ['class' => 'control-label']) !!}
                    {!! Form::text('street', old('street'), ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('postal', trans('contacts::admin.add_postal'), ['class' => 'control-label']) !!}
                    {!! Form::text('postal', old('postal'), ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('city', trans('contacts::admin.add_city'), ['class' => 'control-label']) !!}
                    {!! Form::text('city', old('city'), ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('phone', trans('contacts::admin.add_phone'), ['class' => 'control-label']) !!}
                    {!! Form::text('phone', old('phone'), ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('fax', trans('contacts::admin.add_fax'), ['class' => 'control-label']) !!}
                    {!! Form::text('fax', old('fax'), ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('email', trans('contacts::admin.add_email'), ['class' => 'control-label']) !!}
                    {!! Form::text('email', old('email'), ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">{{ trans('contacts::admin.add_add') }}</button>
                    <button class="btn btn-default" type="button" onclick="location.href='{{ url('administrator/contacts') }}'">{{ trans('contacts::admin.add_cancel') }}</button>
                </div>
                {!! Form::close() !!}
            </div>
            
        </section>
    </div>
</div>
@endsection
