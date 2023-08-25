<x-mail::message>
# Hi {{  $content['first_name'] }},

Your verification code is{{  $content['message']  }} {{  $content['code']  }}

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
