@component('mail::message')
Hello {{ $mailData['name'] }},
<br/>
<br/>
Thank you for registering with iLogistics, the staff investigator scheduling platform that was made for the experienced investigator to monetize their schedule at the rates you want. <br/>
@if($mailData['password'] !="" && $mailData['password'] !="0")
Below are the credentials of your account with iLogistics. Please <a href="https://www.ilogisticsinc.com/">Login</a> to your account to finish setting up your profile. <br/>
Email: `{{ @$mailData['email'] }}`<br/>
Password: `{{ @$mailData['password'] }}`<br/>
@endif
iLogistics is currently in the beta phase and we look forward to hearing from you with any issues you are experiencing. <br/>
Additionally, if you can think of any way the platform can be improved, please let us know.<br/>
Please send your feedback to info@ilogistics.com<br/><br/>
Regards,<br/>
Your iLogistics Team
@endcomponent