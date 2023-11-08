@extends('layouts.dashboard')
@section('title', 'Company Profile')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                @if(session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="card profileData pb-4">
                    <!-- Profile start -->
                    <div class="row">
                        <div class="col">
                            <h5 class="">
                                Company Profile
                                <a href="{{ route('company-admin.profile') }}"
                                   class="btn btn-outline-primary btn-sm text-white float-end mt-n1">
                                    Edit Company Profile
                                </a>
                            </h5>
                        </div>
                    </div>
                    <div class="row mx-0 py-1 px-3">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <b><label>Company Name :</label></b>
                                </div>
                                @php
                                    @$companyName = $CompanyAdminProfile->company_name ?? $parentProfile->company_name;
                                @endphp
                                <div
                                    class="col-md-6">{{ ucfirst($companyName) ?? 'N/A' }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <b><label>Company Phone :</label></b>
                                </div>
                                <div
                                    class="col-md-6">{{ @$CompanyAdminProfile->company_phone ?? $parentProfile->company_phone ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="row mx-0 py-1 px-3">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <b><label>Address :</label></b>
                                </div>
                                <div
                                    class="col-md-6">{{ $CompanyAdminProfile->address ?? $parentProfile->address ?? 'N/A' }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <b><label>Address 1 :</label></b>
                                </div>
                                <div
                                    class="col-md-6">{{ $CompanyAdminProfile->address_1 ?? $parentProfile->address_1 ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="row mx-0 py-1 px-3">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <b><label>City :</label></b>
                                </div>
                                <div
                                    class="col-md-6">{{ $CompanyAdminProfile->city ?? $parentProfile->city ?? 'N/A' }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <b><label>State :</label></b>
                                </div>
                                <div
                                    class="col-md-6">{{ $CompanyAdminProfile->state ?? $parentProfile->company_phone ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="row mx-0 py-1 px-3">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <b><label>Country :</label></b>
                                </div>
                                <div
                                    class="col-md-6">{{ $CompanyAdminProfile->country ?? $parentProfile->country ?? 'N/A' }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <b><label> Zip Code :</label></b>
                                </div>
                                <div
                                    class="col-md-6">{{ $CompanyAdminProfile->zipcode ?? $parentProfile->zipcode ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="row mx-0 py-1 px-3">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <b><label> Timezone :</label></b>
                                </div>
                                @php
                                    @$timezone = $CompanyAdminProfile->timezone ?? $parentProfile->timezone;
                                @endphp
                                <div
                                    class="col-md-6">{{ $timezone ? $timezone->timezone . ' - [' . $timezone->name . ']' : '' }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <b><label> Website :</label></b>
                                </div>
                                <div
                                    class="col-md-6">{{ $user?->website ?? $user?->companyAdmin?->company?->website ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="row mx-0 py-1 px-3">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <b><label> Make Assignments Private :</label></b>
                                </div>
                                @php
                                    @$makeAssignmentsPrivate = $CompanyAdminProfile->make_assignments_private ?? $parentProfile->make_assignments_private;
                                @endphp
                                <div
                                    class="col-md-6">{{ $makeAssignmentsPrivate == 0 ? 'No' : 'Yes' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection