@extends('administrator.layouts.default')

@section('content')

<div class="main-container" id="page-events-add">

    @include('administrator.layouts.partial.heading',
    [
        'items' => collect([['url' => url('administrator/events'), 'title' => __('events::admin.add_events')], ['url' => '', 'title' => __('events::admin.add_page_title')]]),
        'buttons' => collect()
    ])

    <div class="main-content">
        <section>
            <div class="page-header">
                <h1>{{ trans('events::admin.add_page_title') }}</h1>
                <p class="lead"> {{ trans('events::admin.add_page_description') }}</p>
            </div>
            
            @if($errors->count())
            <div class="alert alert-warning">{{ $errors->first() }}</div>
            @endif
            
            <div class="well white">
                {!! Form::open(['class' => 'form-floating', 'url' => url('administrator/events')]) !!}
                    <ul class="nav nav-tabs" role="tablist">
                        @foreach($locales as $locale)
                        <li role="presentation"><a href="#variable-{{ $locale->language }}" aria-controls="variable-{{ $locale->language }}" role="tab" data-toggle="tab">{{ $locale->name }} <i class="flag flag-{{ $locale->language }}"></i></a></li>
                        @endforeach
                    </ul>

                    <div class="tab-content">
                        @foreach($locales as $locale)
                        <div role="tabpanel" class="tab-pane" id="variable-{{ $locale->language }}">
                            <div class="form-group{!! $errors->has('name-' . $locale->language)? ' has-error' : '' !!}">
                                {!! Form::label('name-' . $locale->language, trans('events::admin.add_name'), ['class' => 'control-label']) !!}
                                {!! Form::text('name-' . $locale->language, old('name-' . $locale->language), ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit">{{ trans('events::admin.add_add') }}</button>
                        <button class="btn btn-default" type="button" onclick="location.href='{{ url('administrator/events') }}'">{{ trans('events::admin.add_cancel') }}</button>
                    </div>
                {!! Form::close() !!}
            </div>
        </section>
    </div>
</div>
@endsection
