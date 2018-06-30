@extends('administrator.layouts.default')

@section('content')

<div class="main-container" id="page-news">

    @include('administrator.layouts.partial.heading',
    [
        'items' => collect([['url' => '', 'title' => trans('news::admin.news_index_page_title')]]),
        'buttons' => collect([['url' => url('administrator/news/create'), 'title' => trans('news::admin.news_index_add'), 'icon' => 'plus']])
    ])

    <div class="main-content">
        <section>
            <div class="page-header">
                <h1>{{ trans('news::admin.news_index_page_title') }}</h1>
                <p class="lead"> {{ trans('news::admin.news_index_page_description') }}</p>
            </div>
            
            @if($errors->count())
            <div class="alert alert-warning"><i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}</div>
            @endif
            
            @if(Session::get('success'))
                <div class="alert alert-success"><i class="far fa-check-circle"></i> {{ Session::get('success') }}</div>
            @endif
            
            @if($news->count())
            <div class="card">
                <table class="table table-bordered table-full table-hover table-full-small">
                    <thead>
                        <tr>
                            <th></th>
                            <th>{{ trans('news::admin.news_index_title') }}</th>
                            <th>{{ trans('news::admin.news_index_created') }}</th>
                            <th>{{ trans('news::admin.news_index_updated') }}</th>
                            <th>{{ trans('news::admin.news_index_category') }}</th>
                            <th>{{ trans('admin.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($news as $single)
                        <tr>
                            <td>
                                @if($single->filename)
                                <a href="{{ url('upload/news/n/' . $single->filename) }}" data-fancybox="preview"><img src="{{ url('upload/news/s/' . $single->filename) }}" alt="{{ $single->title }}"></a>
                                @endif
                            </td>
                            <td>
                                @foreach($single->translations as $translation)
                                <div><img src="{{ url('assets/administrator/images/flags/' . $translation->locale . '.png') }}" alt=""> {{ $translation->title }}</div>
                                @endforeach
                            </td>
                            <td>
                                <i class="far fa-clock"></i> {{ \Date::parse($single->created_at)->format('d F Y, H:i:s') }}
                            </td>
                            <td>
                                <i class="far fa-clock"></i> {{ \Date::parse($single->updated_at)->format('d F Y, H:i:s') }}
                            </td>
                            <td>
                                @if($single->category_id)
                                <span class="badge badge-info">{{ $single->category->name }}</span>
                                @else
                                <span class="badge badge-primary">@lang('news::admin.news_index_uncategorized')</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-sm btn-default" type="button" onclick="location.href='{{url('administrator/news/' . $single->id . '/edit')}}';"><i class="fa fa-edit"></i> {{ trans('admin.edit') }}</button>
                                <button data-id="{{ $single->id }}" class="btn btn-sm btn-danger" data-action="news-remove"><i class="fa fa-trash-alt"></i> {{ trans('admin.remove') }}</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            {!! $news->render() !!}
            @else
            <div class="alert alert-warning"><i class="far fa-comment-alt"></i> {{ trans('news::admin.news_index_empty') }}</div>
            @endif
        </section>
    </div>
    
</div>
@endsection

@section('scripts')
    <script>
        var MenusTranslations = {'js_remove': '{{ __('news::admin.js_remove') }}'};
    </script>
@endsection