@extends('administrator.layouts.default')

@section('content')

<div class="main-container" id="page-multimedia">


    <?php
        $navItems = collect([['url' => url('administrator/multimedia'), 'title' => trans('multimedia::admin.manage_page_title')]]);
        if(sizeof($breadcrumbs)) {
            foreach($breadcrumbs as $breadcrumb) {
                $navItems->push($breadcrumb);
            }
        }
    ?>

    @include('administrator.layouts.partial.heading',
    [
        'items' => $navItems,
        'buttons' => collect([['modal' => 'multimedia-add-modal', 'title' => trans('multimedia::admin.manage_add'), 'icon' => 'plus'], ['modal' => 'multimedia-album-add-modal', 'title' => 'Add Album', 'icon' => 'plus']])
    ])

    <div class="main-content">
        <section>
            <div class="page-header">
                <h1>{{ trans('multimedia::admin.manage_page_title') }}</h1>
                <p class="lead"> {{ trans('multimedia::admin.manage_page_description') }}</p>
            </div>

            <div class="alert alert-warning multimedia-empty{{ (!$oneLevelAlbums->count() && !$items->count())? '' : ' d-none' }}">@lang('multimedia::admin.manage_form_empty')</div>

            <div class="row albums-list">
            @if($oneLevelAlbums->count())
                @foreach($oneLevelAlbums as $album)
                @include('multimedia.views.administrator.partial.album')
                @endforeach
            @endif
            </div>            
            
            <div class="row items-list">
                @if($items->count())
                <?php
                $count = 0;
                foreach($items as $item):
                ?>
                @include('multimedia.views.administrator.partial.item')
                <?php endforeach;?>
                @endif
            </div>           

        </section>
    </div>
    
    <div class="modal fade" tabindex="-1" role="dialog" id="multimedia-album-add-modal" data-album="{{ $album_id }}">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa fa-circle-o-notch fa-spin work-indicator d-none"></i> {{ trans('multimedia::admin.manage_album_add_submit') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {!! Form::open(['class' => 'form-floating', 'files' => true]) !!}
                    <div class="modal-body">
                        <div class="alert alert-warning d-none">
                            @lang('multimedia::admin.manage_form_error')

                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <input type="hidden" name="type" value="image">
                        <ul class="nav nav-tabs" role="tablist">
                            @foreach($locales as $locale)
                            <li role="presentation"><a href="#album-add-{{ $locale->language }}" aria-controls="album-add-{{ $locale->language }}" role="tab" data-toggle="tab">{{ $locale->name }} <i class="flag flag-{{ $locale->language }}"></i></a></li>
                            @endforeach
                        </ul>

                        <div class="tab-content">
                            @foreach($locales as $locale)
                            <div role="tabpanel" class="tab-pane" id="album-add-{{ $locale->language }}">
                                <div class="form-group">
                                    {!! Form::label('name-' . $locale->language, trans('multimedia::admin.manage_name'), ['class' => 'control-label']) !!}
                                    {!! Form::text('name-' . $locale->language, old('name-' . $locale->language), ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="form-group">
                            {!! Form::label('parent', trans('multimedia::admin.manage_parent'), ['class' => 'control-label']) !!}
                            {!! Form::select('parent', [0 => 'Parent'] + $albums, old('parent'), ['class' => 'form-control selectpicker']) !!}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('admin.cancel') }}</button>
                        <button type="submit" class="btn btn-primary" data-action="multimedia-album-add">{{ trans('multimedia::admin.manage_album_add_submit') }}</button>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="multimedia-album-edit-modal" data-album="{{ $album_id }}">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa fa-circle-o-notch fa-spin work-indicator d-none"></i> {{ trans('multimedia::admin.manage_album_edit_submit') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {!! Form::open(['class' => 'form-floating', 'files' => true]) !!}
                    <div class="modal-body">
                        <div class="alert alert-warning d-none">
                            @lang('multimedia::admin.manage_form_error')

                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <input type="hidden" name="album_id" value="">
                        <ul class="nav nav-tabs" role="tablist">
                            @foreach($locales as $locale)
                            <li role="presentation"><a href="#album-edit-{{ $locale->language }}" aria-controls="album-edit-{{ $locale->language }}" role="tab" data-toggle="tab">{{ $locale->name }} <i class="flag flag-{{ $locale->language }}"></i></a></li>
                            @endforeach
                        </ul>

                        <div class="tab-content">
                            @foreach($locales as $locale)
                            <div role="tabpanel" class="tab-pane" id="album-edit-{{ $locale->language }}">
                                <div class="form-group">
                                    {!! Form::label('name-' . $locale->language, trans('multimedia::admin.manage_name'), ['class' => 'control-label']) !!}
                                    {!! Form::text('name-' . $locale->language, old('name-' . $locale->language), ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="form-group">
                            {!! Form::label('parent', trans('multimedia::admin.manage_parent'), ['class' => 'control-label']) !!}
                            {!! Form::select('parent', [0 => 'Parent'] + $albums, old('parent'), ['class' => 'form-control selectpicker']) !!}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('admin.cancel') }}</button>
                        <button type="submit" class="btn btn-primary" data-action="multimedia-album-edit">{{ trans('multimedia::admin.manage_album_edit_submit') }}</button>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    
    <div class="modal fade" tabindex="-1" role="dialog" id="multimedia-add-modal" data-album="{{ $album_id }}">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa fa-circle-o-notch fa-spin work-indicator d-none"></i> {{ trans('multimedia::admin.manage_add_submit') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {!! Form::open(['class' => 'form-floating', 'files' => true]) !!}
                <div class="modal-body">
                    <div class="alert alert-warning d-none">
                        @lang('multimedia::admin.manage_form_error')

                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                    <input type="hidden" name="type" value="image">
                    <ul class="nav nav-tabs" role="tablist">
                        @foreach($locales as $locale)
                        <li role="presentation"><a href="#variable-{{ $locale->language }}" aria-controls="variable-{{ $locale->language }}" role="tab" data-toggle="tab">{{ $locale->name }} <i class="flag flag-{{ $locale->language }}"></i></a></li>
                        @endforeach
                    </ul>

                    <div class="tab-content">
                        @foreach($locales as $locale)
                        <div role="tabpanel" class="tab-pane" id="variable-{{ $locale->language }}">
                            <div class="form-group{!! $errors->has('name-' . $locale->language)? ' has-error' : '' !!}">
                                {!! Form::label('name-' . $locale->language, trans('multimedia::admin.manage_name'), ['class' => 'control-label']) !!}
                                {!! Form::text('name-' . $locale->language, old('name-' . $locale->language), ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group{!! $errors->has('description-' . $locale->language)? ' has-error' : '' !!}">
                                {!! Form::label('description-' . $locale->language, trans('multimedia::admin.manage_description'), ['class' => 'control-label']) !!}
                                {!! Form::textarea('description-' . $locale->language, old('description-' . $locale->language), ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="form-group">
                        {!! Form::label('album', trans('multimedia::admin.manage_album'), ['class' => 'control-label']) !!}
                        {!! Form::select('album', [0 => 'Parent'] + $albums, old('album'), ['class' => 'form-control selectpicker']) !!}
                    </div>
                    <ul class="nav nav-tabs nav-tabs-types" role="tablist">
                        <li role="presentation"><a href="#type-image" aria-controls="type-image" role="tab" data-toggle="tab"><i class="fa fa-image"></i> {{ trans('multimedia::admin.manage_image') }}</a></li>
                        <li role="presentation"><a href="#type-video" aria-controls="type-video" role="tab" data-toggle="tab"><i class="fa fa-video"></i> {{ trans('multimedia::admin.manage_video') }}</a></li>
                    </ul>

                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane tab-pane-type" id="type-image">

                            <div class="image-preview d-none"></div>

                            <div class="form-group image-upload{!! $errors->has('file')? ' has-error' : '' !!}">
                                <span class="btn btn-success fileinput-button">
                                    <i class="fa fa-plus"></i> <span>{{ trans('multimedia::admin.manage_select_image') }}</span>
                                    <input class="fileupload" type="file" name="image" data-url="{{ url('administrator/multimedia/json/image-upload') }}">
                                    <input type="hidden" name="image-filename" value="{{ old('image-filename') }}">
                                </span>
                                <span class="help-block">{{ trans('multimedia::admin.manage_image_help') }}</span>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane tab-pane-type" id="type-video">
                            <div class="form-group{!! $errors->has('url')? ' has-error' : '' !!}">
                                {!! Form::label('url', trans('multimedia::admin.manage_video_url'), ['class' => 'label-control']) !!}
                                {!! Form::text('url', old('url'), ['class' => 'form-control']) !!}
                                <span class="help-block">{{ trans('multimedia::admin.manage_video_help') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('admin.cancel') }}</button>
                    <button type="submit" class="btn btn-primary" data-action="multimedia-add">{{ trans('multimedia::admin.manage_add_submit') }}</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
                
                
    <div class="modal fade" tabindex="-1" role="dialog" id="multimedia-edit-modal" data-album="{{ $album_id }}">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa fa-circle-o-notch fa-spin work-indicator d-none"></i> {{ trans('multimedia::admin.manage_edit_submit') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {!! Form::open(['class' => 'form-floating', 'files' => true]) !!}
                <div class="modal-body">
                    <div class="alert alert-warning d-none">
                        @lang('multimedia::admin.manage_form_error')

                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                    <input type="hidden" name="multimedia_id" value="">
                    <ul class="nav nav-tabs" role="tablist">
                        @foreach($locales as $locale)
                        <li role="presentation"><a href="#edit-{{ $locale->language }}" aria-controls="edit-{{ $locale->language }}" role="tab" data-toggle="tab">{{ $locale->name }} <i class="flag flag-{{ $locale->language }}"></i></a></li>
                        @endforeach
                    </ul>

                    <div class="tab-content">
                        @foreach($locales as $locale)
                        <div role="tabpanel" class="tab-pane" id="edit-{{ $locale->language }}">
                            <div class="form-group{!! $errors->has('name-' . $locale->language)? ' has-error' : '' !!}">
                                {!! Form::label('name-' . $locale->language, trans('multimedia::admin.manage_name'), ['class' => 'control-label']) !!}
                                {!! Form::text('name-' . $locale->language, old('name-' . $locale->language), ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group{!! $errors->has('description-' . $locale->language)? ' has-error' : '' !!}">
                                {!! Form::label('description-' . $locale->language, trans('multimedia::admin.manage_description'), ['class' => 'control-label']) !!}
                                {!! Form::textarea('description-' . $locale->language, old('description-' . $locale->language), ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="form-group">
                        {!! Form::label('album', trans('multimedia::admin.manage_album'), ['class' => 'control-label']) !!}
                        {!! Form::select('album', [0 => 'Parent'] + $albums, old('album'), ['class' => 'form-control selectpicker']) !!}
                    </div>                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('admin.cancel') }}</button>
                    <button type="submit" class="btn btn-primary" data-action="multimedia-edit">{{ trans('multimedia::admin.manage_edit_submit') }}</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        var MultimediaTranslations = {
            'js_added': '{{ __('multimedia::admin.js_added') }}',
            'js_album_added': '{{ __('multimedia::admin.js_album_added') }}',
            'js_remove': '{{ __('multimedia::admin.js_remove') }}',
            'js_album_remove': '{{ __('multimedia::admin.js_album_remove') }}',
        };
    </script>
@endsection
