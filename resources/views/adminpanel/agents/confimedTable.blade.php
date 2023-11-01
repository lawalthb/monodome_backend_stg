<div class="tab-pane fade show active confirmedTable" id="confirmedTable">
  <section class="section">
    <div class="row">

      <div class="col-lg-12">

        <div class="card">
          <div class="card-body">
            <div class="row mb-3">
              <div class="col">
                <form>
                  <input type="date" class="form-control" style="width: 200px;">
                </form>
              </div>
              <div class="col"></div>
              <div class="col">
                <div class="input-group">

                  <span class="input-group-text">Sort by</span>
                  <select class="form-control">
                    <option>AgentNo</option>
                    <option>Fullname</option>
                    <option>Business name</option>
                  </select>

                </div>
              </div>
            </div>





            <table class="table datatable" id="confirmed_table">
              <thead>
                <tr>
                  <th scope="col">#Agent No</th>
                  <th scope="col">Date Added</th>
                  <th scope="col">Business Name</th>
                  <th scope="col">Address</th>
                  <th scope="col">Phone</th>
                  <th scope="col">Status</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="loading1 text-center" style="display: block;" colspan="7">Loading...</td>
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