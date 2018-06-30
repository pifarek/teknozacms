@extends('administrator.layouts.default')

@section('content')

<div class="main-container" id="page-sliders">

    @include('administrator.layouts.partial.heading',
        [
            'items' => collect([['url' => '', 'title' => trans('sliders::admin.index_page_title')]]),
            'buttons' => collect([['url' => url('administrator/sliders/create'), 'title' => trans('sliders::admin.index_add_slider'), 'icon' => 'plus'], ['url' => url('administrator/sliders/slides/create'), 'title' => trans('sliders::admin.index_add_slide'), 'icon' => 'plus']])
        ])

    <div class="main-content">
        <section>
            <div class="page-header">
                <h1>{{ trans('sliders::admin.index_page_title') }}</h1>
                <p class="lead"> {{ trans('sliders::admin.index_page_description') }}</p>
            </div>

            @if(Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif

            <div class="card">
                <div class="card-body">
                    @if($sliders->count())
                    @foreach($sliders as $slider)
                    <h3 class="card-title clearfix">
                        <div class="float-left">
                            Slider: {{ $slider->shortcode }}
                            <button data-id="{{ $slider->id }}" data-action="slider-remove" class="btn btn-xs btn-danger"><i class="fa fa-trash-alt"></i></button>
                        </div>
                        <div class="float-right">
                            <button class="btn btn-success" onclick="location.href='{{ url('administrator/sliders/slides/create?slider_id=' . $slider->id) }}'"><i class="fa fa-plus"></i> Add to {{ $slider->shortcode }}</button>
                        </div>
                    </h3>
                    @if($slider->slides->count())
                    <table class="table table-bordered table-full table-full-small">
                        <thead>
                            <th style="width: 150px;"><strong>{{ trans('sliders::admin.slide_index_preview') }}</strong></th>
                            <th><strong>{{ trans('sliders::admin.slide_index_name') }}</strong></th>
                            <th><strong>{{ trans('sliders::admin.slide_index_order') }}</strong></th>
                            <th><strong>{{ trans('admin.actions') }}</strong></th>
                        </thead>
                        <tbody>
                            @foreach($slider->slides()->orderBy('order')->get() as $slide)
                            <tr>
                                <td>
                                    <a href="{{ url('upload/slides/' . $slide->filename) }}" target="_blank" data-fancybox="preview"><img style="width: 100%;" src="{{ url('upload/slides/' . $slide->filename) }}" alt=""></a>
                                </td>
                                <td>
                                    @foreach($slide->translations as $translation)
                                    <div><img src="{{ url('assets/administrator/images/flags/' . $translation->locale . '.png') }}" alt=""> {{ $translation->name }}</div>
                                    @endforeach
                                </td>
                                <td>
                                    <button data-id="{{ $slide->id }}" data-action="move-up" class="btn btn-sm btn-danger"><i class="fa fa-arrow-up"></i></button>
                                    <button data-id="{{ $slide->id }}" data-action="move-down" class="btn btn-sm btn-info"><i class="fa fa-arrow-down"></i></button>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-default" onclick="window.location.href='{{ url('administrator/sliders/slides/' . $slide->id . '/edit') }}';"><i class="fa fa-edit"></i> {{ trans('admin.edit') }}</button>
                                    <button data-id="{{ $slide->id }}" data-action="slide-remove" class="btn btn-sm btn-danger"><i class="fa fa-trash-alt"></i> {{ trans('admin.remove') }}</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <div class="alert alert-info">{{ trans('sliders::admin.slide_no_found') }}</div>
                    @endif
                    @endforeach
                    @else
                    <div class="alert alert-info">{{ trans('sliders::admin.index_define_first') }}</div>
                    @endif
                </div>
            </div>

        </section>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        var SlidersTranslations = {
            'js_slider_remove': '{{ __('sliders::admin.js_slider_remove') }}',
            'js_slide_remove': '{{ __('sliders::admin.js_slide_remove') }}',
        };
    </script>
@endsection