<x-mail::message>
# Hi {{ $user['full_name'] }}

{{  $message }}

{{-- <x-mail::button :url="$url">
You can continue from here
</x-mail::button> --}}

@if($user['location'] != null)

{{  $user['location']['ip'] }}    | {{ $user['location']['countryName'] }}      | {{ $user['location']['regionName'] }}      |


@endif

<p style="color: red">Remember:</p> Keep your card and Pin information secure.
Do not respond to emails requesting for your card/PIN details. If you think an email is suspicious, don't click on any links. Instead, forward it to our customer support.
<br>
Thanks,<br> <br>
{{ config('app.name') }}
</x-mail::message>
