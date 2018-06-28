<div>
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#aa" aria-controls="aa" role="tab" data-toggle="tab">Table Editor</a></li>
        <!--<li role="presentation"><a href="#bb" aria-controls="bb" role="tab" data-toggle="tab">File Editor</a></li> -->
    </ul>

    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="aa">
            
            @if(is_array($array))
            <table class="table table-striped table-full table-full-small">
                <thead>
                    <tr>
                        <th>Shortcut</th>
                        <th>Translation</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($array as $key => $value)
                <tr>
                    <td style="min-width: 15%">
                        {{ $key }}
                    </td>
                    <td>
                        @if(is_string($value))
                        {!! Form::text('value[' . $key . ']', $value, ['class' => 'form-control translation-value', 'data-key' => $key]) !!}
                        @endif
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            @endif
        </div>
        <div role="tabpanel" class="tab-pane" id="bb">
            <div class="form-group">
                {!! Form::textarea('content', $content, ['class' => 'form-control file-editor', 'id' => 'translate-file']) !!}
            </div>
        </div>
    </div>
</div>

