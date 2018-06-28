@extends('administrator.layouts.default')

@section('content')

<div class="main-container" id="page-settings-locales-list">

    @include('administrator.layouts.partial.heading',
    [
        'items' => collect([['url' => '', 'title' => __('admin.settings_locales_page_title')]]),
        'buttons' => collect([['url' => url('administrator/settings/locales/add'), 'title' => __('admin.settings_locales_add'), 'icon' => 'plus']])
    ])

    <div class="main-content">
        <section>
            <div class="page-header">
                <h1>{{ trans('admin.settings_locales_page_title') }}</h1>
                <p class="lead"> {{ trans('admin.settings_locales_page_description') }}</p>
            </div>

            @if(Session::get('success'))
                <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif

            <div class="card">
                <table class="table table-bordered table-full table-full-small">
                    <thead>
                        <th>{{ trans('admin.settings_locales_name') }}</th>
                        <th>{{ trans('admin.settings_locales_language') }}</th>
                        <th>{{ trans('admin.actions') }}</th>
                    </thead>
                    <tbody>
                        @if($locales)
                        @foreach($locales as $locale)
                        <tr>
                            <td>{{ $locale->name }}</td>
                            <td>{{ $locale->language }}</td>
                            <td>
                                <button class="btn btn-sm btn-default" type="button" onclick="location.href='{{url('administrator/settings/locales/edit/' . $locale->id)}}';"><i class="fa fa-pencil-alt"></i> {{ trans('admin.edit') }}</button>
                                <button data-action="locale-remove" data-id="{{ $locale->id }}" class="btn btn-sm btn-danger"><i class="fa fa-trash-alt"></i> {{ trans('admin.remove') }}</button>
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>
@endsection