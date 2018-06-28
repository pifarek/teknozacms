@extends('administrator.layouts.default')

@section('content')

<div class="main-container" id="page-newsletter-send">

    @include('administrator.layouts.partial.heading',
    [
        'items' => collect([['url' => url('administrator/newsletter'), 'title' => __('newsletter::admin.index_page_title')], ['url' => '', 'title' => __('newsletter::admin.send_index_page_title')]]),
        'buttons' => collect()
    ])

    <div class="main-content" autoscroll="true">
        <section>
            <div class="page-header">
                <h1><i class="md md-list"></i> {{ trans('newsletter::admin.send_index_page_title') }}</h1>
                <p class="lead"> {{ trans('newsletter::admin.send_index_page_description') }}</p>
            </div>
            
            @if($errors->count())
            <div class="alert alert-warning">{{ $errors->first() }}</div>
            @endif
            
            @if(Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif
            
            <div class="well white">
                <h3>{{ trans('newsletter::admin.send_index_type') }}</h3>
                {!! Form::open(['class' => 'form-floating']) !!}
                <div class="form-group">
                    <div class="radio">
                        <label>
                            <input type="radio" name="newsletter_type" id="newsletter_type1" value="option_1">
                            {{ trans('newsletter::admin.send_index_type_greetings') }}
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="newsletter_type" id="newsletter_type2" value="option_2">
                            {{ trans('newsletter::admin.send_index_type_content') }}
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="newsletter_type" id="newsletter_type3" value="option_3">
                            {{ trans('newsletter::admin.send_index_type_empty') }}
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">{{ trans('newsletter::admin.send_index_submit') }}</button>
                    <button class="btn btn-default" type="button" onclick="location.href='{{ url('administrator/newsletter') }}'">{{ trans('admin.cancel') }}</button>
                </div>
                {!! Form::close() !!}
            </div>
        </section>
    </div>
</div>
@endsection