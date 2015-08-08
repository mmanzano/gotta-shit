<div class="footer">
    @if( ! Auth::check())
        <p class="footer-p">
            {{ trans('gottashit.welcome') }} <a class="disclaimer-link" href="{{ route('register') }}">{{ trans('gottashit.nav.register') }}</a>
        </p>
    @endif
</div>