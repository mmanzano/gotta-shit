<nav>
    <ul>
        @if(Auth::check())
            <li><a href="{{ route('logout') }}">{{ ucfirst(Lang::get('shitguide.login.logout')) }}</a></li>
        @else
            <li><a href="{{ route('login') }}">{{ ucfirst(Lang::get('shitguide.login.login')) }}</a></li>
            <li><a href="{{ route('register') }}">{{ ucfirst(Lang::get('shitguide.login.register')) }}</a></li>
        @endif
    </ul>
</nav>
