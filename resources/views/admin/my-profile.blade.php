@extends('layouts.dashboard')
@section('title', 'Profile')
@section('content')
<div class="row mt-4 mb-4">
  <div class="col-md-1"></div>
  <div class="col-md-10">
    <div class="card mb-4">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">My Profile</h5>
      </div>
      <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <form method="post" action="/admin/profile/update">
          @csrf
          <div class="mb-3">
            <label class="form-label" for="basic-default-fullname">First Name</label>
            <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{isset($profile) && !empty($profile->first_name) ? $profile->first_name:'' }}">
            @error('first_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="mb-3">
            <label class="form-label" for="basic-default-company">Last Name</label>
            <input type="text" class="form-control @error('last_name') is-invalid @enderror"  name="last_name" value="{{isset($profile) && !empty($profile->last_name) ? $profile->last_name:'' }}">
            @error('last_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="mb-3">
            <label class="form-label" for="basic-default-email">Email</label>
            <div class="input-group input-group-merge">
              <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{isset($profile) && !empty($profile->email) ? $profile->email:''}}">
            </div>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="mb-3">
            <label class="form-label" for="basic-default-fullname">Phone</label>
            <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{isset($profile) && !empty($profile->phone) ? $profile->phone:'' }}">
            @error('phone')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="mb-3">
            <label class="form-label" for="basic-default-message">Role</label>
            <input type="text" class="form-control" value="Admin" disabled>
          </div>
          <button type="submit" class="btn btn-primary">{{isset($profile) && !empty($profile->id) ? 'Update':'Submit'}}</button>
          <a href = "/admin/reset-password"><button type="button" class="btn btn-primary">Reset Password</button></a>
        </form>
      </div>
    </div>
  </div>
  <div class="col-md-1"></div>
</div>
@endsection
