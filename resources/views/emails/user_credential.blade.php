<!DOCTYPE html>
<html>
<head>
 <title>Credential login for iLogisticsinc.com</title>
</head>
<body>
Hello {{$data['first_name']}} {{$data['last_name']}},
<br/>
<br/>
Below are the credentials of your account with iLogistics. Please <a href="https://www.ilogisticsinc.com/">Login</a> to your account to finish setting up your profile. <br/>
Email: {{ @$data['email'] }}<br/>
Password: {{ @$data['password'] }}<br/>
iLogistics is currently in the beta phase and we look forward to hearing from you with any issues you are experiencing. <br/>
Additionally, if you can think of any way the platform can be improved, please let us know.<br/>
Please send your feedback to info@ilogistics.com<br/><br/>
Regards,<br/>
Your iLogistics Team

</body>
</html>
