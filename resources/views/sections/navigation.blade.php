<nav>

    <ul class="navigation">
        <li><a href="#" class="menu-button">{{ trans('gottashit.nav.menu') }}</a></li>

        <li><a href="{{ route('nearest_places', ['lat' => 40.5, 'lng' => -3.7, 'distance' => 1000]) }}" id="nearest-place" style="display:none">{{ trans('gottashit.nav.nearest') }}</a></li>

        <li><a href="{{ route('place.index') }}">{{ trans('gottashit.nav.all') }}</a></li>
        <li><a href="{{ route('best_places') }}">{{ trans('gottashit.nav.best_places') }}</a></li>


        @if(! Auth::check())
            <li><a href="{{ route('user_login') }}">{{ trans('gottashit.nav.login') }}</a></li>
            <li><a href="{{ route('user_register') }}">{{ trans('gottashit.nav.register') }}</a></li>
        @endif

        <li><a href="{{ route('language', ['language' => 'en']) }}">{{ trans('gottashit.nav.en') }}</a></li>
        <li><a href="{{ route('language', ['language' => 'es']) }}">{{trans('gottashit.nav.es') }}</a></li>
    </ul>

</nav>
