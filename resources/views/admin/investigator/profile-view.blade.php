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
                                <a href="/admin/hr" class="text-white float-end">
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
                                <div class="col-md-6">{{ ucfirst($hrCompanyProfile->company_name) ?? 'N/A'}}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <b><label>Company Phone:</label></b>
                                </div>
                                <div class="col-md-6">{{$hrCompanyProfile->company_phone ?? 'N/A'}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="row mx-0 py-1 px-3">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <b><label>Address</label></b>
                                </div>
                                <div class="col-md-6">{{$hrCompanyProfile->address ?? 'N/A'}}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <b><label>Address 1:</label></b>
                                </div>
                                <div class="col-md-6">{{$hrCompanyProfile->address_1 ?? 'N/A'}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="row mx-0 py-1 px-3">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <b><label>City</label></b>
                                </div>
                                <div class="col-md-6">{{$hrCompanyProfile->city ?? 'N/A'}}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <b><label>State:</label></b>
                                </div>
                                <div class="col-md-6">{{$hrCompanyProfile->state ?? 'N/A'}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="row mx-0 py-1 px-3">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <b><label>Country</label></b>
                                </div>
                                <div class="col-md-6">{{$hrCompanyProfile->country ?? 'N/A'}}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <b><label> Zip Code :</label></b>
                                </div>
                                <div class="col-md-6">{{$hrCompanyProfile->zipcode ?? 'N/A'}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col">
                            <h5 class="">Contact</h5>
                        </div>
                    </div>
                    @forelse($hrCompanyContacts as $hrCompanyContact)
                        <div class="row mx-0 py-1 px-3">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <b><label>Conact Title</label></b>
                                    </div>
                                    <div class="col-md-6">{{ucfirst($hrCompanyContact->contact_title)}}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <b><label>Conact Name :</label></b>
                                    </div>
                                    <div class="col-md-6">{{ucfirst($hrCompanyContact->contact_name)}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="row mx-0 py-1 px-3">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <b><label>Conact Phone</label></b>
                                    </div>
                                    <div class="col-md-6">{{$hrCompanyContact->contact_phone}}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <b><label>Conact Email :</label></b>
                                    </div>
                                    <div class="col-md-6">{{$hrCompanyContact->contact_email}}</div>
                                </div>
                            </div>
                        </div>
                        @if(!$loop->last)
                            <hr>
                        @endif
                    @empty
                        <p class="text-center">Records not found!</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
