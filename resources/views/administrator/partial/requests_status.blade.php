<table class="table table-bordered table-hover table-striped table-condensed">
    <thead>
        <tr class="heading">
            <th><strong>Name</strong></th>
            <th><strong>Status</strong></th>
            <th><strong>Category</strong></th>
            <th><strong>End date</strong></th>
        </tr>
    </thead>
    @if($users)
    <tbody>
    @foreach($users as $user)
    <tr>
        <td>
            @if($user->avatar)
            <img style="height: 30px;" src="{{ url('upload/users/' . $user->avatar) }}" alt=""> {{ $user->name() }}
            @else
            <img style="height: 30px;" src="{{ url('assets/administrator/images/user_default.jpg') }}" alt=""> {{ $user->name() }}
            @endif
        </td>
        <td>
            {!! Form::select('status', ['pending', 'accepted'], null, ['class' => 'form-control']) !!}
        </td>
        <td>
            {!! Form::select('category', [0 => 'Select'] + $categories, null, ['class' => 'form-control hidden']) !!}
        </td>
        <td>
            {!! Form::text('date', date('d-m-Y H:i'), ['class' => 'form-control datetimepicker hidden']) !!}
        </td>
    </tr>
    @endforeach
    </tbody>
    @endif
</table>