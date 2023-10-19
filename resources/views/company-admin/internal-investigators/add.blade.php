@extends('layouts.dashboard')
@section('title', 'Company User')
@section('content')
    <div class="row mt-4 mb-4 justify-content-center">
        <div class="col-md-10">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        {{ @$investigator->id ? 'Edit' : 'Add' }}
                        Internal Investigator
                    </h5>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('company-admin.internal-investigators.submit') }}">
                        @csrf

                        <input type="hidden" name="submit_type" value="{{ @$investigator->id ? 'edit' : 'add' }}">

                        <div class="mb-3">
                            <label class="form-label" for="first-name">First Name</label>
                            <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                                   name="first_name" id="first-name"
                                   value="{{ old('first_name', $investigator->first_name ?? '') }}">
                            @error('first_name')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="last-name">Last Name</label>
                            <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                   name="last_name" id="last-name"
                                   value="{{ old('last_name', $investigator->last_name ??  '') }}">
                            @error('last_name')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        @if (@$investigator->email)
                            <div class="mb-3">
                                <label class="form-label" for="email">Email</label>
                                <div class="input-group input-group-merge">
                                    <input type="text" class="form-control" id="email"
                                           value="{{ $investigator->email }}" disabled>
                                    <input type="hidden" class="form-control" required
                                           name="email" value="{{ $investigator->email }}">
                                </div>
                            </div>
                        @else
                            <div class="mb-3">
                                <label class="form-label" for="email">Email</label>
                                <input type="text" class="form-control @error('email') is-invalid @enderror"
                                       name="email" value="{{ old('email') }}" id="email">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label" for="password">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                   name="password" id="password" autocomplete="current-password">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="password-confirm">Password Confirmation</label>
                            <input type="password"
                                   class="form-control @error('password_confirmation') is-invalid @enderror"
                                   name="password_confirmation" id="password-confirm" autocomplete="current-password">
                            @error('password_confirmation')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <input type="hidden" name="id"
                               value="{{ @$investigator->id ?? '' }}">

                        <div class="mb-3">
                            <label class="form-label" for="role">Role</label>
                            <input type="text" disabled name="role" value="Investigator" class="form-control" id="role">
                        </div>

                        <button type="submit"
                                class="btn btn-primary">{{ @$investigator->id ? 'Update' : 'Submit' }}</button>
                        @if (@$investigator->id)
                            <a href="{{ route('company-admin.internal-investigators.reset-password', @$investigator->id) }}">
                                <button type="button" class="btn btn-primary">Reset Password</button>
                            </a>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
