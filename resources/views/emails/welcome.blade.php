@component('mail::message')
# Hello from Xiao Kuai Di Yuan.

Welcome to our website.

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
