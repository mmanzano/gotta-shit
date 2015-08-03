@extends('layout.layout')

@section('content')

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="forms">
        <form method="POST" action="/place/{{ $place->id }}/comment/{{ $comment->id }}">
            {!! csrf_field() !!}
            <input name="_method" type="hidden" value="PUT">
            @include('place.partials.comments')
            <div>
                <button type="submit" class="button">{{ ucfirst(Lang::get('gottatoshit.place.edit_comment')) }}</button>
            </div>
        </form>
    </div>
@endsection


@section('javascript')
@endsection