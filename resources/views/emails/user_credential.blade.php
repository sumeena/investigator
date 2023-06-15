<x-mail::message>
# Hello {{ @$data['first_name'] . ' ' . $data['last_name'] }}, You have been added as a {{ @$roleText }}.

# Your login credentials are as follows:
# Email: `{{ @$data['email'] }}`
# Password: `{{ @$data['password'] }}`

<x-mail::button :url="route('login')">
    Login Now
</x-mail::button>

Thanks,<br>
Investigative Services
</x-mail::message>
