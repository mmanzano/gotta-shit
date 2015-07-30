<nav>
    <ul>
        @if(Auth::check())
            <li><a href="{{ route('create_place') }}">{{ ucfirst(Lang::get('gottatoshit.nav.add_place')) }}</a></li>
            <li><a href="{{ route('logout') }}">{{ ucfirst(Lang::get('gottatoshit.nav.logout')) }}</a></li>
        @else
            <li><a href="{{ route('login') }}">{{ ucfirst(Lang::get('gottatoshit.nav.login')) }}</a></li>
            <li><a href="{{ route('register') }}">{{ ucfirst(Lang::get('gottatoshit.nav.register')) }}</a></li>
        @endif
    </ul>
</nav>
