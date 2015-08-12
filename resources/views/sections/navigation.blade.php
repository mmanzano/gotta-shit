<nav>

    <ul class="navigation">

        <li><a href="{{ App::getLocale() }}/place/40.5/-3.7/1000" id="nearest-place" style="display:none">{{ trans('gottashit.nav.nearest') }}</a></li>

        @if(App::getLocale() == 'es')
            <li><a href="/en">English</a></li>
        @else
            <li><a href="/es">Español</a></li>
        @endif

        <li><a href="{{ route('all_places', ['language' => App::getLocale()]) }}">{{ trans('gottashit.nav.all') }}</a></li>
        <li><a href="{{ route('best_places', ['language' => App::getLocale()]) }}">{{ trans('gottashit.nav.best_places') }}</a></li>


        @if(Auth::check())

            <li><a href="{{ route('user_places', ['language' => App::getLocale()]) }}">{{ trans('gottashit.nav.user_places') }}</a></li>
            <li><a href="{{ route('place_create_form', ['language' => App::getLocale()]) }}">{{ trans('gottashit.nav.add_place') }}</a></li>
            <li><a href="{{ route('user_logout', ['language' => App::getLocale()]) }}">{{ trans('gottashit.nav.logout') }}</a></li>
            <li><a href="{{ route('user_profile', ['language' => App::getLocale(), 'user' => \Auth::User()->id]) }}">{{ trans('gottashit.nav.profile') }}</a></li>

        @else

            <li><a href="{{ route('user_login', ['language' => App::getLocale()]) }}">{{ trans('gottashit.nav.login') }}</a></li>
            <li><a href="{{ route('user_register', ['language' => App::getLocale()]) }}">{{ trans('gottashit.nav.register') }}</a></li>

        @endif

    </ul>

</nav>
