@component('mail::message')
Hello {{ $data['investigatorName'] }},
<br/>
<br/>
A new company "{{ $data['companyName'] }}" has registered and is initially blocked.
<br/>
If you want to unblock this company then please <a href="https://www.ilogisticsinc.com/">Login</a> to your account to continue.
<br/>
Additionally, if you can think of any way the platform can be improved, please let us know.<br/>
Please send your feedback to info@ilogistics.com<br/><br/>
Regards,<br/>
Your iLogistics Team
@endcomponent