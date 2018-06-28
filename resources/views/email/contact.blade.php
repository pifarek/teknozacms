@extends('email.template')

@section('content')

<div style="padding: 10px 20px;">
    Ip Address: <strong>{{ $ip_addr }}</strong><br />
    Name: <strong>{{ $name }}</strong><br />
    Email: <strong>{{ $email }}</strong><br />
    Message: <strong>{{ $body }}</strong>
</div>
@endsection