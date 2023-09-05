<x-mail::message>
# Hi {{  $content['full_name'] }},

Your password is{{  $content['message']  }} {{  $content['password']  }} . please dont forget to change it.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
