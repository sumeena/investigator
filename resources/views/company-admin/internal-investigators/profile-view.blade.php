@extends('layouts.dashboard')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card profileData pb-4">
                    <!-- Profile start -->
                    <div class="row">
                        <div class="col">
                            <h5 class="">
                                Company Profile
                                <a href="{{ route('admin.company-admins.index') }}" class="text-white float-end">
                                    Back
                                </a>
                            </h5>
                        </div>
                    </div>
                    <div class="row mx-0 py-1 px-3">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <b><label>Company Name:</label></b>
                                </div>
                                <div class="col-md-6">{{ ucfirst($companyAdminProfile->company_name) ?? 'N/A'}}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <b><label>Company Phone:</label></b>
                                </div>
                                <div class="col-md-6">{{$companyAdminProfile->company_phone ?? 'N/A'}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="row mx-0 py-1 px-3">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <b><label>Address</label></b>
                                </div>
                                <div class="col-md-6">{{$companyAdminProfile->address ?? 'N/A'}}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <b><label>Address 1:</label></b>
                                </div>
                                <div class="col-md-6">{{$companyAdminProfile->address_1 ?? 'N/A'}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="row mx-0 py-1 px-3">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <b><label>City</label></b>
                                </div>
                                <div class="col-md-6">{{$companyAdminProfile->city ?? 'N/A'}}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <b><label>State:</label></b>
                                </div>
                                <div class="col-md-6">{{ $companyAdminProfile->state ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="row mx-0 py-1 px-3">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <b><label>Country</label></b>
                                </div>
                                <div class="col-md-6">{{ $companyAdminProfile->country ?? 'N/A' }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <b><label> Zip Code :</label></b>
                                </div>
                                <div class="col-md-6">{{ $companyAdminProfile->zipcode ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="row mx-0 py-1 px-3">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <b><label> Timezone :</label></b>
                                </div>
                                <div
                                    class="col-md-6">{{ $companyAdminProfile->timezone ? $companyAdminProfile->timezone->timezone . ' - [' . $companyAdminProfile->timezone->name . ']' : ''  }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
