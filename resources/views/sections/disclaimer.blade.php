@if(Auth::check())
    <div class="disclaimer">
        <p>{{ Auth::user()->username }} {{ Lang::get('shitguide.welcome') }}</p>
    </div>
@endif
