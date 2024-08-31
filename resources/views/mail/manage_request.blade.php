<!DOCTYPE html>
<html>

<head>
    <title>Email Template</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="text-center mt-3 mb-3">
            <img src="{{ asset('logo.jpeg') }}" class="logo" alt="monodomelogo Logo">
        </div>
        <h1>Hi {{ $user['full_name'] }}</h1>

        <p>Request from {!! nl2br(e($message)) !!} want to manage you! </p>
        <div class="d-grid gap-2">
            <a href='{{ url("/api/v1/driver-manager/request") }}/{{ rawurlencode($user->id) }}/{{ auth()->id() }}/accepted' class='btn btn-success btn-sm text-white'>Click here to accept</a>
            <hr>
            <a href='{{ url("/api/v1/driver-manager/request") }}/{{ rawurlencode($user->id) }}/{{ auth()->id() }}/rejected' class='btn btn-danger btn-sm text-white'>Click here to reject</a>
        </div>

        @if(isset($user['location']))
        <p><em>Location: {{ $user['location']['ip'] }} | {{ $user['location']['countryName'] }} | {{ $user['location']['regionName'] }}</em></p>
        @endif

        <br><br>

        <p><em style="color: red">Remember:</em> <em>Keep your card and Pin information secure. Do not respond to emails requesting for your card/PIN details. If you think an email is suspicious, don't click on any links. Instead, forward it to our customer support.</em></p>

        <br>

        <p>Thanks,<br><br>{{ config('app.name') }}</p>
    </div>
</body>

</html>