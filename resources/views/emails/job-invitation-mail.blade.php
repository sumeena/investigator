<x-mail::message>
# Hello,
# {{ @$data['title'] }}
<br>
{{ @$data['assigmentId'] }} <br><br>
{{ @$data['clientId'] }} <br><br>
{{ @$data['companyName'] }} <br><br>
<a href="{{ @$data['loginUrl'] }}" target="_blank">Login</a>{{ @$data['login'] }} <br><br>
<x-mail::button :url="$data['url']">
Show Invitation
</x-mail::button>

Thanks,<br>
{{ @$data['thanks'] }}
</x-mail::message>
