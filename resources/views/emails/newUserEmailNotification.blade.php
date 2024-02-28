<!DOCTYPE html>
<html>
<head>
 <title>New User Registration Mail - iLogisticsinc.com</title>
</head>
<body>
Hello {{$data['admin_name']}},
<br/>
<br/>
A new user has registered on the website <a href="https://www.ilogisticsinc.com/">iLogisticsinc.com</a><br>

User details are : <br>

Name : {{$data['first_name']}} {{$data['last_name']}} <br>
Role : {{$data['role']}} <br>
Email : {{$data['email']}} <br>
Regards,<br/>
iLogistics Team

</body>
</html>
