@extends('newsletter.views.email.template')

@section('content')

<img src="{{ url('upload/newsletter/' . $image) }}" alt=""/>

@endsection
            