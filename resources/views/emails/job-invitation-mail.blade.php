<x-mail::message>
# {{ @$data['title'] }}

{{ @$data['message'] }}

<x-mail::button :url="$data['url']">
Show Invitation
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
