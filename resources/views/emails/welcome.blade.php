@component('mail::message')
Hello {{ $mailData['name'] }},
<br/>
<br/>
Thank you for registering with the iLogistics investigator scheduling platform. The system can be used with in-house investigators or independent investigators or a combination of both so you can compare which investigator would give you the best value.<br/>
@if($mailData['password'] !="" && $mailData['password'] !="0")
Below are the credentials of your account with iLogistics. Please <a href="https://www.ilogisticsinc.com/">Login</a> to your account to finish setting up your profile. <br/>
Email: `{{ @$mailData['email'] }}`<br/>
Password: `{{ @$mailData['password'] }}`<br/>
@endif
You can also email us below so we can set up training or answer any questions. We want to ensure you are able to leverage iLogistics to its fullest capabilities.<br/>
iLogistics is currently in the beta phase and we look forward to hearing from you with any issues you are experiencing. <br/>
Additionally, if you can think of any way the platform can be improved, please let us know.<br/>
Please send your feedback to info@ilogistics.com<br/><br/>
Regards,<br/>
Your iLogistics Team
@endcomponent