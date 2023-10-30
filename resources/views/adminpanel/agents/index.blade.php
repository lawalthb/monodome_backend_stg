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
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#confirmedTable" style="color: green;">AGENT
                  MANAGEMENT</button>
              </li>

              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#pendingTable">AGENT REQUEST</button>
              </li>



            </ul>
            <div class="tab-content pt-2">
              <!-- Table comfirned agents -->
              @include('adminpanel.agents.confimedTable')

              <!-- Table pending agents -->
              @include('adminpanel.agents.pendingTable')

              <!-- End Bordered Tabs -->

            </div>
          </div>

        </div>
      </div>
  </section>
 
</main><!-- End #main -->



@endsection




@push('scripts')
<script type="module" src="{{ asset('assets/js/agent/index.js') }}"></script>
@endpush