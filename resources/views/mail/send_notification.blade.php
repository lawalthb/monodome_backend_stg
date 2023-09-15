<x-mail::message>
# Hi {{ $user['full_name'] }}

{{  $message }}

<x-mail::button :url="$url">
You can continue from here
</x-mail::button>

@if($user['location'] != null){
<x-mail::table>
| Ip       | Country         | State  |
| ------------- |:-------------:| --------:|
|    {{  $user['location']['ip'] }}    | {{ $user['location']['countryName'] }}      | {{ $user['location']['regionName'] }}      |
</x-mail::table>
}
Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
