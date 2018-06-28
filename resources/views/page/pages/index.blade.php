@extends('page.layouts.default')

@section('content')

    <div class="container">
        {!! Module::display('slider', ['shortcode' => 'homepage']) !!}
    </div>

<div class="container">
    <div class="jumbotron" style="margin-top: 10%;">
      <h1>Teknoza CMS</h1>
      <p>Content Management System</p>
      <p>
          <a class="btn btn-primary btn-lg" href="http://www.teknoza.be" role="button">Learn more</a>
          <a class="btn btn-danger btn-lg" href="{{ url('administrator') }}" role="button">Administrator</a>
      </p>
    </div>
</div>

@endsection