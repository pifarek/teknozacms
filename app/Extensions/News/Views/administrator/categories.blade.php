@extends('administrator.layouts.default')

@section('content')

<div class="main-container" id="page-news-categories">
    @include('administrator.layouts.partial.heading',
    [
        'items' => collect([['url' => url('administrator/news'), 'title' => trans('news::admin.news_index_page_title')], ['url' => '', 'title' => trans('news::admin.news_category_index_page_title')]]),
        'buttons' => collect([['url' => url('administrator/news/categories/create'), 'title' => trans('news::admin.news_category_index_add'), 'icon' => 'plus']])
    ])

    <div class="main-content">
        <section>
            <div class="page-header">
                <h1>{{ trans('news::admin.news_category_index_page_title') }}</h1>
                <p class="lead"> {{ trans('news::admin.news_category_index_page_description') }}</p>
            </div>
            
            @if($errors->count())
            <div class="alert alert-warning">{{ $errors->first() }}</div>
            @endif
            
            @if(Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif
            
            <div class="card">
                @if($categories->count())
                <table class="table table-bordered table-full table-full-small">
                    <thead>
                        <th>{{ trans('news::admin.news_category_index_name') }}</th>
                        <th>{{ trans('admin.actions') }}</th>
                    </thead>
                    <tbody>

                        @foreach($categories as $category)
                        <tr>
                            <td>{{ $category->name }}</td>
                            <td>
                                <button class="btn btn-sm btn-default" type="button" onclick="location.href='{{url('administrator/news/categories/' . $category->id . '/edit')}}';"><i class="fa fa-pencil-alt"></i> {{ trans('admin.edit') }}</button>
                                <button data-id="{{ $category->id }}" class="btn btn-sm btn-danger" data-action="category-remove"><i class="fa fa-trash-alt"></i> {{ trans('admin.remove') }}</button>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
                @else
                <div class="alert alert-info">{{ trans('news::admin.news_category_index_empty') }}</div>
                @endif
            </div>
        </section>
    </div>
    
</div>
@endsection

@section('scripts')
    <script>
        var MenusTranslations = {'js_category_remove': '{{ __('menus::admin.js_category_remove') }}'};
    </script>
@endsection