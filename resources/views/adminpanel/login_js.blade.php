<script>
  // to get opt code base on enter email
  const sent_otp_btn = document.getElementById('sent_otp_btn');
  const otp_err_msg = document.getElementById('otp_err_msg');
  const otp_suc_msg = document.getElementById('otp_suc_msg');
  const email = document.getElementById('email');
  const password = document.getElementById('password');
  const otp = document.getElementById('otp');
  const submit_btn = document.getElementById('submit_btn');
  const login_err_msg = document.getElementById('login_err_msg');
  var email_address = email.value;

  //send otp
  sent_otp_btn.addEventListener('click', async function() {
    sent_otp_btn.style.display = 'none';
    if (email.value !== "") {

      //  alert(email_address);
      const data = {
        email: email_address,
      };

      function hide_otp_suc() {
        otp_suc_msg.style.display = 'none';
      }

      function hide_otp_error() {
        otp_err_msg.style.display = 'none';
      }

      function show_otp_link() {
        sent_otp_btn.style.display = 'block';
      }

      const apiUrl = 'https://monolog.kaysolaknigventures.com/api/v1/admin/auth/send-otp';
      const xhr = new XMLHttpRequest();
      xhr.open('POST', apiUrl, true);
      xhr.setRequestHeader('Content-Type', 'application/json');
      xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 300) {
          const responseData = JSON.parse(xhr.responseText);

          otp_suc_msg.style.display = 'block';
          setTimeout(show_otp_link, 5000);
          setTimeout(hide_otp_suc, 5000);

          console.log('API response:', responseData);
        } else {
          otp_err_msg.style.display = 'block';

          setTimeout(show_otp_link, 5000);
          setTimeout(hide_otp_error, 5000);



          console.error('Error:', xhr.status, xhr.statusText);
        }
      };
      const jsonData = JSON.stringify(data);
      xhr.send(jsonData);

    } else {
      alert('enter email to get otp');
    }



  });
</script>


<script>
  //login
  submit_btn.addEventListener('click', async function() {
    event.preventDefault();
    submit_btn.disabled = true;
    // const formData = new FormData(event.target);

    if (email.value !== "" && password.value !== "") {
      var email_address = email.value;
      var password_login = password.value;
      var otp_login = otp.value;
      //  alert(email_address);
      const data = {
        email: email_address,
        password: password_login,
        otp: otp_login,
      };

      function hide_login_error() {
        login_err_msg.style.display = 'none';
      }

      function enable_btn() {
        submit_btn.disabled = false;
      }


      console.log(data);
      const apiUrl = 'https://monolog.kaysolaknigventures.com/api/v1/admin/auth/login';
      const xhr = new XMLHttpRequest();
      xhr.open('POST', apiUrl, true);
      xhr.setRequestHeader('Content-Type', 'application/json');
      xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 300) {
          const responseData = JSON.parse(xhr.responseText);

          //alert(responseData.message);
          if (responseData.success == true) {
            var token = responseData.data.token;
            const user_type = responseData.data.user.user_type;
            const user_email = responseData.data.user.email;
            const user_role_name = responseData.data.user.role[0].name;
            const user_role_id = responseData.data.user.role[0].id;

            const user_id = responseData.data.user.id;
            //localStorage.setItem("token", token);
            // Store the access_token in session storage
            sessionStorage.setItem('token', token);

            // Retrieve the access_token


            localStorage.setItem("user_fullname", responseData.data.user.full_name);
            localStorage.setItem("user_type", user_type);
            localStorage.setItem("user_email", user_email);
            localStorage.setItem("user_role_id", user_role_id);
            localStorage.setItem("user_role_name", user_role_name);
            localStorage.setItem("user_id", user_id);


            location.replace('/adminpanel/agents');


          }




          console.log('API response:', responseData);
        } else {

          login_err_msg.style.display = 'block';

          setTimeout(enable_btn, 5000);
          setTimeout(hide_login_error, 5000);
          console.log('Error:', responseData);

          console.error('Error:', xhr.status, xhr.statusText);
        }
      };
      const jsonData = JSON.stringify(data);
      xhr.send(jsonData);

    } else {
      alert('enter email and password');
    }



  });
</script>