<nav>

    <ul class="navigation">
        <li><a class="menu-button">{{ trans('gottashit.nav.menu') }}</a></li>

        <li><a href="{{ App::getLocale() }}/place/40.5/-3.7/1000" id="nearest-place" style="display:none">{{ trans('gottashit.nav.nearest') }}</a></li>

        <li><a href="{{ route('all_places', ['language' => App::getLocale()]) }}">{{ trans('gottashit.nav.all') }}</a></li>
        <li><a href="{{ route('best_places', ['language' => App::getLocale()]) }}">{{ trans('gottashit.nav.best_places') }}</a></li>


        @if(! Auth::check())
            <li><a href="{{ route('user_login', ['language' => App::getLocale()]) }}">{{ trans('gottashit.nav.login') }}</a></li>
            <li><a href="{{ route('user_register', ['language' => App::getLocale()]) }}">{{ trans('gottashit.nav.register') }}</a></li>
        @endif

        <li><a href="{{ route('language', ['language' => 'en']) }}">{{ trans('gottashit.nav.en') }}</a></li>
        <li><a href="{{ route('language', ['language' => 'es']) }}">{{trans('gottashit.nav.es') }}</a></li>
    </ul>

</nav>
