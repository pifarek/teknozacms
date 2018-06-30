@extends('administrator.layouts.default')

@section('content')

<div class="main-container" id="page-menus-items">
    @include('administrator.layouts.partial.heading',
    [
        'items' => collect([['url' => url('administrator/menus'), 'title' => trans('menus::admin.menus_index_page_title')], ['url' => '', 'title' => trans('menus::admin.menus_items_page_title')]]),
        'buttons' => collect([['url' => url('administrator/menus/items/' . $menu->id . '/add'), 'title' => trans('menus::admin.menus_items_add'), 'icon' => 'plus']])
    ])

    <div class="main-content">
        <section>
            <div class="page-header">
                <h2>
                    {{ trans('menus::admin.menus_items_page_title') }}
                </h2>
                <p class="lead"> {{ trans('menus::admin.menus_items_page_description') }}</p>
            </div>

            @if(Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif

            <?php
            function childItems($items, $menu, $level = 0){
                $count = 0;

                foreach($items as $item){

                    $first = false;
                    $last = false;
                    if($count === 0){
                        $first = true;
                    }
                    if($count === $items->count() - 1){
                        $last = true;
                    }
            ?>
                <tr>
                    <td>{{ str_repeat('&mdash;', $level) }} {{ $item->name }}</td>
                    <td>{{ $item->url }}</td>
                    <td>
                        {{ $item->getType() }}
                    </td>
                    <td>
                        @if(!$first)
                        <button data-id="{{ $item->id }}" data-menu="{{ $menu->id }}" class="btn btn-sm btn-danger move-up"><i class="fa fa-caret-up"></i></button>
                        @endif
                        @if(!$last)
                        <button data-id="{{ $item->id }}" data-menu="{{ $menu->id }}" class="btn btn-sm btn-info move-down"><i class="fa fa-caret-down"></i></button>
                        @endif
                    </td>
                    <td>
                        <button class="btn btn-sm btn-default" type="button" onclick="location.href='{{url('administrator/menus/items/' . $menu->id . '/edit/' . $item->id)}}';"><i class="fa fa-edit"></i> {{ trans('admin.edit') }}</button>
                        <button data-id="{{ $item->id }}" data-menu="{{ $menu->id }}" class="btn btn-sm btn-danger remove-menu-item"><i class="fa fa-trash-alt"></i> {{ trans('admin.remove') }}</button>
                    </td>
                </tr>
            <?php
                    if($item->children->count()){
                        $level++;
                        childItems($item->children, $menu, $level);
                        $level--;
                    }
                    $count++;
                }
            }
            ?>

            <div class="row">
                <div class="col-md-12">
                    <div class="card white">
                    @if($items->count())
                    <table class="table table-bordered table-full table-hover table-full-small">
                        <thead>
                            <th>{{ trans('menus::admin.menus_items_name') }}</th>
                            <th>{{ trans('menus::admin.menus_items_url') }}</th>
                            <th>{{ trans('menus::admin.menus_items_type') }}</th>
                            <th>{{ trans('menus::admin.menus_items_order') }}</th>
                            <th>{{ trans('admin.actions') }}</th>
                        </thead>
                        <tbody>
                            <?php childItems($items, $menu);?>
                        </tbody>
                    </table>
                    @else
                    <div class="alert alert-info">{{ trans('menus::admin.menus_items_empty') }}</div>
                    @endif
                    </div>
                </div>
            </div>

        </section>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        var MenusTranslations = {'js_items_remove': '{{ __('menus::admin.js_items_remove') }}'};
    </script>
@endsection