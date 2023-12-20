@extends('layouts.dashboard')
@section('title', 'Investigator')
@section('content')
    <div class="row mt-4 mb-4">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{isset($investigator) && !empty($investigator->id) ? 'Edit':'Add'}}
                        Investigator</h5>
                        <a href="{{ route('admin.investigators.index') }}" class="float-end">
                                    Back
                                </a>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('admin.investigators.submit') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">First Name</label>
                            <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                                   name="first_name"
                                   value="{{isset($investigator) && !empty($investigator->first_name) ? $investigator->first_name: old('first_name') }}">
                            @error('first_name')
                            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-company">Last Name</label>
                            <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                   name="last_name"
                                   value="{{isset($investigator) && !empty($investigator->last_name) ? $investigator->last_name: old('last_name') }}">
                            @error('last_name')
                            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                            @enderror
                        </div>
                        @if(isset($investigator) && ($investigator->email))
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-email">Email</label>
                                <div class="input-group input-group-merge">
                                    <input type="email" class="form-control" value="{{$investigator->email}}" disabled>
                                    <input type="hidden" class="form-control @error('email') is-invalid @enderror"
                                           name="email" value="{{$investigator->email}}">
                                </div>
                            </div>
                        @else
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-fullname">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                       name="email"
                                       value="{{isset($investigator) && !empty($investigator->email) ? $investigator->email: old('email') }}">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                                @enderror
                            </div>
                        @endif
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Phone</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone"
                                   value="{{isset($investigator) && !empty($investigator->phone) ? $investigator->phone: old('phone') }}">
                            @error('phone')
                            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                            @enderror
                        </div>
                        <input type="hidden" name="id"
                               value="{{isset($investigator) && !empty($investigator) ? $investigator->id :''}}">
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-message">Role</label>
                            <input type="text" class="form-control" value="Investigator" disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="basic-default-message">Type</label>
                            <input type="text" class="form-control" value="External" disabled>
                        </div>

                        <button type="submit"
                                class="btn btn-primary">{{isset($investigator) && !empty($investigator->id) ? 'Update':'Submit'}}</button>
                        @if(isset($investigator) && ($investigator->id))
                            <a href="{{ route('admin.investigators.reset-password', $investigator->id) }}">
                                <button type="button" class="btn btn-primary">Reset Password</button>
                            </a>
                        @endif
        </form>
      </div>
    </div>
  </div>
  <div class="col-md-1"></div>
</div>
@endsection
