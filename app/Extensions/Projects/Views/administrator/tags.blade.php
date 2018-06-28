@extends('administrator.layouts.default')

@section('content')

<div class="main-container" id="page-projects-tags">

    @include('administrator.layouts.partial.heading',
    [
        'items' => collect([['url' => '', 'title' => __('projects::admin.projects_tags_page_title')]]),
        'buttons' => collect([['url' => url('administrator/projects/tags/create'), 'title' => __('projects::admin.projects_tags_add'), 'icon' => 'plus']])
    ])

    <div class="main-content">
        <section>
            <div class="page-header">
                <h1><i class="md md-list"></i> {{ __('projects::admin.projects_tags_page_title') }}</h1>
                <p class="lead"> {{ __('projects::admin.projects_tags_page_description') }}</p>
            </div>
            
            @if(Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif
            
            @if($tags->count())
            <div class="card">
                <table class="table table-bordered table-full table-hover table-full-small">
                    <thead>
                        <th>{{ __('projects::admin.projects_tags_name') }}</th>
                        <th>{{ __('admin.actions') }}</th>
                    </thead>
                    <tbody>
                        @foreach($tags as $tag)
                        <tr>
                            <td>{{ $tag->name }}</td>
                            <td>
                                <button class="btn btn-sm btn-default" type="button" onclick="location.href='{{url('administrator/projects/tags/' . $tag->id . '/edit')}}';"><i class="fa fa-edit"></i> {{ __('admin.edit') }}</button>
                                <button data-id="{{ $tag->id }}" class="btn btn-sm btn-danger" data-action="tag-remove"><i class="fa fa-trash-alt"></i> {{ __('admin.remove') }}</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="alert alert-info">{{ __('projects::admin.projects_tags_empty') }}</div>
            @endif
        </section>
    </div>
</div>
@endsection