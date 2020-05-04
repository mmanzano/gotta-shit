@component('mail::message')
# {{ trans('gottashit.email.confirm_email_subject') }}

{{ trans('gottashit.email.confirm_email_thanks') }}

@component('mail::button', ['url' => $path])
    {{ trans('gottashit.email.confirm_email_call_to_action') }}
@endcomponent

{{ trans('gottashit.email.thanks') }},<br>
{{ config('app.name') }}
@endcomponent