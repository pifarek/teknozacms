@extends('newsletter.views.email.template')

@section('content')

<div style="padding: 0 20px; margin-bottom: 20px;">
    {!! $description !!}
</div>

{!! $content !!}
@endsection