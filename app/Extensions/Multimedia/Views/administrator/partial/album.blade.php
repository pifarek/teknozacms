    <div class="col-md-3 col-sm-4 col-xs-6 album" data-id="{{ $album->id }}">
    <div class="card">
        <div class="card-image imagefill">

            @if($album->thumbnail())
            <a href="{{ url('administrator/multimedia/' . $album->id) }}" style="background-image: url('{{ url('upload/multimedia/' . $album->thumbnail()) }}');">
            @else
            <a href="{{ url('administrator/multimedia/' . $album->id) }}" style="background-image: url('{{ url('assets/administrator/images/default_multimedia.png') }}');">
            @endif
            </a>
        </div>
        <div class="card-content">
            <p>{{$album->name}}</p>
        </div>
        <div class="card-action clearfix">
            <div class="float-right">
                <a class="btn btn-link" href="{{ url('administrator/multimedia/' . $album->id) }}"><i class="fa fa-folder"></i> {{ trans('admin.view') }}</a>
                <a class="btn btn-link" data-action="album-edit" data-id="{{ $album->id }}"><i class="fa fa-pencil-alt"></i> {{ trans('admin.edit') }}</a>
                <a class="btn btn-link" data-action="album-remove" data-id="{{ $album->id }}"><i class="fa fa-trash-alt"></i> {{ trans('admin.remove') }}</a>
            </div>
        </div>
    </div>
</div>