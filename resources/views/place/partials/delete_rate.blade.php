<li>
    <form method="POST" action="{{ route('place.stars.destroy', ['place' => $place->id]) }}">
        {!! csrf_field() !!}
        <input name="_method" type="hidden" value="DELETE">
        <button class="button button-rate button-rate-delete" type="submit">{{ trans('gottashit.star.delete_star') }}</button>
    </form>
</li>