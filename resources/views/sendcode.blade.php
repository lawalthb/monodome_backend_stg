<x-mail::message>
# Hi {{  $content['full_name'] }},

Your verification code is{{  $content['message']  }} {{  $content['code']  }}

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
