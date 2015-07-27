<nav>
    <ul>
        @if(Auth::check())
            <li><a href="{{ route('logout') }}">{{ ucfirst(Lang::get('shitguide.logout')) }}</a></li>
        @else
            <li><a href="{{ route('login') }}">{{ ucfirst(Lang::get('shitguide.login')) }}</a></li>
            <li><a href="{{ route('register') }}">{{ ucfirst(Lang::get('shitguide.register')) }}</a></li>
        @endif
    </ul>
</nav>
