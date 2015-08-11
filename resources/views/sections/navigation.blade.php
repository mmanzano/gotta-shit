<nav>

    <ul class="navigation">

        <li><a href="/place/40.5/-3.7/1000" id="nearest-place" style="display:none">{{ trans('gottashit.nav.nearest') }}</a></li>
        <li><a href="{{ route('all_places') }}">{{ trans('gottashit.nav.all') }}</a></li>
        <li><a href="{{ route('best_places') }}">{{ trans('gottashit.nav.best_places') }}</a></li>


        @if(Auth::check())

            <li><a href="{{ route('user_places') }}">{{ trans('gottashit.nav.user_places') }}</a></li>
            <li><a href="{{ route('create_place') }}">{{ trans('gottashit.nav.add_place') }}</a></li>
            <li><a href="{{ route('logout') }}">{{ trans('gottashit.nav.logout') }}</a></li>
            <li><a href="{{ route('profile', ['user' => \Auth::User()->id]) }}">{{ trans('gottashit.nav.profile') }}</a></li>

        @else

            <li><a href="{{ route('login') }}">{{ trans('gottashit.nav.login') }}</a></li>
            <li><a href="{{ route('register') }}">{{ trans('gottashit.nav.register') }}</a></li>

        @endif

    </ul>

</nav>
