@if( ! Auth::check())
    <div class="disclaimer">
            <p>
                {{ Lang::get('gottashit.welcome') }} <a class="disclaimer-link" href="{{ route('register') }}">{{ Lang::get('gottashit.nav.register') }}</a>
            </p>
    </div>
@endif
@if (session('status'))
    <div class="disclaimer">
        <p>{!! session('status') !!}</p>
    </div>
@endif