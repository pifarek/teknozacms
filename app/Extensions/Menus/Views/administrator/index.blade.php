@extends('administrator.layouts.default')

@section('content')

<div class="main-container" id="page-menus">
    @include('administrator.layouts.partial.heading',
    [
        'items' => collect([['url' => '', 'title' => trans('menus::admin.menus_index_page_title')]]),
        'buttons' => collect([['url' => url('administrator/menus/add'), 'title' => 'Add Menu', 'icon' => 'plus']])
    ])

    <div class="main-content">
        <section>
            <div class="page-header">
                <h2>
                    {{ trans('menus::admin.menus_index_page_title') }}
                </h2>
                <p class="lead">{{ trans('menus::admin.menus_index_page_description') }}</p>
            </div>
            
            @if(Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif

            @if($menus->count())
            <div class="card">
                <table class="table">
                    <thead>
                        <th>{{ trans('menus::admin.menus_index_name') }}</th>
                        <th>{{ trans('menus::admin.menus_index_code') }}</th>
                        <th>{{ trans('menus::admin.menus_index_actions') }}</th>
                    </thead>
                    <tbody>
                        @foreach($menus as $menu)
                        <tr>
                            <td>{{ $menu->name }}</td>
                            <td>{{ $menu->code }}</td>
                            <td>
                                <a class="btn btn-sm btn-primary" href="{{url('administrator/menus/items/' . $menu->id)}}"><i class="fa fa-list"></i> {{ trans('menus::admin.menus_index_items') }}</a>
                                <a class="btn btn-sm btn-primary" href="{{url('administrator/menus/edit/' . $menu->id)}}"><i class="fa fa-edit"></i> {{ trans('admin.edit') }}</a>
                                <a data-id="{{ $menu->id }}" class="btn btn-sm btn-danger remove-menu" href="#"><i class="fa fa-trash-alt"></i> {{ trans('admin.remove') }}</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="alert alert-info">{{ __('menus::admin.menus_index_empty') }}</div>
            @endif
            
        </section>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        var MenusTranslations = {'js_menus_remove': '{{ __('menus::admin.js_menus_remove') }}'};
    </script>
@endsection