@extends('administrator.layouts.default')

@section('content')

<div class="main-container" id="page-settings-translations">

    @include('administrator.layouts.partial.heading',
    [
        'items' => collect([['url' => '', 'title' => __('admin.settings_translations_page_title')]]),
        'buttons' => collect()
    ])

    <div class="main-content">
        <section>
            <div class="page-header">
                <h1>@lang('admin.settings_translations_page_title')</h1>
                <p class="lead"> @lang('admin.settings_translations_page_description')</p>
            </div>
            
            @if($errors->count())
            <div class="alert alert-warning">{{ $errors->first() }}</div>
            @endif
            
            @if(Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif
            
            <div class="well">

                {!! Form::open(['class' => 'form-floating']) !!}

                <div class="form-group">
                    {!! Form::label('file', 'Select file', ['class' => 'label-control']) !!}
                    {!! Form::select('file', $files, '', ['class' => 'form-control select-file selectpicker']) !!}
                </div>

                <div id="translation-editor">

                </div>

                <div class="form-group">
                    <button class="btn btn-primary" type="submit">Save File</button>                            
                </div>
                {!! Form::close() !!}

            </div>

        </section>
    </div>
</div>
@endsection