@extends('administrator.layouts.default')

@section('content')

<div class="main-container" id="page-newsletter-send-content">

    @include('administrator.layouts.partial.heading',
    [
        'items' => collect([['url' => url('administrator/newsletter/send'), 'title' => __('newsletter::admin.send_index_page_title')], ['url' => '', 'title' => __('newsletter::admin.send_content_page_title')]]),
        'buttons' => collect()
    ])

    <div class="main-content">
        <section>
            <div class="page-header">
                <h1>{{ trans('newsletter::admin.send_content_page_title') }}</h1>
                <p class="lead"> {{ trans('newsletter::admin.send_content_page_description') }}</p>
            </div>
            
            @if($errors->count())
            <div class="alert alert-warning">{{ $errors->first() }}</div>
            @endif
            
            @if($step === 1)
            
            <div class="well">
                {!! Form::open(['class' => 'form-floating step1']) !!}
                <h3>{{ trans('newsletter::admin.send_content_select') }}</h3>
                <div class="row">
                    <div class="col-md-6">
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#active" aria-controls="active" role="tab" data-toggle="tab">{{ trans('newsletter::admin.send_content_newsletter')}} (<span id="newsletter_elements_count">0</span>)</a></li>
                        </ul>
                        
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="active">
                                <div class="alert alert-info drag-info">{{ trans('newsletter::admin.send_content_drag_info') }}</div>
                                <ul class="elements" id="newsletter-sortable1">
                                    
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 clearfix">
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#news" aria-controls="news" role="tab" data-toggle="tab">{{ trans('newsletter::admin.send_content_news') }} (<span id="news_elements_count">{{ $news->count() }}</span>)</a></li>
                            <li role="presentation"><a href="#events" aria-controls="events" role="tab" data-toggle="tab">{{ trans('newsletter::admin.send_content_events') }} (<span id="events_elements_count">{{ $events->count() }}</span>)</a></li>
                            <li class="pull-right search-elements">
                                <input type="text" name="search" placeholder="{{ trans('newsletter::admin.send_content_drag_search') }}">
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="news">
                                <ul class="elements" id="newsletter-sortable2">
                                    @if($news->count())
                                    @foreach($news as $single)
                                    <li class="news-element" data-type="news" data-id="{{ $single->id }}">
                                        <h4>{{ $single->title }}</h4>
                                        <p>{{ str_limit(strip_tags($single->description), 100) }}</p>
                                    </li>
                                    @endforeach
                                    @endif
                                </ul>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="events">
                                <ul class="elements" id="newsletter-sortable3">
                                    @if($events->count())
                                    @foreach($events as $event)
                                    <li class="event-element" data-type="event" data-id="{{ $event->id }}">
                                        <h4>{{ $event->title }}</h4>
                                        <p>{{ str_limit(strip_tags($event->description), 100) }}</p>
                                    </li>
                                    @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">{{  trans('newsletter::admin.send_content_submit') }}</button>
                    <button class="btn btn-default" type="button" onclick="location.href='{{ url('administrator/newsletter/send') }}'">{{ trans('admin.cancel') }}</button>
                </div>
            </div>
            
            @elseif($step === 2)
            <div class="well">
                {!! Form::open(['class' => 'form-floating step2']) !!}
                <div class="form-group{!! $errors->has('type')? ' has-error' : '' !!}">
                    {!! Form::label('type', trans('newsletter::admin.send_content_type'), ['class' => 'control-label']) !!}
                    {!! Form::select('type', ['users' => trans('newsletter::admin.send_content_type_users'), 'groups' => trans('newsletter::admin.send_content_type_groups')], Input::old('type'), ['class' => 'form-control selectpicker']) !!}
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
                    <div class="alert alert-warning">{{ trans('newsletter::admin.send_content_users_empty') }}</div>
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
                    <div class="alert alert-warning">{{ trans('newsletter::admin.send_content_groups_empty') }}</div>
                    @endif
                </div>
                <div class="form-group{!! $errors->has('subject')? ' has-error' : '' !!}">
                    {!! Form::label('subject', trans('newsletter::admin.send_content_subject'), ['class' => 'control-label']) !!}
                    {!! Form::text('subject', Input::old('subject'), ['class' => 'form-control']) !!}
                </div>
                <div class="form-group tinymce{!! $errors->has('content')? ' has-error' : '' !!}">
                    {!! Form::label('content', trans('newsletter::admin.send_content_message'), ['class' => 'control-label']) !!}
                    {!! Form::textarea('content', Input::old('content'), ['class' => 'form-control tinymce']) !!}
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">{{ trans('newsletter::admin.send_content_submit2') }}</button>
                    <button class="btn btn-default" type="button" onclick="location.href='{{ url('administrator/newsletter/send') }}'">{{ trans('admin.cancel') }}</button>
                </div>
            </div>
            @endif
            
        </section>
    </div>
</div>
@endsection