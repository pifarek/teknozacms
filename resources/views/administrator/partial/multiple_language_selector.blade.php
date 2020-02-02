<?php
    $default = [];
    if(isset($selected) && is_array($selected)) {
        foreach($selected as $locale) {
            $default[] = $locale->id;
        }
    }
?>

<div class="form-group">
    {!! Form::label('languages', $title, ['class' => 'control-label']) !!}
    <div class="languages-available">
        @foreach($locales as $locale)
            <div><label><input type="checkbox" name="locales[]" value="{{ $locale->id }}"{!! false !== array_search($locale->id, old('localesSeeder', $default))? ' checked="checked"' : '' !!}> <img src="{{ url('assets/administrator/images/flags/' . $locale->language . '.png') }}" alt=""> {{ $locale->name }}</label></div>
        @endforeach
    </div>
</div>
