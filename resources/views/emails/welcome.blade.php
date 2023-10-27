@component('mail::message')
Hello {{ $mailData['name'] }},
<br/>
<br/>
Welcome to iLogistics inc.
<br/>
@if($mailData['password'] !="" && $mailData['password'] !="0")
# Email: `{{ @$mailData['email'] }}`
# Password: `{{ @$mailData['password'] }}`
@endif
<br/>
Please <a href="https://www.ilogisticsinc.com/">Login</a> to your account to finish setting up your profile.
<br/>
<br/>
Thanks,<br/>
Ilogistics Team
@endcomponent
