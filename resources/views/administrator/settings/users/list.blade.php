@extends('administrator.layouts.default')

@section('content')

<div class="main-container" id="page-settings-users-list">

    @include('administrator.layouts.partial.heading',
    [
        'items' => collect([['url' => '', 'title' => __('admin.settings_users_index_page_title')]]),
        'buttons' => collect([['url' => url('administrator/settings/users/add'), 'title' => __('admin.settings_users_index_add'), 'icon' => 'plus']])
    ])

    <div class="main-content" autoscroll="true">
        <section>
            <div class="page-header">
                <h1> {{ trans('admin.settings_users_index_page_title') }}</h1>
                <p class="lead"> {{ trans('admin.settings_users_index_page_description') }}</p>
            </div>
            
            @if(Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif

            <div class="card">
                <table id="" class="table table-full table-full-small" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>{{ trans('admin.settings_users_index_email') }}</th>
                            <th>{{ trans('admin.settings_users_index_created') }}</th>
                            <th>{{ trans('admin.settings_users_index_active') }}</th>
                            <th class="no-sort">{{ trans('admin.actions') }}</th>
                        </tr>
                    </thead>

                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{!! $user->email !!}</td>
                            <td>{!! \Date::parse($user->created_at)->format('d F Y') !!}</td>
                            <td>{!! \Date::parse($user->active_at)->format('d F Y') !!}</td>
                            <td>
                                @if (\Auth::guard('administrator')->user()->id != $user->id)
                                <div class="btn-group">
                                    <button onclick="location.href='{{ url('administrator/settings/users/edit/' . $user->id) }}'" class="btn btn-sm btn-default"><i class="fa fa-pencil-alt"></i> {{ trans('admin.edit') }}</button>
                                    <button class="btn btn-sm btn-danger" data-action="user-remove" data-id="{{ $user->id }}"><i class="fa fa-trash-alt"> </i> {{ trans('admin.remove') }}</button>
                                </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>
            </div>

        </section>
    </div>
</div>
@endsection