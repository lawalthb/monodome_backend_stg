<x-mail::message>
# Hi {{  $content['full_name'] }},

@if($content['message']=='')
Your password is {{  $content['password']  }} . please dont forget to change it.
@else

{{  $content['message']  }} and your password is {{  $content['password']  }}. please dont forget to change it.

@endif
Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
