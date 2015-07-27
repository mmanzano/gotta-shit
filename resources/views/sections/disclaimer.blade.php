@if(Auth::check())
    <div class="container">
        <p>{{ Auth::user()->username }} {{ Lang::get('shitguide.welcome') }}</p>
    </div>
@endif
