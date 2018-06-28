@extends('administrator.layouts.default')

@section('content')

<div class="main-container" id="page-partners">

    @include('administrator.layouts.partial.heading',
    [
        'items' => collect([['url' => '', 'title' => __('partners::admin.partners_index_page_title')]]),
        'buttons' => collect([['url' => url('administrator/partners/create'), 'title' => __('partners::admin.partners_index_add'), 'icon' => 'plus']])
    ])

    <div class="main-content">
        <section>
            <div class="page-header">
                <h1>{{ trans('partners::admin.partners_index_page_title') }}</h1>
                <p class="lead"> {{ trans('partners::admin.partners_index_page_description') }}</p>
            </div>
            
            @if($errors->count())
            <div class="alert alert-warning">{{ $errors->first() }}</div>
            @endif
            
            @if(Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif
            
            @if($partners->count())
            <div class="card">
                <table class="table table-bordered table-full table-hover table-full-small">
                    <thead>
                        <th>{{ trans('partners::admin.partners_index_logo') }}</th>
                        <th>{{ trans('partners::admin.partners_index_name') }}</th>
                        <th>{{ trans('partners::admin.partners_index_order') }}</th>
                        <th>{{ trans('partners::admin.actions') }}</th>
                    </thead>
                    <tbody>
                        @foreach($partners as $partner)
                        <tr>
                            <td>
                                @if($partner->filename)
                                <div class="partner-logo">
                                    <img src="{{ url('upload/partners/' . $partner->filename) }}" alt="">
                                </div>
                                @endif
                            </td>
                            <td>
                                {{ $partner->name }}
                            </td>
                            <td>
                                <button data-id="{{ $partner->id }}" data-action="move-up" class="btn btn-sm btn-danger"><i class="fa fa-arrow-up"></i></button>
                                <button data-id="{{ $partner->id }}" data-action="move-down" class="btn btn-sm btn-info"><i class="fa fa-arrow-down"></i></button>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-default" type="button" onclick="location.href='{{url('administrator/partners/' . $partner->id . '/edit')}}';"><i class="fa fa-edit"></i> {{ trans('admin.edit') }}</button>
                                <button data-id="{{ $partner->id }}" class="btn btn-sm btn-danger" data-action="partner-remove"><i class="fa fa-trash-alt"></i> {{ trans('admin.remove') }}</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                
            </div>
            @else
            <div class="alert alert-warning">{{ trans('partners::admin.partners_index_empty') }}</div>
            @endif
        </section>
    </div>
</div>
@endsection