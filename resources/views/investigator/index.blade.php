@extends('layouts.dashboard')
@section('title', 'Dashboard')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">
    <div class="col-lg-8 mb-4 order-0">
      <div class="card">
        <div class="d-flex align-items-end row">
          <div class="col-sm-7">
            <div class="card-body">
              @if(auth()->user()->is_investigator_profile_submitted == 1)
              <h5 class="card-title text-primary">Dashboard</h5>
              <p class="mb-4">
                <span class="fw-bold">Investigator</span> Welcome <span class="fw-bold">to your </span> Investigator profile!
              </p>
              <a href="/investigator/investigator-profile">View your profile</a>
              @else
              <h5 class="card-title text-primary">Dashboard</h5>
              <p class="mb-4">
                <span class="fw-bold">Investigator</span> Dashboard <span class="fw-bold">Features</span> Coming Soon!
              </p>
              @endif
            </div>
          </div>
          <div class="col-sm-5 text-center text-sm-left">
            <div class="card-body pb-0 px-0 px-md-4">
              <img
                src="html/assets/img/illustrations/man-with-laptop-light.png"
                height="140"
                alt="View Badge User"
                data-app-dark-img="illustrations/man-with-laptop-dark.png"
                data-app-light-img="illustrations/man-with-laptop-light.png"
              />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
