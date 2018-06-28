@extends('administrator.layouts.default')

@section('content')

<div class="main-container" id="page-contacts">

    @include('administrator.layouts.partial.heading',
    [
        'items' => collect([['url' => '', 'title' => __('contacts::admin.index_page_title')]]),
        'buttons' => collect([['url' => url('administrator/contacts/create'), 'title' => __('contacts::admin.index_add'), 'icon' => 'plus']])
    ])

    <div class="main-content">
        <section>
            <div class="page-header">
                <h1><i class="md md-list"></i> {{ trans('contacts::admin.index_page_title') }}</h1>
                <p class="lead"> {{ trans('contacts::admin.index_page_description') }}</p>
            </div>
            
            @if(Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif
            
            <div class="card">
                @if($contacts->count())
                <table class="table table-bordered table-full table-full-small">
                <thead>
                    <th>{{ trans('contacts::admin.index_name') }}</th>
                    <th>{{ trans('contacts::admin.index_actions') }}</th>
                </thead>
                <tbody>
                    @foreach($contacts as $contact)
                    <tr>
                        <td>{{ $contact->name }}</td>
                        <td>
                            <button class="btn btn-sm btn-default" type="button" onclick="location.href='{{url('administrator/contacts/' . $contact->id . '/edit')}}';"><i class="fa fa-edit"></i> {{ trans('admin.edit') }}</button>
                            <button data-id="{{ $contact->id }}" class="btn btn-sm btn-danger" data-action="contact-remove"><i class="fa fa-trash-alt"></i> {{ trans('admin.remove') }}</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="alert alert-info">{{ trans('contacts::admin.index_empty') }}</div>
            @endif
            </div>

        </section>
    </div>
</div>
@endsection