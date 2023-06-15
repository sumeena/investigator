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
                                    <b><label>Company Name:</label></b>
                                </div>
                                <div class="col-md-6">{{ ucfirst($CompanyAdminProfile->company_name) ?? 'N/A'}}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <b><label>Company Phone:</label></b>
                                </div>
                                <div class="col-md-6">{{$CompanyAdminProfile->company_phone ?? 'N/A'}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="row mx-0 py-1 px-3">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <b><label>Address</label></b>
                                </div>
                                <div class="col-md-6">{{$CompanyAdminProfile->address ?? 'N/A'}}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <b><label>Address 1:</label></b>
                                </div>
                                <div class="col-md-6">{{$CompanyAdminProfile->address_1 ?? 'N/A'}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="row mx-0 py-1 px-3">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <b><label>City</label></b>
                                </div>
                                <div class="col-md-6">{{$CompanyAdminProfile->city ?? 'N/A'}}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <b><label>State:</label></b>
                                </div>
                                <div class="col-md-6">{{$CompanyAdminProfile->state ?? 'N/A'}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="row mx-0 py-1 px-3">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <b><label>Country</label></b>
                                </div>
                                <div class="col-md-6">{{$CompanyAdminProfile->country ?? 'N/A'}}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <b><label> Zip Code :</label></b>
                                </div>
                                <div class="col-md-6">{{$CompanyAdminProfile->zipcode ?? 'N/A'}}</div>
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
                                    class="col-md-6">{{ $CompanyAdminProfile->timezone ? $CompanyAdminProfile->timezone->timezone . ' - [' . $CompanyAdminProfile->timezone->name . ']' : ''  }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
