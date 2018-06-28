@extends('administrator.layouts.default')

@section('content')

<div class="main-container" id="page-events">

    @include('administrator.layouts.partial.heading',
    [
        'items' => collect([['url' => '', 'title' => __('events::admin.index_page_title')]]),
        'buttons' => collect([['url' => url('administrator/events/create'), 'title' => __('events::admin.index_add'), 'icon' => 'plus']])
    ])

    <div class="main-content">
        <section>
            <div class="page-header">
                <h1>{{ trans('events::admin.index_page_title') }}</h1>
                <p class="lead"> {{ trans('events::admin.index_page_description') }}</p>
            </div>
            
            @if(Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif
            
            @if($events->count())
            <div class="card">
                <table class="table table-bordered table-full table-hover table-full-small">
                    <thead>
                        <th>{{ trans('events::admin.index_name') }}</th>
                        <th>{{ trans('events::admin.index_start') }}</th>
                        <th>{{ trans('events::admin.index_end') }}</th>
                        <th>{{ trans('events::admin.index_status') }}</th>
                        <th>{{ trans('admin.actions') }}</th>
                    </thead>
                    <tbody>
                        @foreach($events as $event)
                        <?php
                        $start = new \Date();
                        $start->setTimestamp($event->start_time);
                        $end = new \Date();
                        $end->setTimestamp($event->end_time);
                        ?>
                        <tr>
                            <td>
                                {{ $event->name }}
                            </td>
                            <td>{{ $start->format('d F Y, H:i:s') }}</td>
                            <td>{{ $end->format('d F Y, H:i:s') }}</td>
                            <td>
                                @if($event->status)
                                <span class="badge badge-primary">{{ trans('events::admin.index_status_1') }}</span>
                                @else
                                <span class="badge badge-secondary">{{ trans('events::admin.index_status_0') }}</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-sm btn-secondary" type="button" onclick="location.href='{{url('administrator/events/' . $event->id . '/edit')}}';"><i class="fa fa-edit"></i> {{ trans('admin.edit') }}</button>
                                <button data-id="{{ $event->id }}" class="btn btn-sm btn-danger" data-action="event-remove"><i class="fa fa-trash-alt"></i> {{ trans('admin.remove') }}</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="alert alert-info">{{ trans('events::admin.index_empty') }}</div>
            @endif
        </section>
    </div>
</div>
@endsection