<div class="form-group filled">
    {!! Form::label('news', 'Select News', ['class' => 'control-label']) !!}
    {!! Form::select('news', $news, old('news'), ['class' => 'form-control']) !!}
</div>
