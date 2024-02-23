<!DOCTYPE html>
<html>
<head>
    <title>Email Template</title>
</head>
<body>
    <h1>Hi {{ $user['full_name'] }}</h1>

    <p>Request from {!! nl2br(e($message)) !!} want to manage you! <a href='{{ url("/api/v1/driver-manager/request") }}/{{ rawurlencode($user->id) }}/{{ auth()->id() }}'  class='btn btn-primary'>  click here to accept  </a></p>

    @if(isset($user['location']))
        <p><em>Location: {{  $user['location']['ip'] }} | {{ $user['location']['countryName'] }} | {{ $user['location']['regionName'] }}</em></p>
    @endif

    <br><br>

    <p><em style="color: red">Remember:</em> <em>Keep your card and Pin information secure. Do not respond to emails requesting for your card/PIN details. If you think an email is suspicious, don't click on any links. Instead, forward it to our customer support.</em></p>

    <br>

    <p>Thanks,<br><br>{{ config('app.name') }}</p>
</body>
</html>
