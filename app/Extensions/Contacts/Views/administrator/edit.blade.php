@extends('administrator.layouts.default')

@section('content')

<div class="main-container" id="page-contacts-add">

    @include('administrator.layouts.partial.heading',
    [
        'items' => collect([['url' => url('administrator/contacts'), 'title' => __('contacts::admin.add_contacts')], ['url' => '', 'title' => trans('contacts::admin.edit_page_title')]]),
        'buttons' => collect()
    ])

    <div class="main-content">
        <section>
            <div class="page-header">
                <h1>{{ trans('contacts::admin.edit_page_title') }}</h1>
                <p class="lead"> {{ trans('contacts::admin.edit_page_description') }}</p>
            </div>
            
            @if($errors->count())
            <div class="alert alert-warning">{{ $errors->first() }}</div>
            @endif
            
            <div class="well">
                {!! Form::open(['class' => 'form-floating', 'url' => url('administrator/contacts/' . $contact->id)]) !!}
                {{ method_field('PUT') }}
                <ul class="nav nav-tabs" role="tablist">
                    @foreach($locales as $locale)
                    <li role="presentation"><a href="#variable-{{ $locale->language }}" aria-controls="variable-{{ $locale->language }}" role="tab" data-toggle="tab">{{ $locale->name }} <i class="flag flag-{{ $locale->language }}"></i></a></li>
                    @endforeach
                </ul>

                <div class="tab-content">
                    @foreach($locales as $locale)
                    <div role="tabpanel" class="tab-pane" id="variable-{{ $locale->language }}">
                        <div class="form-group{!! $errors->has('name-' . $locale->language)? ' has-error' : '' !!}">
                            {!! Form::label('name-' . $locale->language, trans('contacts::admin.edit_name'), ['class' => 'control-label']) !!}
                            {!! Form::text('name-' . $locale->language, Input::old('name-' . $locale->language, $contact->translate($locale->language)->name), ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group{!! $errors->has('description-' . $locale->language)? ' has-error' : '' !!}">
                            {!! Form::label('description-' . $locale->language, trans('contacts::admin.edit_description'), ['class' => 'control-label']) !!}
                            {!! Form::textarea('description-' . $locale->language, Input::old('description-' . $locale->language, $contact->translate($locale->language)->description), ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="form-group">
                    {!! Form::label('street', trans('contacts::admin.edit_street'), ['class' => 'control-label']) !!}
                    {!! Form::text('street', Input::old('street', $contact->street), ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('postal', trans('contacts::admin.edit_postal'), ['class' => 'control-label']) !!}
                    {!! Form::text('postal', Input::old('postal', $contact->postal), ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('city', trans('contacts::admin.edit_city'), ['class' => 'control-label']) !!}
                    {!! Form::text('city', Input::old('city', $contact->city), ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('phone', trans('contacts::admin.edit_phone'), ['class' => 'control-label']) !!}
                    {!! Form::text('phone', Input::old('phone', $contact->phone), ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('fax', trans('contacts::admin.edit_fax'), ['class' => 'control-label']) !!}
                    {!! Form::text('fax', Input::old('fax', $contact->fax), ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('email', trans('contacts::admin.edit_email'), ['class' => 'control-label']) !!}
                    {!! Form::text('email', Input::old('email', $contact->email), ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">{{ trans('contacts::admin.edit_edit') }}</button>
                    <button class="btn btn-default" type="button" onclick="location.href='{{ url('administrator/contacts') }}'">{{ trans('contacts::admin.edit_cancel') }}</button>
                </div>
                {!! Form::close() !!}
            </div>
            
        </section>
    </div>
</div>
@endsection