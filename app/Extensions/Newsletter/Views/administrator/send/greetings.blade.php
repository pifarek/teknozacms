@extends('administrator.layouts.default')

@section('content')

<div class="main-container" id="page-newsletter-send-greetings">

    @include('administrator.layouts.partial.heading',
    [
        'items' => collect([['url' => url('administrator/newsletter/send'), 'title' => __('newsletter::admin.send_index_page_title')], ['url' => '', 'title' => __('newsletter::admin.send_greetings_page_title')]]),
        'buttons' => collect()
    ])

    <div class="main-content">
        <section>
            <div class="page-header">
                <h1>{{ trans('newsletter::admin.send_greetings_page_title') }}</h1>
                <p class="lead"> {{ trans('newsletter::admin.send_greetings_page_description') }}</p>
            </div>
            
            @if($errors->count())
            <div class="alert alert-warning">{{ $errors->first() }}</div>
            @endif
            
            <div class="well">
                {!! Form::open(['class' => 'form-floating', 'files' => true]) !!}
                <div class="form-group{!! $errors->has('type')? ' has-error' : '' !!}">
                    {!! Form::label('type', trans('newsletter::admin.send_greetings_type'), ['class' => 'control-label']) !!}
                    {!! Form::select('type', ['users' => trans('newsletter::admin.send_greetings_type_users'), 'groups' => trans('newsletter::admin.send_greetings_type_groups')], Input::old('type'), ['class' => 'form-control selectpicker']) !!}
                </div>
                <div class="users-list-container">
                    @if($users->count())
                    <div class="users-list">
                        @foreach($users as $user)
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="users[]" value="{{ $user->id }}"> {{ $user->email }}
                            </label>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="alert alert-warning">{{ trans('newsletter::admin.send_greetings_users_empty') }}</div>
                    @endif
                </div>
                <div class="groups-list-container">
                    @if($groups->count())
                    <div class="groups-list">
                        @foreach($groups as $group)
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="groups[]" value="{{ $group->id }}"> {{ $group->name }} ({{ $group->users->count() }})
                            </label>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="alert alert-warning">{{ trans('newsletter::admin.send_greetings_groups_empty') }}</div>
                    @endif
                </div>
                <div class="form-group{!! $errors->has('subject')? ' has-error' : '' !!}">
                    {!! Form::label('subject', trans('newsletter::admin.send_greetings_subject'), ['class' => 'control-label']) !!}
                    {!! Form::text('subject', Input::old('subject'), ['class' => 'form-control']) !!}
                </div>
                <div class="form-group{!! $errors->has('image')? ' has-error' : '' !!}">
                    {!! Form::file('image') !!}
                    <span class="help-block">{{ trans('newsletter::admin.send_greetings_image_info') }}</span>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">{{ trans('newsletter::admin.send_greetings_submit') }}</button>
                    <button class="btn btn-default" type="button" onclick="location.href='{{ url('administrator/newsletter/send') }}'">{{ trans('admin.cancel') }}</button>
                </div>
                {!! Form::close() !!}
            </div>
            
        </section>
    </div>
</div>
@endsection