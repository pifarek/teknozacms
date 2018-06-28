<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>{{ trans('admin.template_title') }}</title>
        <link rel="shortcut icon" href="{{ url('assets/administrator/images/favicon.png') }}">
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
        <link href="{{ url('assets/administrator/css/build.css') }}" rel="stylesheet">
        @yield('styles')
    </head>
    <body{!! Cookie::get('fullscreen')? ' class="fullscreen"' : '' !!}>
        <main>
            <aside class="sidebar">
                <div class="sidebar-container">
                    <div class="brand-logo">
                        <a title="{{ trans('admin.title') }}" href="{{ url('administrator') }}"><img src="{{ url('assets/administrator/images/logo_sidebar.png') }}" alt="{{ trans('admin.title') }}"></a>
                    </div>

                    @if(sizeof($nav_menu))
                    <?php $count = 0; ?>
                    <nav class="sidebar-navigation">
                        <ul>
                            @foreach($nav_menu as $item)

                                @if(sizeof($item['items']))
                                <li class="parent{{ $item['active']? ' active' : '' }}">
                                    <a data-toggle="collapse" href="#menu-{{$count}}"><i class="fa fa-{{ $item['icon'] }}"></i>&nbsp;<span>{{ $item['title'] }}</span></a>
                                    <ul id="menu-{{$count}}" class="collapse{{ $item['active']? ' show' : '' }}">
                                        @foreach($item['items'] as $subitem)
                                        <li{!! $subitem['active']? ' class="active"' : '' !!}>
                                            <a href="{{url($subitem['url'])}}"><span>{{$subitem['title']}}</span>
                                                @if(isset($subitem['badge']))
                                                <span class="pull-right badge">{{ $subitem['badge'] }}</span>
                                                @endif
                                            </a>
                                        </li>
                                        @endforeach
                                    </ul>
                                </li>
                                @else
                                    <li class="{{ $item['active']? ' active' : '' }}">
                                        <a href="{{ url($item['url']) }}" {!! $item['active']? ' class="active"' : '' !!}><i class="fa fa-{{ $item['icon'] }}"></i>&nbsp;<span>{{ $item['title'] }}</span></a>
                                    </li>
                                @endif
                            <?php $count++;?>
                            @endforeach
                        </ul>
                    </nav>
                    @endif

                    <ul class="control-buttons">
                        <li><a href="#" data-fullscreen data-toggle="tooltip" data-placement="top" title="Toggle Fullscreen"><i class="fa fa-expand-arrows-alt"></i></a></li>
                        <li><a href="{{ url('administrator/profile') }}" data-toggle="tooltip" data-placement="top" title="Your Profile"><i class="fa fa-user"></i></a></li>
                        <li><a href="{{ url('administrator/settings/global') }}" data-toggle="tooltip" data-placement="top" title="Settings"><i class="fa fa-cog"></i></a></li>
                        <li><a href="{{ url('logout') }}" data-toggle="tooltip" data-placement="top" title="Logout"><i class="fa fa-sign-out-alt"></i></a></li>
                    </ul>
                </div>
            </aside>
            <div class="container-fluid" id="content">
                @yield('content')
            </div>
        </main>

        <script>var settings = {'base_url' : '{{ url('/') }}', 'language' : '{{ $tpl_locale }}'};</script>
        <script charset="utf-8" src="{{ url('assets/administrator/js/build.js') }}"></script>
        @yield('scripts')
    </body>
</html>