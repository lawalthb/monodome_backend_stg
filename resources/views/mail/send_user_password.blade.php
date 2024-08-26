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
    <h1>Hello, {{ $full_name }}</h1>
    <p>Your account has been created. Here are your login details:</p>
    <p><strong>Email:</strong> {{ $email }}</p>
    <p><strong>Password:</strong> {{ $password }}</p>
    <p>Please make sure to change your password after your first login.</p>
    <p>Thank you for being part of our team!</p>
</div>
</body>
</html>
