@if($images->count())
@foreach($images as $image)
<div class="col-md-3 image">
    <a href="#" class="tinymce-add-image" data-id="{{ $image->id }}" data-image="{{ url('upload/multimedia/' . $image->image->filename) }}" style="background-image: url('{{ url('upload/multimedia/' . $image->image->filename) }}');"></a>
</div>
@endforeach
@else
<div class="alert alert-info">This album doesn't have any images.</div>
@endif