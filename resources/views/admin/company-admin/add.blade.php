@extends('layouts.dashboard')
@section('title', 'Company Admin')
@section('content')
    <div class="row mt-4 mb-4">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ isset($companyAdmin) && !empty($companyAdmin->id) ? 'Edit' : 'Add' }} Company
                        Admin</h5>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('admin.company-admins.submit') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">First Name</label>
                            <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ isset($companyAdmin) && !empty($companyAdmin->first_name) ? $companyAdmin->first_name : old('first_name') }}">
                            @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-company">Last Name</label>
                            <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ isset($companyAdmin) && !empty($companyAdmin->last_name) ? $companyAdmin->last_name : old('last_name') }}">
                            @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        @if (isset($companyAdmin) && $companyAdmin->email)
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-email">Email</label>
                                <div class="input-group input-group-merge">
                                    <input type="text" class="form-control" value="{{ $companyAdmin->email }}" disabled>
                                    <input type="hidden" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $companyAdmin->email }}">
                                </div>
                            </div>
                        @else
                            <div class="mb-3">
                                <label class="form-label" for="email">Email</label>
                                <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" id="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        @endif
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-company">Phone</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ isset($companyAdmin) && !empty($companyAdmin->phone) ? $companyAdmin->phone : old('phone') }}">
                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <input type="hidden" name="id" value="{{ isset($companyAdmin) && !empty($companyAdmin) ? $companyAdmin->id : '' }}">
                        <div class="mb-2">
                            @if (isset($companyAdmin) && !empty($companyAdmin->id))
                                <label class="form-label" for="basic-default-message">Company Admin</label>
                                @if (!empty($companyAdmin?->parentCompany))
                                    <input type="text" class="form-control" value="{{ $companyAdmin?->parentCompany->company->first_name . ' ' . $companyAdmin?->parentCompany->company->last_name . ' -- ' . $companyAdmin?->parentCompany->company?->website }}" disabled>
                                    <input type="hidden" class="form-control" name="company_admin" value="{{ $companyAdmin?->parentCompany?->company?->id }}">
                                @else
                                    <input type="text" class="form-control" value="{{ $companyAdmin?->first_name . ' ' . $companyAdmin?->last_name . ' -- ' . $companyAdmin?->website }}" disabled>
                                    <input type="hidden" class="form-control" name="company_admin" value="{{ $companyAdmin?->id }}">
                                @endif
                            @else
                                <label class="form-label" for="basic-default-message">Select Company Admin</label>
                                <select id="defaultSelect" class="form-select " name="company_admin">
                                    <option value="">Enter New Company</option>
                                    @foreach ($companyAdmins as $companyadmin)
                                        <option value="{{ $companyadmin->id }}">{{ $companyadmin->first_name }} {{ $companyadmin->first_name }} -- {{ $companyadmin->website }}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>
                        <div class="mb-3 {{ isset($companyAdmin) && !empty($companyAdmin->id) ? 'd-none' : '' }}" id="newCompanyLink">
                            <label class="form-label" for="basic-default-message">Company Link</label>
                            <div class="row">
                                <div class="col-md-2">
                                    <select class="form-control" name="pre_link">
                                        <option value="http://">http://</option>
                                        <option value="https://">https://</option>
                                    </select>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" name="website" class="form-control">
                                    @error('website')
                                        <span class="text-danger" role="alert" style="font-size: 12px;">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            @error('website')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-message">Role</label>
                            <input type="text" class="form-control" value="Company Admin" disabled>
                            <input type="hidden" name="role" value="2">
                        </div>
                        <button type="submit" class="btn btn-primary">{{ isset($companyAdmin) && !empty($companyAdmin->id) ? 'Update' : 'Submit' }}</button>
                        @if (isset($companyAdmin) && $companyAdmin->id)
                            <a href="{{ route('admin.company-admins.reset-password', $companyAdmin->id) }}">
                                <button type="button" class="btn btn-primary">Reset Password</button>
                            </a>
                        @endif
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-1"></div>
        <style>

        </style>
    </div>

@endsection
