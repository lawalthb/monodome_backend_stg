@extends('../../master')

@section('title', 'Agents')

@section('content')

<main id="main" class="main">

  <div class="pagetitle">
    <h1>Agents</h1>

    </nav>
  </div><!-- End Page Title -->

  <section class="section profile">
    <div class="row">


      <div class="col-xl-12">

        <div class="card">
          <div class="card-body pt-3">
            <!-- Bordered Tabs -->
            <ul class="nav nav-tabs nav-tabs-bordered">

              <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview" style="color: green;">AGENT
                  MANAGEMENT</button>
              </li>

              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">AGENT REQUEST</button>
              </li>



            </ul>
            <div class="tab-content pt-2">

              <div class="tab-pane fade show active profile-overview" id="profile-overview">
                <section class="section">
                  <div class="row">

                    <div class="col-lg-12">

                      <div class="card">
                        <div class="card-body">
                          <div class="row">
                            <div class="col">
                              <form>
                                <input type="date" class="form-control">
                              </form>
                            </div>
                            <div class="col"></div>
                            <div class="col"></div>
                          </div>




                          <!-- Table with stripped rows -->
                          <table class="table datatable">
                            <thead>
                              <tr>
                                <th scope="col">#Agent No</th>
                                <th scope="col">Date Added</th>
                                <th scope="col">Business Name</th>
                                <th scope="col">Address</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <th scope="row">1</th>
                                <td>Brandon Jacob</td>
                                <td>Designer</td>
                                <td>28</td>
                                <td>2016-05-25</td>
                                <td>Action</td>
                              </tr>

                            </tbody>
                          </table>
                          <!-- End Table with stripped rows -->

                        </div>
                      </div>

                    </div>
                  </div>
                </section>
              </div>

              <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                <!-- Table with stripped rows -->
                <table class="table datatable" id="table">
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

                    </tr>

                  </tbody>
                </table>



                <!-- End Table with stripped rows -->



              </div><!-- End Bordered Tabs -->

            </div>
          </div>

        </div>
      </div>
  </section>

</main><!-- End #main -->
@endsection

<script>
  const token = "Bearer " + localStorage.getItem('token');
  var myHeaders = new Headers();
  myHeaders.append("Accept", "application/json");
  myHeaders.append("Content-Type", "application/json");
  myHeaders.append("Authorization", token);

  var requestOptions = {
    method: 'GET',
    headers: myHeaders,
    redirect: 'follow'
  };



  fetch("https://monolog.kaysolaknigventures.com/public/api/v1/admin/agent", requestOptions)
    .then(response => response.json())
    .then(
      function res(result) {
        var columns = '';

        // ITERATING THROUGH OBJECTS
        $.each(result.data, function(key, value) {


          columns += '<tr>';

          columns += '<td>' + value.id + '</td>';

          columns += '<td>' + value.created_at + '</td>';

          columns += '<td>' + value.business_name + '</td>';

          columns += '<td>' + value.name + '</td>';

          columns += '<td>' + value.state.name + '(' + value.lga.name + ')' + '</td>';

          columns += '<td>' + value.status + '</td>';
          columns += '<td><a href="view">View</a> </td>';

          columns += '</tr>';
        });

        //INSERTING ROWS INTO TABLE
        $('#table').append(columns);

        console.log(result);
      })
    .catch(error => console.log('error', error));
</script>