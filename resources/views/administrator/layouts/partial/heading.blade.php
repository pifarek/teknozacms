<nav class="navbar sticky-top navbar-light bg-light">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('administrator') }}">Dashboard</a></li>
        @if(isset($items) && $items->count())
        @foreach($items as $item)
        @if(!$loop->last)
        <li class="breadcrumb-item"><a href="{{ $item['url'] }}">{{ $item['title'] }}</a></li>
        @else
        <li class="breadcrumb-item active">{{ $item['title'] }}</li>
        @endif
        @endforeach
        @endif

    </ol>
    <div>
        @if(isset($buttons) && $buttons->count())
        <div class="navbar-buttons">
            @foreach($buttons as $button)
            <a href="{{ isset($button['url']) ? $button['url'] : '#' }}" class="btn btn-primary"{!! isset($button['modal']) ? ' data-toggle="modal" data-target="#' . $button['modal'] . '"' : '' !!}>
                @if(isset($button['icon']))
                <i class="fa fa-{{ $button['icon'] }}"></i>
                @endif
                {{ $button['title'] }}
            </a>
            @endforeach
        </div>
        @endif
        <div class="user-avatar">
            <img src="{{ Auth::user()->avatar? url('upload/users/' . Auth::user()->avatar) : url('assets/administrator/images/user_default.jpg') }}" alt="{{ Auth::user()->name }}">
            <span>{{ Auth::user()->name }}</span>
        </div>
    </div>
</nav>