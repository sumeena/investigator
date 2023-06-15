@extends('layouts.dashboard')
@section('content')
    <div class="row mt-4 mb-4">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{isset($hm) && !empty($hm->id) ? 'Edit':'Add'}} Hiring Manager</h5>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('admin.hiring-managers.submit') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">First Name</label>
                            <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                                   name="first_name"
                                   value="{{isset($hm) && !empty($hm->first_name) ? $hm->first_name: old('first_name') }}">
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
                                   value="{{isset($hm) && !empty($hm->last_name) ? $hm->last_name: old('last_name') }}">
                            @error('last_name')
                            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                            @enderror
                        </div>

                        @if(isset($hm) && ($hm->email))
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-email">Email</label>
                                <div class="input-group input-group-merge">
                                    <input type="text" class="form-control" value="{{$hm->email}}" disabled>
                                    <input type="hidden" class="form-control @error('email') is-invalid @enderror"
                                           name="email" value="{{$hm->email}}">
                                </div>
                            </div>
                        @else
                            <div class="mb-3">
                                <label class="form-label" for="email">Email</label>
                                <input type="text" class="form-control @error('email') is-invalid @enderror"
                                       name="email" value="{{old('email')}}" id="email">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label" for="basic-default-company">Phone</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone"
                                   value="{{isset($hm) && !empty($hm->phone) ? $hm->phone: old('phone') }}">
                            @error('phone')
                            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                            @enderror
                        </div>

                        <input type="hidden" name="id"
                               value="{{isset($hm) && !empty($hm) ? $hm->id :''}}">

                        <div class="mb-3">
                            <label class="form-label" for="basic-default-message">Role</label>
                            <input type="text" class="form-control" value="Hiring Manager" disabled>
                        </div>

                        <button type="submit"
                                class="btn btn-primary">{{isset($hm) && !empty($hm->id) ? 'Update':'Submit'}}</button>

                        @if(isset($hm) && ($hm->id))
                            <a href="{{ route('admin.hiring-managers.reset-password', $hm->id) }}">
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
