<!DOCTYPE html>
<html>
<head>
    <title>Email Template</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1>Hi {{ $user['full_name'] }}</h1>

        <p>Request from {!! nl2br(e($message)) !!} want to manage you! </p>
        <div class="d-grid gap-2">
            <a href='{{ url("/api/v1/driver-manager/request") }}/{{ rawurlencode($user->id) }}/{{ auth()->id() }}'  class='btn btn-primary'>Click here to accept</a>
            <a href='{{ url("/api/v1/driver-manager/request") }}/{{ rawurlencode($user->id) }}/{{ auth()->id() }}'  class='btn btn-danger'>Click here to reject</a>
        </div>

        @if(isset($user['location']))
            <p><em>Location: {{  $user['location']['ip'] }} | {{ $user['location']['countryName'] }} | {{ $user['location']['regionName'] }}</em></p>
        @endif

        <br><br>

        <p><em style="color: red">Remember:</em> <em>Keep your card and Pin information secure. Do not respond to emails requesting for your card/PIN details. If you think an email is suspicious, don't click on any links. Instead, forward it to our customer support.</em></p>

        <br>

        <p>Thanks,<br><br>{{ config('app.name') }}</p>
    </div>
</body>
</html>
