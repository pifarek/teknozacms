<div id="item-{{ $item->id }}" class="multimedia-item col-md-3 col-sm-4 col-xs-6" data-id="{{ $item->id }}">
    <div class="card">
        <div class="card-image">
            @if($item->isImage())
            <div class="type-icon"><i class="fa fa-image"></i></div>
            <a href="{{url('upload/multimedia/' . $item->image->filename)}}" data-fancybox="preview" style="background-image: url('{{ url('upload/multimedia/' . $item->image->filename) }}');"></a>
            @elseif($item->isVideo())
            <div class="type-icon"><i class="fa fa-film"></i></div>
            <a data-fancybox="preview" href="{{ $item->video->url }}"><img src="{{url('upload/multimedia/' . $item->video->filename)}}"></a>
            @endif                        
            <span class="card-title">{{$item->name}}</span>
        </div>
        <div class="card-content">
            <p>{{$item->description}}</p>
        </div>
        <div class="card-action clearfix">
            <div class="float-right">
                <a class="btn btn-link" data-action="item-edit" data-id="{{ $item->id }}"><i class="fa fa fa-pencil-alt"></i> {{ trans('admin.edit') }}</a>
                <a data-id="{{ $item->id}}" data-action="multimedia-remove" class="btn btn-link" href="#"><i class="fa fa-trash-alt"></i> {{ trans('admin.remove') }}</a>
            </div>
        </div>
    </div>
</div>