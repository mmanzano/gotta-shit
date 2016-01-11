@if(Auth::check())
    <nav>
        <ul class="navigation navigation-user">
            <li><a href="#" class="menu-button">{{ trans('gottashit.nav.menu_user') }}</a></li>
            <li><a href="{{ route('user_places', ['language' => App::getLocale()]) }}">{{ trans('gottashit.nav.user_places') }}</a></li>
            <li><a href="{{ route('place.create', ['language' => App::getLocale()]) }}">{{ trans('gottashit.nav.add_place') }}</a></li>
            <li><a href="{{ route('user.show', ['language' => App::getLocale(), 'user' => \Auth::User()->id]) }}">{{ \Auth::User()->username }}</a></li>
            <li><a href="{{ route('user_logout', ['language' => App::getLocale()]) }}">{{ trans('gottashit.nav.logout') }}</a></li>
        </ul>
    </nav>
@endif
