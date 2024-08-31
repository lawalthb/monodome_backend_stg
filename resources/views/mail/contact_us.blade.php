<!DOCTYPE html>
<html>

<head>
  <title>Contact Us</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
  <div class="container">
    <div class="text-center mt-3 mb-3">
      <img src="{{ asset('logo.jpeg') }}" class="logo" alt="monodomelogo Logo">
    </div>
    <h1>Message from {{ $fullname }}</h1>

    <p>Email: {{$email}} </p>
    <p>Phone: {{$phone}} </p>

    <br><br>

    <p><em style="color: green">Message:</em> {{$body}}</p>

    <br>

    <p><a href="mailto:{{$email}}"> reply back</a><br><br>{{ config('app.name') }}</p>
  </div>
</body>

</html>