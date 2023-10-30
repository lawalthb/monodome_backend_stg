import { getR, postR } from "../utils.js";
import { AllRecords, singleRecord } from "../endpoints.js";
import { selectE } from "../selectors.js";
import { fetchAgents } from "../functions.js";


const allAgents = AllRecords('agent');
const showAgent = singleRecord('agent', 'show');
const statusAgent = singleRecord('agent', 'status');


  //get all comfirmed agents
fetch(allAgents, getR)
    .then(response => response.json())
    .then(
      function res(result) {

        var columns = '';
        var loading1 = selectE('.loading1');

        loading1.style.display = 'none';

        if (!result.data == "") {
          loading1.style.display = 'block';
          loading1.innerHTML = "No record!";
        }
        $.each(result.data, function (key, value) {

          if (value.status == "Confirmed") {

            columns += '<tr>';

            columns += '<td>' + value.id + '</td>';

            columns += '<td>' + value.created_at + '</td>';

            columns += '<td>' + value.business_name + '</td>';

            columns += '<td>' + value.name + '</td>';

            columns += '<td>' + value.state.name + '(' + value.lga.name + ')' + '</td>';

            columns += '<td>' + value.status + '</td>';
            columns += '<td><img src={{asset("assets/img/eye.png")}} data-bs-toggle="modal" data-bs-target="#largeModal" width="30px" height="30px"  id="view_single_agent" onclick="view_single_agent(' + value.id + ')" /> </td>';

            columns += '</tr>';
          }
        });

        $('#confirmed_table').append(columns);

        console.log(result);

      })
    .catch(error => console.log('error', error));



//get  all agent with rejected or pending status

  fetch(allAgents, getR)
    .then(response => response.json())
    .then(
      function res(result) {
        var columns = '';

        var loading2 = selectE('.loading2');
        loading2.style.display = 'none';

         if (!result.data == "") {
          loading2.style.display = 'block';
          loading2.innerHTML = "No record!";
        }


        $.each(result.data, function (key, value) {

          if (value.status == "Pending" || value.status == "Rejected" ) {
            columns += '<tr>';

            columns += '<td>' + value.id + '</td>';

            columns += '<td>' + value.created_at + '</td>';

            columns += '<td>' + value.business_name + '</td>';

            columns += '<td>' + value.name + '</td>';

            columns += '<td>' + value.state.name + '(' + value.lga.name + ')' + '</td>';

            columns += '<td>' + value.status + '</td>';
            columns += '<td><img src={{asset("assets/img/eye.png")}} data-bs-toggle="modal" data-bs-target="#largeModal" width="30px" height="30px"  id="view_single_agent" onclick="view_single_agent(' + value.id + ')" /> </td>';

            columns += '</tr>';
          }
          });

        $('#pending_table').append(columns);

        console.log(result);
      })
    .catch(error => console.log('error', error));



  // to view selected agent details

  function view_single_agent(id) {

    fetch(showAgent+'/' + id, getR)
      .then(response => response.json())
      .then(
        function res(result) {
          const full_name = selectE('#full_name');
          const agent_no = selectE('#agent_no');
          const date_added = selectE('#date_added');
          const profile_img = selectE('#profile_img');
          const email = selectE('#email');
          const address = selectE('#address');
          const phone = selectE('#phone');
          const business_name = selectE('#business_name');
          const front_img = selectE('#front_img');
          const inside_img = selectE('#inside_img');
          const doc_link = selectE('#doc_link');
          // const nin = selectE('#nin');

          agent_no.innerHTML = '000' + result.data.id;
          full_name.innerHTML = result.data.name;
          business_name.innerHTML = result.data.business_name;
          profile_img.src = result.data.user.profile_url;
          date_added.innerHTML = result.data.created_at;
          email.innerHTML = result.data.user.email;
          phone.innerHTML = result.data.user.phone_number;
          address.innerHTML = result.data.street + ", " + result.data.lga.name + ", " + result.data.state.name;
          front_img.src = result.data.store_front_image;
          inside_img.src = result.data.inside_store_image;
          doc_link.href = result.data.registration_documents;
          //  nin.innerHTML = result.data.nin;


          //get and set guarantor 1
          const g1_img = selectE('#g1_img');
          const g1_name = selectE('#g1_name');


          g1_img.src = result.data.guarantors[0].profile_picture;
          g1_name.innerHTML = result.data.guarantors[0].full_name
          console.log(result);
        })
      .catch(error => console.log('error', error));



  }




  // update status to accept or reject

  function change_status(status, id) {
    // Define the API endpoint URL

    const requestData = {
      "status": status
    };

    fetch(statusAgent+'/'+ id, {
       postR,
        body: JSON.stringify(requestData),
      })
      .then(response => {
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        return response.json();
      })
      .then(data => {

        console.log('API response:', data);
      })
      .catch(error => {
        console.error('Error:', error);
      });


  }