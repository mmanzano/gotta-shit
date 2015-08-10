<nav>
    <ul class="navigation">

        <li><a href="{{ route('all_places') }}">{{ ucfirst(trans('gottashit.nav.all')) }}</a></li>
        <li><a href="/place/40.5/-3.7/1000" id="nearest-place">{{ ucfirst(trans('gottashit.nav.nearest')) }}</a></li>

        @if(Auth::check())

            <li><a href="{{ route('user_places') }}">{{ ucfirst(trans('gottashit.nav.user_places')) }}</a></li>
            <li><a href="{{ route('create_place') }}">{{ ucfirst(trans('gottashit.nav.add_place')) }}</a></li>
            <li><a href="{{ route('logout') }}">{{ ucfirst(trans('gottashit.nav.logout')) }}</a></li>
            <li><a href="{{ route('profile', ['user' => \Auth::User()->id]) }}">{{ ucfirst(trans('gottashit.nav.profile')) }}</a></li>

        @else

            <li><a href="{{ route('login') }}">{{ ucfirst(trans('gottashit.nav.login')) }}</a></li>
            <li><a href="{{ route('register') }}">{{ ucfirst(trans('gottashit.nav.register')) }}</a></li>

        @endif

    </ul>
</nav>
