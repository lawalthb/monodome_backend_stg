
//to get user access token
const token_check = "Bearer " + sessionStorage.getItem('token');
    if (token_check == "Bearer null" || !token_check) {
//if token is not find - go to login page
      location.replace('/adminpanel');
    }


//header options
const headers = new Headers();
  headers.append("Accept", "application/json");
  headers.append("Content-Type", "application/json");
  headers.append("Authorization", token_check);

  // for GET method
  const getR = {
    method: 'GET',
    headers,
    redirect: 'follow'
};

 // for Post method - body will be added where needed
  const postR = {
    method: 'POST',
    headers,
    redirect: 'follow'
  };


  export {
  token_check,
  getR,
    postR
}