@extends('layout.layout_without_call_to_action')

@section('content')
    <div class="disclaimer">
        <p>{{ Lang::get('gottashit.exception.token') }}</p>
    </div>
@endsection