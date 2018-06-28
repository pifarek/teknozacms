@extends('administrator.layouts.default')

@section('content')

<div class="main-container" id="page-newsletter-groups">

    @include('administrator.layouts.partial.heading',
    [
        'items' => collect([['url' => url('administrator/newsletter'), 'title' => __('newsletter::admin.index_page_title')], ['url' => '', 'title' => __('newsletter::admin.groups_page_title')]]),
        'buttons' => collect([['url' => url('administrator/newsletter/groups/create'), 'title' => __('newsletter::admin.groups_add'), 'icon' => 'plus']])
    ])

    <div class="main-content">
        <section>
            <div class="page-header">
                <h1>{{ trans('newsletter::admin.groups_page_title') }}</h1>
                <p class="lead"> {{ trans('newsletter::admin.groups_page_description') }}</p>
            </div>
            
            @if(Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif
            
            @if($groups->count())
            <div class="card">
                <table class="table table-bordered table-full table-hover table-full-small">
                    <thead>
                        <th>{{ trans('newsletter::admin.groups_name') }}</th>
                        <th>{{ trans('admin.actions') }}</th>
                    </thead>
                    <tbody>
                        @foreach($groups as $group)
                        <tr>
                            <td>{{ $group->name }}</td>
                            <td>
                                <button class="btn btn-sm btn-secondary" type="button" onclick="location.href='{{url('administrator/newsletter/groups/' . $group->id . '/edit')}}';"><i class="fa fa-edit"></i> {{ trans('admin.edit') }}</button>
                                <button data-id="{{ $group->id }}" class="btn btn-sm btn-danger" data-action="group-remove"><i class="fa fa-trash-alt"></i> {{ trans('admin.remove') }}</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="alert alert-info">{{ trans('newsletter::admin.groups_empty') }}</div>
            @endif
        </section>
    </div>
</div>
@endsection