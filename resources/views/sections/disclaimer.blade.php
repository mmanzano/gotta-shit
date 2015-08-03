<div class="disclaimer">
    @if(Auth::check())
        <p>
            {{ Lang::get('gottatoshit.start') }} {{ ucfirst(Auth::user()->username) }}
        </p>
    @else
        <p>
            {{ Lang::get('gottatoshit.welcome') }} <a class="disclaimer-link" href="{{ route('register') }}">{{ Lang::get('gottatoshit.nav.register') }}</a>
        </p>
    @endif
    @if (session('status'))
            <p>{!! session('status') !!}</p>
    @endif
</div>

