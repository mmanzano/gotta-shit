@if(Auth::check())
    <nav>
        <ul class="navigation navigation-user">
            <li><a href="#" class="menu-button">{{ trans('gottashit.nav.menu_user') }}</a></li>
            <li><a href="{{ route('user_places') }}">{{ trans('gottashit.nav.user_places') }}</a></li>
            <li><a href="{{ route('place.create') }}">{{ trans('gottashit.nav.add_place') }}</a></li>
            <li><a href="{{ Auth::user()->path }}">{{ Auth::user()->username }}</a></li>
            <li><a href="{{ route('user_logout') }}">{{ trans('gottashit.nav.logout') }}</a></li>
        </ul>
    </nav>
@endif
