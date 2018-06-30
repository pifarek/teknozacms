@extends('administrator.layouts.default')

@section('content')

<div class="main-container" id="page-newsletter">

    @include('administrator.layouts.partial.heading',
    [
        'items' => collect([['url' => '', 'title' => __('newsletter::admin.index_page_title')]]),
        'buttons' => collect([['url' => url('administrator/newsletter/create'), 'title' => __('newsletter::admin.index_add'), 'icon' => 'plus']])
    ])

    <div class="main-content">
        <section>
            <div class="page-header">
                <h1>{{ trans('newsletter::admin.index_page_title') }}</h1>
                <p class="lead"> {{ trans('newsletter::admin.index_page_description') }}</p>
            </div>
            
            @if(Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif
            
            @if($emails->count())
            <div class="card">
                <table class="table table-bordered table-full table-hover table-full-small">
                    <thead>
                        <th>{{ trans('newsletter::admin.index_email') }}</th>
                        <th>{{ trans('newsletter::admin.index_name') }}</th>
                        <th>{{ trans('newsletter::admin.index_surname') }}</th>
                        <th>{{ trans('newsletter::admin.index_group') }}</th>
                        <th>{{ trans('newsletter::admin.index_created') }}</th>
                        <th>{{ trans('admin.actions') }}</th>
                    </thead>
                    <tbody>
                        @foreach($emails as $email)
                        <tr>
                            <td>{{ $email->email }}</td>
                            <td>{{ $email->name }}</td>
                            <td>{{ $email->surname }}</td>
                            <td>
                                @if($email->group_id)
                                {{ $email->group->name }}
                                @endif
                            </td>
                            <td>
                                {{ \Date::parse($email->created_at)->format('d F Y, H:i:s') }}
                            </td>
                            <td>
                                <button class="btn btn-sm btn-secondary" type="button" onclick="location.href='{{ url('administrator/newsletter/' . $email->id . '/edit')}}';"><i class="fa fa-edit"></i> {{ trans('admin.edit') }}</button>
                                <button data-id="{{ $email->id }}" class="btn btn-sm btn-danger" data-action="newsletter-remove"><i class="fa fa-trash-alt"></i> {{ trans('admin.remove') }}</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="alert alert-info">{{ trans('newsletter::admin.index_empty') }}</div>
            @endif
        </section>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        var NewsletterTranslations = {'js_remove': '{{ __('newsletter::admin.js_remove') }}'};
    </script>
@endsection