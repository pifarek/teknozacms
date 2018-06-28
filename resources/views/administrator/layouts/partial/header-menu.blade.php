<li class="dropdown pull-right">
    <button class="dropdown-toggle pointer btn btn-round-sm btn-link withoutripple" data-toggle="dropdown">
        <i class="md md-settings f20"></i>
    </button>                    
    <ul class="dropdown-menu">
        <li>
            <a href="{{ url('administrator/profile') }}">Profile</a>
            <a href="{{ url('administrator/auth/logout') }}">Logout</a>
        </li>
    </ul>
</li>

<li class="dropdown dropdown-language pull-right">
    <button class="dropdown-toggle pointer btn btn-round-sm btn-link withoutripple" data-toggle="dropdown">
        <i class="md md-language f20"></i>
    </button>                    
    <ul class="dropdown-menu">
        @foreach($admin_locales as $locale)
        <li>
            <a href="{{ url('administrator/locale/' . $locale) }}"><img src="{{ url('assets/administrator/images/flags/' . $locale . '.png') }}" alt=""></a>
        </li>
        @endforeach
    </ul>
</li>