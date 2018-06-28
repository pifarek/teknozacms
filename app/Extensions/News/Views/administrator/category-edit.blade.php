@extends('administrator.layouts.default')

@section('content')

<div class="main-container" id="page-news-category-edit">
    @include('administrator.layouts.partial.heading',
    [
        'items' => collect([['url' => url('administrator/news'), 'title' => trans('news::admin.news_index_page_title')], ['url' => url('administrator/news/categories'), 'title' => trans('news::admin.news_category_categories')], ['url' => '', 'title' => trans('news::admin.news_category_edit_page_title')]]),
        'buttons' => collect()
    ])

    <div class="main-content">
        <section>
            <div class="page-header">
                <h1>{{ trans('news::admin.news_category_edit_page_title') }}</h1>
                <p class="lead"> {{ trans('news::admin.news_category_edit_page_description') }}</p>
            </div>
            
            @if($errors->count())
            <div class="alert alert-warning">{{ $errors->first() }}</div>
            @endif
            
            <div class="well">

                {!! Form::open(['class' => 'form-floating', 'url' => url('administrator/news/categories/' . $category->id)]) !!}
                {{ method_field('PUT') }}
                    <ul class="nav nav-tabs" role="tablist">
                        @foreach($locales as $locale)
                        <li role="presentation"><a href="#variable-{{ $locale->language }}" aria-controls="variable-{{ $locale->language }}" role="tab" data-toggle="tab">{{ $locale->name }} <i class="flag flag-{{ $locale->language }}"></i></a></li>
                        @endforeach
                    </ul>

                    <div class="tab-content">
                        @foreach($locales as $locale)
                        <div role="tabpanel" class="tab-pane" id="variable-{{ $locale->language }}">
                            <div class="form-group{!! $errors->has('name-' . $locale->language)? ' has-error' : '' !!}">
                                {!! Form::label('name-' . $locale->language, trans('news::admin.news_category_edit_name'), ['class' => 'control-label']) !!}
                                {!! Form::text('name-' . $locale->language, Input::old('name-' . $locale->language, $category->translate($locale->language)->name), ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit">{{ trans('news::admin.news_category_edit_submit') }}</button>
                        <button class="btn btn-default" type="button" onclick="location.href='{{ url('administrator/news/categories') }}'">{{ trans('admin.cancel') }}</button>
                    </div>
                {!! Form::close() !!}
            </div>
            
        </section>
    </div>
</div>
@endsection