<form method="post" action="{{ route('place_subscribe', ['language' => App::getLocale(), 'place' => $place->id]) }}">
    {!! csrf_field() !!}
    <input name="_method" type="hidden" value="POST">
    <button class="button button-action button-subscribe" type="submit">
        {{ trans('gottashit.subscription.add') }}
    </button>
</form>