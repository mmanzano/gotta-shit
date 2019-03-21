<form method="post" action="{{ route('place.subscribe.destroy', ['place' => $place->id]) }}">
    {!! csrf_field() !!}
    <input name="_method" type="hidden" value="DELETE">
    <button class="button button-action button-subscribe red" type="submit">
        {{ trans('gottashit.subscription.delete') }}
    </button>
</form>