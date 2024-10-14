<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Pusher Chat and Typing Indicator</title>
  <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
  <style>
    /* Styles (same as previous examples) */
    body {
      font-family: Arial, sans-serif;
      background-color: #f2f2f2;
      margin: 0;
      padding: 0;
    }
    h1 {
      background-color: #4CAF50;
      color: white;
      padding: 20px;
      margin: 0;
      text-align: center;
    }
    #login-form, #user-selection, #chat-interface {
      max-width: 600px;
      margin: 20px auto;
      background-color: white;
      padding: 20px;
      border-radius: 5px;
    }
    /* Add other styles as needed */
    #chat-window {
      height: 400px;
      overflow-y: scroll;
      border: 1px solid #ccc;
      padding: 10px;
    }
    .message {
      margin-bottom: 10px;
    }
    .message.sent {
      text-align: right;
    }
    .message.received {
      text-align: left;
    }
    .sender {
      font-weight: bold;
    }
    .timestamp {
      font-size: 0.8em;
      color: #888;
    }
  </style>
</head>
<body>
  <h1>Monodome Chat </h1>

  <!-- Login Form -->
  <div id="login-form">
    <h2>Login</h2>
    <form id="loginForm">
      <label for="email">Email:</label><br>
      <input type="email" id="email" name="email" value="customer@gmail.com" required /><br><br>
      <label for="password">Password:</label><br>
      <input type="password" id="password" name="password" value="password" autocomplete="true" autofocus required /><br><br>
      <button type="submit">Login</button>
    </form>
    <div id="login-error" style="color: red;"></div>
  </div>

  <!-- User Selection -->
  <div id="user-selection" style="display: none;">
    <h2>Select a User to Chat With</h2>
    <ul id="user-list">
      <!-- User list will be populated here -->
    </ul>
  </div>

  <!-- Chat Interface (hidden initially) -->
  <div id="chat-interface" style="display: none;">
    <!-- Chat window -->
    <div id="chat-window">
      <!-- Chat messages will appear here -->
    </div>

    <button id="logoutButton">Logout</button>

    <!-- Typing indicator -->
    <div id="typing-indicator"></div>

    <!-- Message input and send button -->
    <div id="message-form">
      <input type="text" id="messageInput" placeholder="Type your message here..." autocomplete="off">
      <button id="sendButton">Send</button>
    </div>
  </div>

  <script>

    // Check for stored token and user data
    window.onload = function() {
    token = localStorage.getItem('token');
    currentUser = JSON.parse(localStorage.getItem('currentUser'));

    if (token && currentUser) {
        // Hide login form and show user selection
        document.getElementById('login-form').style.display = 'none';
        document.getElementById('user-selection').style.display = 'block';

        // Fetch user list
        fetchUserList();
    }
    };

    document.getElementById('logoutButton').addEventListener('click', function() {
  // Clear localStorage
  localStorage.removeItem('token');
  localStorage.removeItem('currentUser');

  // Reset variables
  token = null;
  currentUser = null;

  // Show login form and hide other sections
  document.getElementById('login-form').style.display = 'block';
  document.getElementById('user-selection').style.display = 'none';
  document.getElementById('chat-interface').style.display = 'none';
});


    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    // Global variables
    let token = null;
    let currentUser = null;
    let receiverId = null;
    let chatRoomId = null;
    let selectedUserName = null;

    // Handle login form submission
    document.getElementById('loginForm').addEventListener('submit', function(event) {
      event.preventDefault();

      let email = document.getElementById('email').value;
      let password = document.getElementById('password').value;

      login(email, password);
    });

    // Login function
    function login(email, password) {
      fetch('https://monodomebackend.test/api/v1/auth/login', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          email: email,
          password: password,
        })
      })
      .then(response => response.json())
      .then(data => {

        if (data.success) {
          token = data.data.token;
          currentUser = data.data.user;

            // Store in localStorage
            localStorage.setItem('token', token);
            localStorage.setItem('currentUser', JSON.stringify(currentUser));

          // Hide login form and show user selection
          document.getElementById('login-form').style.display = 'none';
          document.getElementById('user-selection').style.display = 'block';

          // Fetch user list
          fetchUserList();
        } else {
          document.getElementById('login-error').innerText = data.message;
        }
      })
      .catch(error => {
        console.error('Login error:', error);
        document.getElementById('login-error').innerText = 'Login failed. Please try again.';
      });
    }

    // Fetch user list to select a chat partner
    function fetchUserList() {
      fetch('https://monodomebackend.test/api/v1/auth/users', {
        method: 'GET',
        headers: {
          'Authorization': 'Bearer ' + token,
          'Accept': 'application/json',
        },
      })
      .then(response => response.json())
      .then(data => {

        if (data.data) {
            displayUserList(data.data);
        } else {
          console.error('Error fetching user list:', data.message);
        }
      })
      .catch(error => {
        console.error('Error fetching user list:', error);
      });
    }

    // Display user list
    function displayUserList(users) {
      let userList = document.getElementById('user-list');
      userList.innerHTML = ''; // Clear existing list

      users.forEach(user => {
        // Exclude the current user from the list
        if (user.id !== currentUser.id) {
          let listItem = document.createElement('li');
          listItem.innerHTML = `<button onclick="startChat(${user.id}, '${user.full_name || user.email}')">${user.full_name || user.email}</button>`;
          userList.appendChild(listItem);
        }
      });
    }

    // Start chat with selected user
    function startChat(selectedUserId, selectedUserFullName) {
      receiverId = selectedUserId;
      selectedUserName = selectedUserFullName;

      // Request chat_room_id from backend
      fetch('https://monodomebackend.test/api/v1/chat/get-or-create-chat-room', {
        method: 'POST',
        headers: {
          'Authorization': 'Bearer ' + token,
          'Content-Type': 'application/json',
          'Accept': 'application/json',
        },
        body: JSON.stringify({
          receiver_id: receiverId,
        }),
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          chatRoomId = data.data.chat_room_id;

          // Hide user selection and show chat interface
          document.getElementById('user-selection').style.display = 'none';
          document.getElementById('chat-interface').style.display = 'block';

          // Subscribe to the chat room
          subscribeToChatRoom(token, chatRoomId);

          // Handle typing events
          var messageInput = document.getElementById('messageInput');
          messageInput.addEventListener('input', function() {
            sendTypingEvent();
          });

          // Handle sending messages
          var sendButton = document.getElementById('sendButton');
          sendButton.addEventListener('click', function() {
            sendMessage();
          });

          // Allow pressing Enter to send message
          messageInput.addEventListener('keypress', function(event) {
            if (event.key === 'Enter') {
              event.preventDefault();
              sendMessage();
            }
          });

          // Fetch and display chat history
          fetchChatHistory(chatRoomId);

        } else {
          console.error('Error getting chat room:', data.message);
        }
      })
      .catch(error => {
        console.error('Error getting chat room:', error);
      });
    }

    // Function to subscribe to a chat room
    function subscribeToChatRoom(token, chatRoomId) {
      var pusher = new Pusher('33061ebbadf234b9a705', {
        cluster: 'mt1',
        authEndpoint: "https://monodomebackend.test/api/broadcasting/auth",
        auth: {
          headers: {
            'Authorization': 'Bearer ' + token,
          }
        }
      });

      var channel = pusher.subscribe(`private-chat-room.${chatRoomId}`);


        // Listen for typing events
        channel.bind('user.typing', function(data) {
        var typingIndicator = document.getElementById('typing-indicator');
        typingIndicator.innerHTML = `${data.user.full_name || data.user.name} is typing...`;

        setTimeout(function() {
          typingIndicator.innerHTML = '';
        }, 3000);
      });

       //Listen for chat messages
      channel.bind('user-chat', function(data) {
        console.log('Chat message received:', data);

        // Display the message
        displayMessage(data, data.user.id === currentUser.id ? 'sent' : 'received');
      });


    }

    // Function to send a typing event
    function sendTypingEvent() {
      fetch('https://monodomebackend.test/api/v1/chat/typing', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'Authorization': 'Bearer ' + token,
        },
        body: JSON.stringify({ channel: `chat-room.${chatRoomId}` })
      })
      .then(response => response.json())
      .then(data => {
        console.log('Typing event sent:', data);
      })
      .catch(error => {
        console.error('Error sending typing event:', error);
      });
    }

    // Function to send a chat message
    function sendMessage() {
      var message = document.getElementById('messageInput').value.trim();
      if (message === '') return;

      fetch('https://monodomebackend.test/api/v1/chat/store', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'Authorization': 'Bearer ' + token,
        },
        body: JSON.stringify({
          chat_room_id: chatRoomId,
          sender_id: currentUser.id,
          receiver_id: receiverId,
          message: message,
        })
      })
      .then(response => response.json())
      .then(data => {
        console.log('Message sent:', data);
        if (data.success) {
          document.getElementById('messageInput').value = '';
          // The message will be displayed when received via Pusher
          displayMessage({
        user: currentUser,
        message: message,
        created_at: new Date().toISOString(),
      }, 'sent');

        } else {
          console.error('Error sending message:', data.message);
        }
      })
      .catch(error => {
        console.error('Error sending message:', error);
      });
    }

    // Function to display a chat message
    function displayMessage(data, messageType) {
      var chatWindow = document.getElementById('chat-window');
      var newMessage = document.createElement('div');
      newMessage.classList.add('message', messageType);
      newMessage.innerHTML = `
        <div class="sender">${data.user.full_name || data.user.name}</div>
        <div class="text">${data.message}</div>
        <div class="timestamp">${data.created_at}</div>
      `;
      chatWindow.appendChild(newMessage);
      chatWindow.scrollTop = chatWindow.scrollHeight; // Scroll to bottom
    }

    // Function to fetch and display chat history
    function fetchChatHistory(chatRoomId) {
      fetch('https://monodomebackend.test/api/v1/chat/get', {
        method: 'POST',
        headers: {
          'Authorization': 'Bearer ' + token,
          'Content-Type': 'application/json',
          'Accept': 'application/json',
        },
        body: JSON.stringify({
          chat_room_id: chatRoomId,
        }),
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          data.data.forEach(chat => {
            displayMessage({
              user: chat.sender_id === currentUser.id ? currentUser : { id: receiverId, full_name: selectedUserName },
              message: chat.message,
              created_at: chat.created_at,
            }, chat.sender_id === currentUser.id ? 'sent' : 'received');
          });
        } else {
          console.error('Error fetching chat history:', data.message);
        }
      })
      .catch(error => {
        console.error('Error fetching chat history:', error);
      });
    }
  </script>
</body>
</html>
