<x-mail::message>
# Hello,<br>
{{ @$data['title'] }}
<br>
<br>
<a href="{{ @$data['loginUrl'] }}" target="_blank">Login</a>{{ @$data['login'] }} <br><br>

Thanks,<br>
{{ @$data['thanks'] }}
</x-mail::message>
