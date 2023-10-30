<div class="tab-pane fade pendingTable pt-3" id="pendingTable">

  <!-- Table with stripped rows -->
  <table class="table datatable" id="pending_table">
    <thead>
      <tr>
        <th scope="col">#Agent No</th>
        <th scope="col">Date Added</th>
        <th scope="col">Business Name</th>
        <th scope="col">Full Name</th>
        <th scope="col">State(LGA)</th>
        <th scope="col">Status</th>
        <th scope="col">View </th>
      </tr>
    </thead>
    <tbody id="tableBody">
      <tr>
        <td class="loading2 text-center" style="display: block;" colspan="7">Loading...</td>
      </tr>

    </tbody>
  </table>

  <!-- End Table with stripped rows -->
  <!-- mondal for pending agents -->
  <div class="modal fade" id="largeModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content ">
        <div class=" ">
          <div class="row align-items-start">
            <div class="col-4">

            </div>
            <div class="col-6">
              <h5>Agent's Request Details</h5>
            </div>
            <div class="col-2 text-right">
              &nbsp;&nbsp;&nbsp; <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></&nbsp;button>
            </div>
          </div>





        </div>
        <div class="modal-body">

          <div class="row align-items-start">
            <div class="col" style="border-right: solid 2px; border-color: grey;">
              <h3 style="font-size: 20px; font-weight: 600; color: black;">Agent</h3>
              <div class="row">
                <div class="col-md-6">
                  <img id="profile_img" alt="profile iamge loading..." />
                </div>

                <div class="col-md-6">
                  <!-- Content for the third column -->
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  Agent Number
                </div>

                <div class="col-md-6" id="agent_no">
                  loading...
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  Date added
                </div>

                <div class="col-md-6" id="date_added">
                  loading...
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  Name
                </div>

                <div class="col-md-6" id="full_name">
                  loading...
                </div>
              </div>


              <div class="row">
                <div class="col-md-6">
                  business name
                </div>

                <div class="col-md-6" id="business_name">
                  loading...
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  Email
                </div>

                <div class="col-md-6" id="email">
                  loading...
                </div>
              </div>



              <div class="row">
                <div class="col-md-6">
                  Phone Number
                </div>

                <div class="col-md-6" id="phone">
                  loading...
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  Address
                </div>

                <div class="col-md-6" id="address">
                  loading...
                </div>
              </div>


              <div class="row">
                <div class="col-md-6">
                  NIN number
                </div>

                <div class="col-md-6" id="nin">
                  Loading...
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  Picture of the front of the store
                </div>

                <div class="col-md-6" id="nin">
                  <img id="front_img" alt="front store imge loading..." />
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  Picture of the inside of the store
                </div>

                <div class="col-md-6" id="nin">
                  <img id="inside_img" alt="inside store imge loading..." />
                </div>
              </div>


              <div class="row">
                <div class="col-md-6">
                  Registration documents
                </div>

                <div class="col-md-6" id="nin">
                  <a href="" target="_blank" id="doc_link">Click to download</a>
                </div>
              </div>



            </div>

            <div class="col">
              <h3 style="font-size: 20px; font-weight: 600; color: black;">Guarantor 1</h3>
              <div class="row">
                <div class="col-md-6">
                  Guarantor photo
                </div>

                <div class="col-md-6" id="g1_img">
                  pics
                </div>
              </div>


              <div class="row">
                <div class="col-md-6">
                  Full name
                </div>

                <div class="col-md-6" id="g1_name">
                  loading...
                </div>
              </div>




            </div>




          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" onclick="change_status('Confirmed')">Accept</button>
          <button type="button" class="btn btn-primary" onclick="change_status('Rejected')">Reject</button>
        </div>
      </div>
    </div>
  </div>


</div>