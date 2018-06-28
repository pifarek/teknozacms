@if($slides)

    <div class="slider">
@foreach($slides as $slide)
    <div>
        <a data-fancybox="gallery" href="{{ url('upload/slides/' . $slide->filename) }}"><img src="{{ url('upload/slides/' . $slide->filename) }}" title="{{ $slide->description }}"></a>
    </div>
@endforeach
    </div>

@endif