@extends('administrator.layouts.default')

@section('content')

<div class="main-container" id="page-settings-emails">
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header pull-left">
                <button type="button" class="navbar-toggle pull-left m-15" data-activates=".sidebar"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                <ul class="breadcrumb">
                    <li><a href="{{ url('administrator') }}">{{ trans('admin.title') }}</a></li>
                    <li class="active"><a href="{{ url('administrator/settings/emails') }}">{{ trans('admin.settings_emails_page_title') }}</a></li>
                </ul>
            </div> 
            <ul class="nav navbar-nav navbar-right navbar-right-no-collapse">
                @include('administrator.layouts.partial.header-menu')
                <li class="pull-right">
                    <button class="btn btn-primary" onclick="location.href='{{ url('administrator/settings/email-add') }}'"><i class="md md-add"></i> {{ trans('admin.settings_emails_add') }}</button>
                </li>
            </ul>
        </div>
    </nav>
    <div class="main-content" init-ripples="" bs-affix-target="" autoscroll="true">
        <section>
            <div class="page-header">
                <h1><i class="md md-list"></i> {{ trans('admin.settings_emails_page_title') }}</h1>
                <p class="lead"> {{ trans('admin.settings_emails_page_description') }}</p>
            </div>
            
            @if(Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif
            
            @if($templates->count())
            <div class="card">
                <table class="table table-bordered table-full table-full-small">
                    <thead>
                        <th>{{ trans('admin.settings_emails_tag') }}</th>
                        <th>{{ trans('admin.settings_emails_subject') }}</th>
                        <th>{{ trans('admin.actions') }}</th>
                    </thead>
                    <tbody>
                        @foreach($templates as $template)
                        <tr>
                            <td>{{ $template->tag }}</td>
                            <td>{{ $template->subject }}</td>
                            <td>
                                <button class="btn btn-sm btn-default" type="button" onclick="location.href='{{url('administrator/settings/email/' . $template->id)}}';"><i class="md md-edit"></i> {{ trans('admin.edit') }}</button>
                                <button data-id="{{ $template->id }}" class="btn btn-sm btn-danger email-remove"{!! $template->isStatic()? ' disabled="disabled"' : '' !!}><i class="md md-remove-circle-outline"></i> {{ trans('admin.remove') }}</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="alert alert-warning">{{ trans('admin.settings_emails_empty') }}</div>
            @endif
            
        </section>
    </div>
</div>

@stop