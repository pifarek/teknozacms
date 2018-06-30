@extends('administrator.layouts.default')

@section('content')

<div class="main-container" id="page-projects">

    @include('administrator.layouts.partial.heading',
    [
        'items' => collect([['url' => '', 'title' => trans('projects::admin.projects_index_page_title')]]),
        'buttons' => collect([['url' => url('administrator/projects/create'), 'title' => trans('projects::admin.projects_index_add'), 'icon' => 'plus']])
    ])

    <div class="main-content">
        <section>
            <div class="page-header">
                <h1>{{ trans('projects::admin.projects_index_page_title') }}</h1>
                <p class="lead"> {{ trans('projects::admin.projects_index_page_description') }}</p>
            </div>
            
            @if(Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif
            
            @if($projects->count())
            <div class="card">
                <table class="table table-bordered table-full table-hover table-full-small">
                    <thead>
                        <th>{{ trans('projects::admin.projects_index_name') }}</th>
                        <th>{{ trans('projects::admin.projects_index_year') }}</th>
                        <th>{{ trans('admin.actions') }}</th>
                    </thead>
                    <tbody>
                        @foreach($projects as $project)
                        <tr>
                            <td>{{ $project->name }}</td>
                            <td>
                                @if($project->year)
                                {{ $project->year }}
                                @else
                                --
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-sm btn-default" type="button" onclick="location.href='{{url('administrator/projects/' . $project->id . '/edit')}}';"><i class="fa fa-edit"></i> {{ trans('admin.edit') }}</button>
                                <button data-id="{{ $project->id }}" class="btn btn-sm btn-danger" data-action="project-remove"><i class="fa fa-trash-alt"></i> {{ trans('admin.remove') }}</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="alert alert-info">{{ trans('projects::admin.projects_index_empty') }}</div>
            @endif
        </section>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        var ProjectsTranslations = {'js_remove': '{{ __('projects::admin.js_remove') }}'};
    </script>
@endsection