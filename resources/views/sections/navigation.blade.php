<nav>
    <ul>
        <li><a href="/place/40.5/-3.7/1000" id="nearest-place">{{ ucfirst(Lang::get('gottashit.nav.nearest')) }}</a></li>
        @if(Auth::check())
            <li><a href="{{ route('user_places') }}">{{ ucfirst(Lang::get('gottashit.nav.user_places')) }}</a></li>
            <li><a href="{{ route('create_place') }}">{{ ucfirst(Lang::get('gottashit.nav.add_place')) }}</a></li>
            <li><a href="{{ route('logout') }}">{{ ucfirst(Lang::get('gottashit.nav.logout')) }}</a></li>
        @else
            <li><a href="{{ route('login') }}">{{ ucfirst(Lang::get('gottashit.nav.login')) }}</a></li>
            <li><a href="{{ route('register') }}">{{ ucfirst(Lang::get('gottashit.nav.register')) }}</a></li>
        @endif
    </ul>
</nav>
