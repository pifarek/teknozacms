@extends('email.template')

@section('content')

    Your new password is: <strong>{{ $new_password }}</strong>

@endsection