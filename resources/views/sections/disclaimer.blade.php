@if (session('status'))
    <div class="disclaimer">
        <p>{!! session('status') !!}</p>
    </div>
@endif