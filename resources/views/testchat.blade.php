<!DOCTYPE html>
<head>
  <title>Pusher Test</title>
  <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <script>

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('33061ebbadf234b9a705', {
      cluster: 'mt1',
      channelAuthorization: { endpoint: "https://monodomebackend.test/api/broadcasting/auth"},
      authEndpoint: 'https://monodomebackend.test/api/broadcasting/auth', // Endpoint for authentication

    });

    var channel = pusher.subscribe('private-chat');
    channel.bind('user-chat', function(data) {

        console.log(data)
      // Display user and message information
      var user = data.user;
      var message = data.message;

      document.getElementById('user-info').innerHTML = `
        <h2>User Information</h2>
        <p>ID: ${user.id}</p>
        <p>Full Name: ${user.full_name}</p>
        <p>Email: ${user.email}</p>
        <p>Role: ${user.role}</p>
      `;

      document.getElementById('message-info').innerHTML = `
        <h2>Message Information</h2>
        <p>Message: ${message.message}</p>
        <p>File Path: ${message.file_path}</p>
        <p>Created At: ${message.created_at}</p>
      `;
    });
  </script>
</head>
<body>
  <h1>Pusher Test</h1>
  <div id="user-info"></div>
  <div id="message-info"></div>
</body>
</html>
