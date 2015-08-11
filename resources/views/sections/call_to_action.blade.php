<div class="footer">
    @if( ! Auth::check())
        <p class="footer-p">
            {!! trans('gottashit.welcome', ['path' => route('register')]) !!}
        </p>
    @endif
</div>