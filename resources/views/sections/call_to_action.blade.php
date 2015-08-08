<div class="footer">
    @if( ! Auth::check())
        <p class="footer-p">
            {{ Lang::get('gottashit.welcome') }} <a class="disclaimer-link" href="{{ route('register') }}">{{ Lang::get('gottashit.nav.register') }}</a>
        </p>
    @endif
</div>