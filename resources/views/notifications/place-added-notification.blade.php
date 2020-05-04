@component('mail::message')
# {{ trans('gottashit.email.new_place_add') }}

{{ trans('gottashit.email.new_place_add') }}

{!! trans('gottashit.email.new_place_action', ['username'=> $username, 'user_path' => url($user_path)]) !!}

@component('mail::button', ['url' => url($path)])
{{ trans('gottashit.email.new_place_call_to_action')  }} {{ $place_name }}
@endcomponent

{{ trans('gottashit.email.thanks') }},<br>
{{ config('app.name') }}
@endcomponent