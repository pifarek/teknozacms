@extends('administrator.layouts.default')

@section('content')

<div class="main-container" id="page-newsletter-send">
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header pull-left">
                <button type="button" class="navbar-toggle pull-left m-15" data-activates=".sidebar"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                <ul class="breadcrumb">
                    <li><a href="{{ url('administrator') }}">{{ trans('admin.title') }}</a></li>
                    <li><a href="{{ url('administrator/newsletter') }}">{{ trans('newsletter::admin.index_page_title') }}</a></li>
                    <li class="active">{{ trans('newsletter::admin.send_page_title') }}</li>
                </ul>
            </div> 
            <ul class="nav navbar-nav navbar-right navbar-right-no-collapse">
                @include('administrator.layouts.partial.header-menu')
            </ul>
        </div>
    </nav>
    <div class="main-content" init-ripples="" bs-affix-target="" autoscroll="true">
        <section>
            <div class="page-header">
                <h1><i class="md md-list"></i> {{ trans('newsletter::admin.send_page_title') }}</h1>
                <p class="lead"> {{ trans('newsletter::admin.send_page_description') }}</p>
            </div>
            
            @if($errors->has())
            <div class="alert alert-warning">{{ $errors->first() }}</div>
            @endif
            
            @if(Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif
            
            <div class="well white">
                <h3>Select newsletter type</h3>
                {!! Form::open(['class' => 'form-floating']) !!}
                <div class="form-group">
                    <div class="radio">
                        <label>
                            <input type="radio" name="newsletter_type" id="newsletter_type1" value="option_1">
                            Greetings
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="newsletter_type" id="newsletter_type2" value="option_2">
                            Selected content
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="newsletter_type" id="newsletter_type3" value="option_3">
                            Create an email
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">Continue</button>
                    <button class="btn btn-default" type="button" onclick="location.href='{{ url('administrator/newsletter') }}'">{{ trans('admin.cancel') }}</button>
                </div>
                {!! Form::close() !!}
            </div>
        </section>
    </div>
</div>
@endsection