<div class="disclaimer">
    @if(Auth::check())
        <p>
            {{ Lang::get('gottashit.start') }} {{ ucfirst(Auth::user()->full_name) }}.
        </p>
    @else
        <p>
            {{ Lang::get('gottashit.welcome') }} <a class="disclaimer-link" href="{{ route('register') }}">{{ Lang::get('gottashit.nav.register') }}</a>
        </p>
    @endif
    @if (session('status'))
            <p>{!! session('status') !!}</p>
    @endif
    <p id="disclaimer-notice" class="disclaimer-notice"></p>
</div>

