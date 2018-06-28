@extends('email.template')

@section('content')

    <a href="{{ url('administrator/auth/reset/' . $reset_token) }}">Reset Your Password</a>

@endsection