@extends('administrator.layouts.default')

@section('content')

<div class="main-container" id="page-settings-global">

    @include('administrator.layouts.partial.heading',
    [
        'items' => collect([['url' => '', 'title' => __('admin.settings_global_page_title')]]),
        'buttons' => collect()
    ])

    <div class="main-content">
        <section>
            <div class="page-header">
                <h1>{{ trans('admin.settings_global_page_title') }}</h1>
                <p class="lead"> {{ trans('admin.settings_global_page_description') }}</p>
            </div>
            
            @if($errors->count())
            <div class="alert alert-warning">{{ $errors->first() }}</div>
            @endif
            
            @if(Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif
            
            <div class="well">
                {!! Form::open(['class' => 'form-floating']) !!}
                @if(is_array($settings))
                @foreach($settings as $setting)

                {{-- for multilanguage elements --}}
                @if($setting['multilanguage'])

                <ul class="nav nav-tabs" role="tablist">
                    @foreach($locales as $locale)
                    <li role="presentation"><a href="#ftab-{{ $locale->language }}-{{ $setting['name'] }}" aria-controls="ftab-{{ $locale->language }}-{{ $setting['name'] }}" role="tab" data-toggle="tab">{{ $locale->name }} <i class="flag flag-{{ $locale->language }}"></i></a></li>
                    @endforeach
                </ul>

                <div class="tab-content">
                    @foreach($locales as $locale)
                    <div role="tabpanel" class="tab-pane" id="ftab-{{ $locale->language }}-{{ $setting['name'] }}">
                        <div class="form-group{!! $errors->has('setting-' . $setting['name'] . '-' . $locale->language)? ' has-error' : '' !!}">

                            @if($setting['type'] === 'text')

                            {!! Form::label('setting-' . $setting['name'] . '-' . $locale->language, $setting['label'], ['class' => 'control-label']) !!}
                            {!! Form::text('setting-' . $setting['name'] . '-' . $locale->language, old('setting-' . $setting['name'] . '-' . $locale->language, Settings::get($setting['name'], $locale->id)), ['class' => 'form-control']) !!}

                            @elseif($field->type === 'textarea')



                            @elseif($field->type === 'select')

                            @elseif($field->type === 'switch')

                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="form-group">

                    @if($setting['type'] === 'text')
                    {!! Form::label('setting-' . $setting['name'], $setting['label'], ['class' => 'control-label']) !!}
                    {!! Form::text('setting-' . $setting['name'], old($setting['name'], Settings::get($setting['name'])), ['class' => 'form-control']) !!}
                    @elseif($setting['type'] === 'password')
                    {!! Form::label('setting-' . $setting['name'], $setting['label'], ['class' => 'control-label']) !!}
                    {!! Form::password('setting-' . $setting['name'], ['class' => 'form-control']) !!}
                    @elseif($setting['type'] === 'switch')
                    {!! Form::label('setting-' . $setting['name'], $setting['label'], ['class' => 'control-label normal']) !!}
                    <div class="switch">
                        <label class="filled">
                            Off
                            <input type="checkbox"{{ Settings::get($setting['name']) == 1? ' checked="checked"' : '' }} name="{{ 'setting-' . $setting['name'] }}" value="1">
                            <span class="lever"></span>
                            On
                        </label>
                    </div>
                    @elseif($setting['type'] === 'datetime')
                    {!! Form::label('setting-' . $setting['name'], $setting['label'], ['class' => 'control-label']) !!}
                    {!! Form::text('setting-' . $setting['name'], old($setting['name'], Settings::get($setting['name'])), ['class' => 'form-control datetimepicker']) !!}
                    @elseif($setting['type'] === 'select')
                    {!! Form::label('setting-' . $setting['name'], $setting['label'], ['class' => 'control-label']) !!}
                    {!! Form::select('setting-' . $setting['name'], $setting['options'], old($setting['name'], Settings::get($setting['name'])), ['class' => 'form-control selectpicker']) !!}
                    @endif
                </div>
                @endif
                @endforeach

                @endif
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">{{ trans('admin.settings_global_submit') }}</button>                            
                </div>
                {!! Form::close() !!}

            </div>
        </section>
    </div>
</div>
@endsection
