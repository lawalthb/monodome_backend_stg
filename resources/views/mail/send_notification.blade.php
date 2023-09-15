<x-mail::message>
# Hi {{ $user['full_name'] }}

{{  $message }}

<x-mail::button :url="$url">
Check it
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
