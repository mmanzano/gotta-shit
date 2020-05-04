@component('mail::message')
# {{ trans('gottashit.email.new_contact_form') }}

{{ trans('gottashit.email.new_contact_form') }}

Email: {{ $email }}

Body: {{ $body }}

@endcomponent