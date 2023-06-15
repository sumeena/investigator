@extends('layouts.dashboard')
@section('content')
    <div class="row mt-4 mb-4">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Reset Password</h5>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('admin.hiring-managers.update-password') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Enter New Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                   name="password">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                            @enderror
                        </div>
                        <input type="hidden" name="user_id" value="{{ isset($user_id) ? $user_id : '' }}">
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-company">Confirm Password</label>
                            <input type="password" class="form-control @error('last_name') is-invalid @enderror"  name="password_confirmation">
          </div>
          <button type="submit" class="btn btn-primary">Update Password</button>
        </form>
      </div>
    </div>
  </div>
  <div class="col-md-1"></div>
</div>
@endsection
