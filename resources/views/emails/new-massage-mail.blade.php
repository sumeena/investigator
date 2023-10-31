<x-mail::message>
# Hello, {{ @$data['first_name'] }} {{ @$data['last_name'] }}
# {{ @$data['title'] }}
<br>
<br>
<a href="{{ @$data['loginUrl'] }}" target="_blank">Login</a>{{ @$data['login'] }} <br><br>


Thanks,<br>
{{ @$data['thanks'] }}
</x-mail::message>
