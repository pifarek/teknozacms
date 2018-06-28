@extends('page.layouts.default')

@section('content')

<div class="container">
    @if($display === 'list')
        @if($contacts->count())
            <div class="list-group">
                @foreach($contacts as $contact)
                <a href="{!! Page::link(['type' => 'contact'], [], $contact->id) !!}" class="list-group-item list-group-item-action">
                    {{ $contact->name }}
                </a>
                @endforeach
            </div>
        @else
            <div class="alert alert-warning">No contacts are defined!</div>
        @endif
    @else

        <h3>{{ $contact->name }}</h3>
        <p>{{ $contact->description }}</p>

        <address>
            {{ $contact->street }}, {{ $contact->post }} {{ $contact->city }}
        </address>

        @if($errors->count())
            <div class="alert alert-warning">{{ $errors->first() }}</div>
        @endif

        @if($success)
            <div class="alert alert-success">Your message has been successfully sent!</div>
        @endif

        @if(!$success)
        <form method="post">
            {{ csrf_field() }}
            <div class="form-group row">
                <div class="col">
                    <input type="text" class="form-control{!! $errors->has('name')? ' is-invalid' : '' !!}" placeholder="First name" name="name" value="{{ old('name') }}">
                </div>
                <div class="col">
                    <input type="text" class="form-control{!! $errors->has('email')? ' is-invalid' : '' !!}" placeholder="Your e-mail address" name="email" value="{{ old('email') }}">
                </div>
            </div>
            <div class="form-group row">
                <div class="col">
                    <textarea name="message" placeholder="Your message" rows="5" class="form-control{!! $errors->has('message')? ' is-invalid' : '' !!}">{{ old('message') }}</textarea>
                </div>
            </div>
            <div class="form-group row">
                <div class="col">
                    <button type="submit" class="form-control">Send a message!</button>
                </div>
            </div>
        </form>
        @endif
    @endif
</div>

@endsection