@component('mail::message')
# {{ trans('gottashit.email.new_comment_add', ['place' => $place_name]) }}

@component('mail::button', ['url' => url($path)])
    {{ trans('gottashit.email.new_comment_call_to_action') }}
@endcomponent

{{ trans('gottashit.email.thanks') }},<br>
{{ config('app.name') }}
@endcomponent