@extends('layouts.dashboard')
@section('title', "Investigator's Profile")
@section('content')
    <div class="row mt-4 mb-4 mx-0 justify-content-center">
        <div class="col-md-10">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Investigator's Profile</h5>
                    @if(!$googleAuthDeatils)
                    <button type="button" data-toggle="modal" data-target="#sync-calendar" class="float-end btn btn-outline-primary btn-sm mt-n1 mr-10">Sync Calendar</button>
                    @else
                    <button type="button" data-toggle="modal" data-target="#disconnect-calendar" class="float-end btn btn-outline-primary btn-sm mt-n1 mr-10">Disconnect Calendar</button>
                    @endif
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                    <form method="post" action="{{ route('investigator.profile.submit') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-fullname">First Name</label>
                                    <input type="text" class="form-control" name="first_name"
                                           value="{{isset($user->first_name) ? $user->first_name:'' }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-company">Last Name</label>
                                    <input type="text" class="form-control" name="last_name"
                                           value="{{ $user->last_name }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-email">Email</label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" class="form-control" name="email"
                                               value="{{$user->email}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-email">Phone Number <span
                                            class="starrequired">*</span></label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                               name="phone"
                                               value="{{isset($user->phone) ? $user->phone : old('phone')}}">
                                    </div>
                                    @error('phone')
                                    <span role="alert">
                                       <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-fullname">Address <span
                                            class="starrequired">*</span></label>
                                    <input type="text" id="autocomplete"
                                           class="form-control @error('address') is-invalid @enderror"
                                           name="address"
                                           value="{{isset($user->address) ? $user->address : old('address')}}">
                                </div>
                                @error('address')
                                <span role="alert" class="text-danger small">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-company">Address 1</label>
                                    <input type="text" class="form-control" name="address_1"
                                           value="{{isset($user->address_1) ? $user->address_1 : old('address_1')}}">
                                </div>
                                <input type="hidden" id="street_number">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-email">City <span class="starrequired">*</span></label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" id="locality"
                                               class="form-control @error('city') is-invalid @enderror"
                                               name="city"
                                               value="{{isset($user->city) ? $user->city : old('city')}}">
                                    </div>
                                    @error('city')
                                    <span role="alert" class="text-danger small">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-email">State <span
                                            class="starrequired">*</span></label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" id="administrative_area_level_1"
                                               class="form-control @error('state') is-invalid @enderror"
                                               name="state"
                                               value="{{isset($user->state) ? $user->state : old('state')}}">
                                    </div>
                                </div>
                                @error('state')
                                <span role="alert" class="text-danger small">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-email">Country <span
                                            class="starrequired">*</span></label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" id="country"
                                               class="form-control @error('country') is-invalid @enderror"
                                               name="country"
                                               value="{{isset($user->country) ? $user->country : old('country')}}">
                                        <!-- <select id="defaultSelect"
                                                class="form-control @error('country') is-invalid @enderror"
                                                name="country">
                                            <option selected="selected" value="1">USA</option>
                                        </select> -->
                                    </div>
                                </div>
                                @error('country')
                                <span role="alert" class="text-danger small">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-email">Zip Code <span
                                            class="starrequired">*</span></label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" id="postal_code"
                                               class="form-control @error('zipcode') is-invalid @enderror"
                                               name="zipcode"
                                               value="{{isset($user->zipcode) ? $user->zipcode : old('zipcode')}}">
                                    </div>
                                    @error('zipcode')
                                    <span role="alert" class="text-danger small">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <input type="hidden" id="lat" name="lat" value="{{ old('lat', $user->lat) }}">
                            <input type="hidden" id="lng" name="lng" value="{{ old('lng', $user->lng) }}">
                        </div>


                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-email">Your Bio</label>
                                    <div class="">
                                        <textarea id="bio" maxlength="1000" class="form-control @error('bio') is-invalid @enderror" name="bio" value="{{isset($user->bio) ? $user->bio : old('bio')}}"></textarea>
                                        <div id="the-count">
                                            <small>
                                        <span id="current">0</span>
                                        <span id="maximum">/ 1000</span></small>
                                    </div>
                                        <!-- <select id="defaultSelect"
                                                class="form-control @error('country') is-invalid @enderror"
                                                name="country">
                                            <option selected="selected" value="1">USA</option>
                                        </select> -->
                                    </div>
                                </div>
                                @error('bio')
                                <span role="alert" class="text-danger small">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <hr>
                        <div class="mb-3">
                            <div class="card">
                                <h5 class="card-header">Service Lines <span class="starrequired">*</span></h5>
                                @error('investigation_type')
                                <p class="ms-4 text-danger">{{ $message }}</p>
                                @enderror
                                <div class="table-responsive text-nowrap">
                                    <table class="table">
                                        <thead>
                                        <tr class="text-nowrap">
                                            <th>Investigation Types</th>
                                            <th>Case Experience</th>
                                            <th>Years Experience</th>
                                            <th>Contractor Hourly Rate</th>
                                            <th>Contractor Travel Rate</th>
                                            <th>Contractor Milage Rate</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>
                                                Surveillance
                                                <input class="form-check-input"
                                                       type="checkbox"
                                                       value="surveillance"
                                                       name="investigation_type[0][type]"
                                                    @checked(($survServiceLine && $survServiceLine->investigation_type == 'surveillance') || old('investigation_type.0.type') == 'surveillance')>
                                            </td>
                                            <td>
                                                <select
                                                    class="form-select @error('investigation_type.0.case_experience') is-invalid @enderror"
                                                    name="investigation_type[0][case_experience]">
                                                    <option value="">--select--</option>
                                                    <option
                                                        value="1" @selected($survServiceLine && $survServiceLine->case_experience == 1 || old('investigation_type.0.case_experience') == 1)>
                                                        Under 50
                                                    </option>
                                                    <option
                                                        value="2" @selected($survServiceLine && $survServiceLine->case_experience == 2 || old('investigation_type.0.case_experience') == 2)>
                                                        50-499
                                                    </option>
                                                    <option
                                                        value="3" @selected($survServiceLine && $survServiceLine->case_experience == 3 || old('investigation_type.0.case_experience') == 3)>
                                                        500+
                                                    </option>
                                                </select>
                                                @error('investigation_type.0.case_experience')
                                                <span role="alert" class="text-danger small">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </td>
                                            <td>
                                                <input type="text"
                                                       class="form-control @error('investigation_type.0.years_experience') is-invalid @enderror"
                                                       name="investigation_type[0][years_experience]"
                                                       value="{{ old('investigation_type.0.years_experience', $survServiceLine->years_experience ?? '') }}">
                                                @error('investigation_type.0.years_experience')
                                                <span role="alert" class="text-danger small">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </td>
                                            <td>
                                                <span class="investigation_span">$</span>
                                                <input type="text"
                                                       class="form-control @error('investigation_type.0.hourly_rate') is-invalid @enderror investigation_input_dollar_sign"
                                                       name="investigation_type[0][hourly_rate]"
                                                       value="{{ old('investigation_type.0.hourly_rate', $survServiceLine->hourly_rate ?? '') }}">
                                                @error('investigation_type.0.hourly_rate')
                                                <span role="alert" class="text-danger small">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </td>
                                            <td>
                                                <span class="investigation_span">$</span>
                                                <input type="text"
                                                       class="form-control @error('investigation_type.0.travel_rate') is-invalid @enderror investigation_input_dollar_sign"
                                                       name="investigation_type[0][travel_rate]"
                                                       value="{{ old('investigation_type.0.travel_rate', $survServiceLine->travel_rate ?? '') }}">
                                                @error('investigation_type.0.travel_rate')
                                                <span role="alert" class="text-danger small">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </td>
                                            <td>
                                                <span class="investigation_span">$</span>
                                                <input type="text"
                                                       class="form-control @error('investigation_type.0.milage_rate') is-invalid @enderror investigation_input_dollar_sign"
                                                       name="investigation_type[0][milage_rate]"
                                                       value="{{ old('investigation_type.0.milage_rate', $survServiceLine->milage_rate ?? '') }}">
                                                @error('investigation_type.0.milage_rate')
                                                <span role="alert" class="text-danger small">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Statements
                                                <input class="form-check-input" type="checkbox"
                                                       value="statements"
                                                       name="investigation_type[1][type]"
                                                    @checked($statServiceLine && $statServiceLine->investigation_type == 'statements' || old('investigation_type.1.type') == 'statements')>
                                            </td>
                                            <td>
                                                <select
                                                    class="form-select @error('investigation_type.1.case_experience') is-invalid @enderror"
                                                    name="investigation_type[1][case_experience]">
                                                    <option value="">--select--</option>
                                                    <option
                                                        value="1" @selected($statServiceLine && $statServiceLine->case_experience == 1 || old('investigation_type.1.case_experience') == 1)>
                                                        Under 50
                                                    </option>
                                                    <option
                                                        value="2" @selected($statServiceLine && $statServiceLine->case_experience == 2 || old('investigation_type.1.case_experience') == 2)>
                                                        50-499
                                                    </option>
                                                    <option
                                                        value="3" @selected($statServiceLine && $statServiceLine->case_experience == 3 || old('investigation_type.1.case_experience') == 3)>
                                                        500+
                                                    </option>
                                                </select>
                                                @error('investigation_type.1.case_experience')
                                                <span role="alert" class="text-danger small">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </td>
                                            <td>
                                                <input type="text"
                                                       class="form-control @error('investigation_type.1.years_experience') is-invalid @enderror"
                                                       name="investigation_type[1][years_experience]"
                                                       value="{{ old('investigation_type.1.years_experience', $statServiceLine->years_experience ?? '') }}">
                                                @error('investigation_type.1.years_experience')
                                                <span role="alert" class="text-danger small">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </td>
                                            <td>
                                                <span class="investigation_span">$</span>
                                                <input type="text"
                                                       class="form-control @error('investigation_type.1.hourly_rate') is-invalid @enderror investigation_input_dollar_sign"
                                                       name="investigation_type[1][hourly_rate]"
                                                       value="{{ old('investigation_type.1.hourly_rate', $statServiceLine->hourly_rate ?? '') }}">
                                                @error('investigation_type.1.hourly_rate')
                                                <span role="alert" class="text-danger small">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </td>
                                            <td>
                                                <span class="investigation_span">$</span>
                                                <input type="text"
                                                       class="form-control @error('investigation_type.1.travel_rate') is-invalid @enderror investigation_input_dollar_sign"
                                                       name="investigation_type[1][travel_rate]"
                                                       value="{{ old('investigation_type.1.travel_rate', $statServiceLine->travel_rate ?? '') }}">
                                                @error('investigation_type.1.travel_rate')
                                                <span role="alert" class="text-danger small">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </td>
                                            <td>
                                                <span class="investigation_span">$</span>
                                                <input type="text"
                                                       class="form-control @error('investigation_type.1.milage_rate') is-invalid @enderror investigation_input_dollar_sign"
                                                       name="investigation_type[1][milage_rate]"
                                                       value="{{ old('investigation_type.1.milage_rate', $statServiceLine->milage_rate ?? '') }}">
                                                @error('investigation_type.1.milage_rate')
                                                <span role="alert" class="text-danger small">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Misc
                                                <input class="form-check-input" type="checkbox" value="misc"
                                                       name="investigation_type[2][type]" @checked($miscServiceLine && $miscServiceLine->investigation_type == 'misc' || old('investigation_type.2.type') == 'misc')>
                                            </td>
                                            <td>
                                                <select
                                                    class="form-select @error('investigation_type.2.case_experience') is-invalid @enderror"
                                                    name="investigation_type[2][case_experience]">
                                                    <option value="">--select--</option>
                                                    <option
                                                        value="1" @selected($miscServiceLine && $miscServiceLine->case_experience == 1 || old('investigation_type.2.case_experience') == 1)>
                                                        Under 50
                                                    </option>
                                                    <option
                                                        value="2" @selected($miscServiceLine && $miscServiceLine->case_experience == 2 || old('investigation_type.2.case_experience') == 2)>
                                                        50-499
                                                    </option>
                                                    <option
                                                        value="3" @selected($miscServiceLine && $miscServiceLine->case_experience == 3 || old('investigation_type.2.case_experience') == 3)>
                                                        500+
                                                    </option>
                                                </select>
                                                @error('investigation_type.2.case_experience')
                                                <span role="alert" class="text-danger small">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </td>
                                            <td>
                                                <input type="text"
                                                       class="form-control @error('investigation_type.2.years_experience') is-invalid @enderror"
                                                       name="investigation_type[2][years_experience]"
                                                       value="{{ old('investigation_type.2.years_experience', $miscServiceLine->years_experience ?? '') }}">
                                                @error('investigation_type.2.years_experience')
                                                <span role="alert" class="text-danger small">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </td>
                                            <td>
                                                <span class="investigation_span">$</span>
                                                <input type="text"
                                                       class="form-control @error('investigation_type.2.hourly_rate') is-invalid @enderror investigation_input_dollar_sign"
                                                       name="investigation_type[2][hourly_rate]"
                                                       value="{{ old('investigation_type.2.hourly_rate', $miscServiceLine->hourly_rate ?? '') }}">
                                                @error('investigation_type.2.hourly_rate')
                                                <span role="alert" class="text-danger small">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </td>
                                            <td>
                                                <span class="investigation_span">$</span>
                                                <input type="text"
                                                       class="form-control @error('investigation_type.2.travel_rate') is-invalid @enderror investigation_input_dollar_sign"
                                                       name="investigation_type[2][travel_rate]"
                                                       value="{{ old('investigation_type.2.travel_rate', $miscServiceLine->travel_rate ?? '') }}">
                                                @error('investigation_type.2.travel_rate')
                                                <span role="alert" class="text-danger small">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </td>
                                            <td>
                                                <span class="investigation_span">$</span>
                                                <input type="text"
                                                       class="form-control @error('investigation_type.2.milage_rate') is-invalid @enderror investigation_input_dollar_sign"
                                                       name="investigation_type[2][milage_rate]"
                                                       value="{{ old('investigation_type.2.milage_rate', $miscServiceLine->milage_rate ?? '') }}">
                                                @error('investigation_type.2.milage_rate')
                                                <span role="alert" class="text-danger small">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="mb-3">
                            <div class="card">
                                <!-- <h5 class="card-header">Ratings & Reviews</h5> -->
                                <div class="table-responsive text-nowrap">
                                    <table class="table">
                                        <thead>
                                        <tr class="text-nowrap">
                                            <th>Video Capture Rate <span class="starrequired">*</span></th>
                                            <th>Upload a survelance report writing Sample</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>
                                                <span class="investigation_span">%</span><input type="text"
                                                                                                class="form-control investigation_input_dollar_sign @error('video_claimant_percentage') is-invalid @enderror"
                                                                                                name="video_claimant_percentage"
                                                                                                value="{{ old('video_claimant_percentage', $review->video_claimant_percentage ?? '') }}">
                                                @error('video_claimant_percentage')
                                                <span role="alert" class="text-danger small">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </td>
                                            <td>
                                                <input
                                                    class="form-control investigator_profile_document_form_19 @error('survelance_report') is-invalid @enderror"
                                                    type="file" name="survelance_report">
                                                @error('survelance_report')
                                                <span role="alert" class="text-danger small">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </td>
                                            @if($review && $review->survelance_report)
                                                <td>
                                                    <a class="btn btn-outline-info"
                                                       href="{{ Storage::disk('public')->url($review->survelance_report) }}"
                                                       target="_blank">
                                                        View File
                                                    </a>
                                                </td>
                                            @endif
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="mb-3">
                            <div class="card">
                                <h5 class="card-header">Equipment <span class="starrequired">*</span></h5>
                                <div class="table-responsive text-nowrap">
                                    <table class="table">
                                        <thead>
                                        <tr class="text-nowrap">
                                            <th>Camera Type <span class="starrequired">*</span></th>
                                            <th>Camera Model Number <span class="starrequired">*</span></th>
                                            <th>Dashcam</th>
                                            <th>Convert Video</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>
                                                <input type="text"
                                                       class="form-control @error('camera_type') is-invalid @enderror"
                                                       name="camera_type"
                                                       value="{{ old('camera_type', $equipment->camera_type ?? '') }}">
                                                @error('camera_type')
                                                <span role="alert" class="text-danger small">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                            </td>
                                            <td>
                                                <input type="text"
                                                       class="form-control @error('camera_model_number') is-invalid @enderror"
                                                       name="camera_model_number"
                                                       value="{{ old('camera_model_number', $equipment->camera_model ?? '') }}">
                                                @error('camera_model_number')
                                                <span role="alert" class="text-danger small">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </td>
                                            <td>
                                                <input class="form-check-input" type="checkbox" value="1"
                                                       name="dashcam"
                                                    @checked(old('dashcam', $equipment && $equipment->is_dash_cam))>
                                            </td>
                                            <td>
                                                <input class="form-check-input" type="checkbox" value="1"
                                                       name="convert_video"
                                                    @checked(old('convert_video', $equipment && $equipment->is_convert_video))>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="mb-3">
                            <div class="card">
                                <h5 class="card-header">Licensing <span class="starrequired">*</span></h5>
                                <div class="table-responsive text-nowrap">
                                    <table class="table licensing">
                                        <thead>
                                        <tr class="text-nowrap">
                                            <th>State <span class="starrequired">*</span></th>
                                            <th>License Number <span class="starrequired">*</span></th>
                                            <th>Expiration date <span class="starrequired">*</span></th>
                                            <th>Insurance</th>
                                            <th class="td-upload-insurance-file">Upload Insurance File</th>
                                            <th>Bonded</th>
                                            <th class="td-upload-bounded-file">Upload Bounded File</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                            $licenseOldData = [
                                                    [
                                                        'state' => null,
                                                        'license_number' => null,
                                                        'expiration_date' => null,
                                                        'is_insurance' => null,
                                                        'insurance_file' => null,
                                                        'is_bonded' => null,
                                                        'bonded_file' => null,
                                                    ]
                                                ];
                                            $licensesData = $licenses->toArray();
                                            $licenseOldData = $licenses->count() ? $licenses->toArray() : $licenseOldData;
                                            $oldLicenseData = old('licenses', $licenseOldData);
                                        @endphp
                                        @if(count($oldLicenseData))
                                            @foreach($oldLicenseData as $licenseKey => $license)
                                                <tr>
                                                    <td>
                                                        <select
                                                            class="form-select investigator_profile_state @error('licenses.'.$licenseKey.'.state') is-invalid @enderror"
                                                            name="licenses[{{ $licenseKey }}][state]">
                                                            <option value="">--select--</option>
                                                            @foreach($states as $state)
                                                                <option
                                                                    value="{{ $state->id }}" @selected(old('licenses.'.$licenseKey.'.state', $license['state']) == $state->id)>
                                                                    {{ $state->code }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('licenses.'.$licenseKey.'.state')
                                                        <span role="alert" class="text-danger small">
                                                        {{ $message }}
                                                    </span>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <input type="text"
                                                               class="form-control @error('licenses.'.$licenseKey.'.license_number') is-invalid @enderror"
                                                               name="licenses[{{ $licenseKey }}][license_number]"
                                                               value="{{ old('licenses.'.$licenseKey.'.license_number', $license['license_number']) }}">
                                                        @error('licenses.'.$licenseKey.'.license_number')
                                                        <span role="alert" class="text-danger small">
                                                        {{ $message }}
                                                    </span>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <input
                                                            class="form-control @error('licenses.'.$licenseKey.'.expiration_date') is-invalid @enderror"
                                                            type="date"
                                                            name="licenses[{{ $licenseKey }}][expiration_date]"
                                                            value="{{ old('licenses.'.$licenseKey.'.expiration_date', $license['expiration_date']) }}">
                                                        @error('licenses.'.$licenseKey.'.expiration_date')
                                                        <span role="alert" class="text-danger small">
                                                        {{ $message }}
                                                    </span>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <input class="form-check-input dl-insurance"
                                                               type="checkbox" value="1"
                                                               name="licenses[{{ $licenseKey }}][is_insurance]"
                                                               data-license-index="{{ $licenseKey }}"
                                                               @if(array_key_exists('is_insurance', $license) && $license['is_insurance']) checked @endif>
                                                    </td>
                                                    <td class="upload-insurance-file"
                                                        data-license-index="{{ $licenseKey }}">
                                                        @if(isset($license['insurance_file']))
                                                            <input type="hidden"
                                                                   name="licenses[{{ $licenseKey }}][insurance_previous]"
                                                                   value="{{ isset($license['insurance_file']) ? 1 : 0 }}">
                                                        @endif

                                                        @if(!isset($license['insurance_file']) && isset($licensesData[$licenseKey]['insurance_file']))
                                                            <input type="hidden"
                                                                   name="licenses[{{ $licenseKey }}][insurance_previous]"
                                                                   value="{{ isset($licensesData[$licenseKey]['insurance_file']) ? 1 : 0 }}">
                                                        @endif

                                                        <input accept=".png, .jpg, .jpeg"
                                                               class="form-control investigator_insurance_picture
                                                         @error('licenses.'.$licenseKey.'.insurance_file') is-invalid @enderror"
                                                               type="file"
                                                               name="licenses[{{ $licenseKey }}][insurance_file]">
                                                        @if(isset($license['insurance_file']))
                                                            <a href="{{ Storage::disk('public')->url($license['insurance_file']) }}"
                                                               target="_blank">
                                                                View Insurance
                                                            </a>
                                                        @endif
                                                        @error('licenses.'.$licenseKey.'.insurance_file')
                                                        <span role="alert" class="text-danger small">
                                                        {{ $message }}
                                                    </span>
                                                        @enderror

                                                    </td>
                                                    <td>
                                                        <input class="form-check-input dl-bounded" type="checkbox"
                                                               value="1"
                                                               data-license-index="{{ $licenseKey }}"
                                                               name="licenses[{{ $licenseKey }}][is_bonded]"
                                                               @if(array_key_exists('is_bonded', $license) && $license['is_bonded']) checked @endif>
                                                    </td>
                                                    <td class="upload-bounded-file"
                                                        data-license-index="{{ $licenseKey }}">
                                                        @if(isset($license['bonded_file']))
                                                            <input type="hidden"
                                                                   name="licenses[{{ $licenseKey }}][bonded_previous]"
                                                                   value="{{ isset($license['bonded_file']) ? 1 : 0 }}">
                                                        @endif

                                                        @if(!isset($license['bonded_file']) && isset($licensesData[$licenseKey]['bonded_file']))
                                                            <input type="hidden"
                                                                   name="licenses[{{ $licenseKey }}][bonded_previous]"
                                                                   value="{{ isset($licensesData[$licenseKey]['bonded_file']) ? 1 : 0 }}">
                                                        @endif
                                                        <input
                                                            class="form-control investigator_bonded_picture
                                                    @error('licenses.'.$licenseKey.'.bonded_file') is-invalid @enderror"
                                                            type="file" accept=".png, .jpg, .jpeg"
                                                            name="licenses[{{ $licenseKey }}][bonded_file]">
                                                        @if(isset($license['bonded_file']))
                                                            <a href="{{ Storage::disk('public')->url($license['bonded_file']) }}"
                                                               target="_blank">
                                                                View Bonded
                                                            </a>
                                                        @endif
                                                        @error('licenses.'.$licenseKey.'.bonded_file')
                                                        <span role="alert" class="text-danger small">
                                                        {{ $message }}
                                                    </span>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        @if($licenseKey == 0)
                                                            <button type="button" class="btn btn-primary licensing_row">
                                                                Add+
                                                            </button>
                                                        @else
                                                            <button type="button"
                                                                    class="btn btn-primary licensing_row_remove">
                                                                Remove
                                                            </button>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="mb-3">
                            <div class="card">
                                <h5 class="card-header">Work Vehicle <span class="starrequired">*</span></h5>
                                <div class="table-responsive text-nowrap">
                                    <table class="table workvehicle">
                                        <thead>
                                        <tr class="text-nowrap">
                                            <th>Year <span class="starrequired">*</span></th>
                                            <th>Make <span class="starrequired">*</span></th>
                                            <th>Model <span class="starrequired">*</span></th>
                                            <th>Insurance Company Name <span class="starrequired">*</span></th>
                                            <th>Policy Number <span class="starrequired">*</span></th>
                                            <th>Expiration Date <span class="starrequired">*</span></th>
                                            <th>Picture</th>
                                            <th>Upload Proof of Insurance</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                            $workVehicleOldData = [
                                                    [
                                                        'year' => null,
                                                        'make' => null,
                                                        'model' => null,
                                                        'picture' => null,
                                                        'insurance_company' => null,
                                                        'policy_number' => null,
                                                        'expiration_date' => null,
                                                        'proof_of_insurance' => null,
                                                    ]
                                                ];
                                            $workVehicleOldData = $workVehicles->count() ? $workVehicles->toArray() : $workVehicleOldData;
                                            $oldWorkVehicleData = old('work_vehicles', $workVehicleOldData);
                                        @endphp
                                        @if(count($oldWorkVehicleData))
                                            @foreach($oldWorkVehicleData as $workVehicleKey => $workVehicle)
                                                <tr>
                                                    <td>
                                                        <input type="text"
                                                               class="form-control investigator_profile_vechile_year @error('work_vehicles.'.$workVehicleKey.'.year') is-invalid @enderror"
                                                               name="work_vehicles[{{ $workVehicleKey }}][year]"
                                                               value="{{ old('work_vehicles.'.$workVehicleKey.'.year', $workVehicle['year']) }}">
                                                        @error('work_vehicles.'.$workVehicleKey.'.year')
                                                        <span role="alert" class="text-danger small">
                                                        {{ $message }}
                                                    </span>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <input type="text"
                                                               class="form-control investigator_profile_vechile_make @error('work_vehicles.'.$workVehicleKey.'.make') is-invalid @enderror"
                                                               name="work_vehicles[{{ $workVehicleKey }}][make]"
                                                               value="{{ old('work_vehicles.'.$workVehicleKey.'.make', $workVehicle['make']) }}">
                                                        @error('work_vehicles.'.$workVehicleKey.'.make')
                                                        <span role="alert" class="text-danger small">
                                                        {{ $message }}
                                                    </span>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <input
                                                            class="form-control investigator_profile_vechile_model @error('work_vehicles.'.$workVehicleKey.'.model') is-invalid @enderror"
                                                            type="text"
                                                            name="work_vehicles[{{ $workVehicleKey }}][model]"
                                                            value="{{ old('work_vehicles.'.$workVehicleKey.'.model', $workVehicle['model']) }}">
                                                        @error('work_vehicles.'.$workVehicleKey.'.model')
                                                        <span role="alert" class="text-danger small">
                                                        {{ $message }}
                                                    </span>
                                                        @enderror
                                                    </td>

                                                    <td>
                                                        <input
                                                            class="form-control @error('work_vehicles.'.$workVehicleKey.'.insurance_company') is-invalid @enderror"
                                                            type="text"
                                                            name="work_vehicles[{{ $workVehicleKey }}][insurance_company]"
                                                            value="{{ old('work_vehicles.'.$workVehicleKey.'.insurance_company', $workVehicle['insurance_company']) }}">
                                                        @error('work_vehicles.'.$workVehicleKey.'.insurance_company')
                                                        <span role="alert" class="text-danger small">
                                                        {{ $message }}
                                                    </span>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <input
                                                            class="form-control @error('work_vehicles.'.$workVehicleKey.'.policy_number') is-invalid @enderror"
                                                            type="text"
                                                            name="work_vehicles[{{ $workVehicleKey }}][policy_number]"
                                                            value="{{ old('work_vehicles.'.$workVehicleKey.'.policy_number', $workVehicle['policy_number']) }}">
                                                        @error('work_vehicles.'.$workVehicleKey.'.policy_number')
                                                        <span role="alert" class="text-danger small">
                                                        {{ $message }}
                                                    </span>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <input
                                                            class="form-control @error('work_vehicles.'.$workVehicleKey.'.expiration_date') is-invalid @enderror"
                                                            type="date"
                                                            name="work_vehicles[{{ $workVehicleKey }}][expiration_date]"
                                                            value="{{ old('work_vehicles.'.$workVehicleKey.'.expiration_date', $workVehicle['expiration_date']) }}">
                                                        @error('work_vehicles.'.$workVehicleKey.'.expiration_date')
                                                        <span role="alert" class="text-danger small">
                                                        {{ $message }}
                                                    </span>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <input
                                                            class="form-control investigator_profile_picture @error('work_vehicles.'.$workVehicleKey.'.picture') is-invalid @enderror"
                                                            type="file"
                                                            name="work_vehicles[{{ $workVehicleKey }}][picture]">
                                                        @if(isset($workVehicle['picture']))
                                                            <a href="{{ Storage::disk('public')->url($workVehicle['picture']) }}"
                                                               target="_blank">
                                                                View Picture
                                                            </a>
                                                        @endif
                                                        @error('work_vehicles.'.$workVehicleKey.'.picture')
                                                        <span role="alert" class="text-danger small">
                                                        {{ $message }}
                                                    </span>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <input
                                                            class="form-control investigator_profile_proof_of_insurance @error('work_vehicles.'.$workVehicleKey.'.proof_of_insurance') is-invalid @enderror"
                                                            type="file"
                                                            name="work_vehicles[{{ $workVehicleKey }}][proof_of_insurance]">
                                                        @if(isset($workVehicle['proof_of_insurance']))
                                                            <a href="{{ Storage::disk('public')->url($workVehicle['proof_of_insurance']) }}"
                                                               target="_blank">
                                                                View Proof Of Insurance
                                                            </a>
                                                        @endif
                                                        @error('work_vehicles.'.$workVehicleKey.'.proof_of_insurance')
                                                        <span role="alert" class="text-danger small">
                                                        {{ $message }}
                                                    </span>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        @if($workVehicleKey == 0)
                                                            <button type="button"
                                                                    class="btn btn-primary workvehicle_row">
                                                                Add+
                                                            </button>
                                                        @else
                                                            <button type="button"
                                                                    class="btn btn-primary workvehicle_row_remove">
                                                                Remove
                                                            </button>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="mb-3">
                            <div class="card">
                                <h5 class="card-header">Languages <span class="starrequired">*</span></h5>
                                <div class="table-responsive text-nowrap">
                                    <table class="table languages">
                                        <thead>
                                        <tr class="text-nowrap">
                                            <th>Language Spoken <span class="starrequired">*</span></th>
                                            <th>Spoken Fluency Level <span class="starrequired">*</span></th>
                                            <th>Reading/Writing Fluency Level <span class="starrequired">*</span></th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                            $languageOldData = [
                                                    [
                                                        'language' => null,
                                                        'fluency' => null,
                                                        'writing_fluency' => null,
                                                    ]
                                                ];
                                            $languageOldData = $languages->count() ? $languages->toArray() : $languageOldData;
                                            $oldLanguageData = old('languages', $languageOldData);
                                        @endphp
                                        @if(count($oldLanguageData))
                                            @foreach($oldLanguageData as $languageKey => $language)
                                                <tr>
                                                    <td>
                                                        <select id="language-select"
                                                                class="form-select language-select @error('languages.'.$languageKey.'.language') is-invalid @enderror"
                                                                name="languages[{{ $languageKey }}][language]">
                                                            <option value="">--select--</option>
                                                            @foreach($languageOptions as $languageOption)
                                                                <option value="{{ $languageOption['id'] }}"
                                                                    @selected(old('languages.'.$languageKey.'.language', $language['language']) == $languageOption['id'])>
                                                                    {{ $languageOption['name'] }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('languages.'.$languageKey.'.language')
                                                        <span role="alert" class="text-danger small">
                                                          {{ $message }}
                                                      </span>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <select id="defaultSelect"
                                                                class="form-select @error('languages.'.$languageKey.'.fluency') is-invalid @enderror"
                                                                name="languages[{{ $languageKey }}][fluency]">
                                                            <option value="">--select--</option>
                                                            <option value="1" @selected($language['fluency'] == 1)>
                                                                Beginner to Conversational
                                                            </option>
                                                            <option value="2" @selected($language['fluency'] == 2)>
                                                                Moderate to Fluent
                                                            </option>
                                                        </select>
                                                        @error('languages.'.$languageKey.'.fluency')
                                                        <span role="alert" class="text-danger small">
                                                          {{ $message }}
                                                      </span>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <select id="defaultSelect"
                                                                class="form-select @error('languages.'.$languageKey.'.writing_fluency') is-invalid @enderror"
                                                                name="languages[{{ $languageKey }}][writing_fluency]">
                                                            <option value="">--select--</option>
                                                            <option
                                                                value="1" @selected($language['writing_fluency'] == 1)>
                                                                Conversational
                                                            </option>
                                                            <option
                                                                value="2" @selected($language['writing_fluency'] == 2)>
                                                                Fluent
                                                            </option>
                                                        </select>
                                                        @error('languages.'.$languageKey.'.writing_fluency')
                                                        <span role="alert" class="text-danger small">
                                                          {{ $message }}
                                                      </span>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        @if($languageKey == 0)
                                                            <button type="button" class="btn btn-primary languages_row">
                                                                Add+
                                                            </button>
                                                        @else
                                                            <button type="button"
                                                                    class="btn btn-primary languages_row_remove">
                                                                Remove
                                                            </button>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="mb-3">
                            <div class="card">
                                <h5 class="card-header">Documents</h5>
                                <div class="table-responsive text-nowrap">
                                    <table class="table">
                                        <thead>
                                        <tr class="text-nowrap">
                                            <th>DL</th>
                                            <th>ID/PassPort Photo</th>
                                            <th>SSN</th>
                                            <th>Birth Certificate</th>
                                            <th>Form 19</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>
                                                <input
                                                    class="form-control investigator_profile_document_dl @error('document_dl') is-invalid @enderror"
                                                    type="file"
                                                    name="document_dl">
                                                @if(isset($document->driving_license))
                                                    <a href="{{ Storage::disk('public')->url($document->driving_license) }}"
                                                       target="_blank">
                                                        View DL
                                                    </a>
                                                @endif
                                                @error('document_dl')
                                                <span role="alert" class="text-danger small">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </td>
                                            <td>
                                                <input
                                                    class="form-control investigator_profile_document_id @error('document_id') is-invalid @enderror"
                                                    type="file"
                                                    name="document_id">
                                                @if(isset($document->passport))
                                                    <a href="{{ Storage::disk('public')->url($document->passport) }}"
                                                       target="_blank">
                                                        View ID/PassPort Photo
                                                    </a>
                                                @endif
                                                @error('document_id')
                                                <span role="alert" class="text-danger small">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </td>
                                            <td>
                                                <input
                                                    class="form-control investigator_profile_document_ssn @error('document_ssn') is-invalid @enderror"
                                                    type="file" name="document_ssn">
                                                @if(isset($document->ssn))
                                                    <a href="{{ Storage::disk('public')->url($document->ssn) }}"
                                                       target="_blank">
                                                        View SSN
                                                    </a>
                                                @endif
                                                @error('document_ssn')
                                                <span role="alert" class="text-danger small">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </td>
                                            <td>
                                                <input
                                                    class="form-control investigator_profile_document_birth_certificate @error('document_birth_certificate') is-invalid @enderror"
                                                    type="file" name="document_birth_certificate">
                                                @if(isset($document->birth_certificate))
                                                    <a href="{{ Storage::disk('public')->url($document->birth_certificate) }}"
                                                       target="_blank">
                                                        View Birth Certificate
                                                    </a>
                                                @endif
                                                @error('document_birth_certificate')
                                                <span role="alert" class="text-danger small">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </td>
                                            <td>
                                                <input
                                                    class="form-control investigator_profile_document_form_19 @error('document_form_19') is-invalid @enderror"
                                                    type="file" name="document_form_19">
                                                @if(isset($document->form_19))
                                                    <a href="{{ Storage::disk('public')->url($document->form_19) }}"
                                                       target="_blank">
                                                        View Form 19
                                                    </a>
                                                @endif
                                                @error('document_form_19')
                                                <span role="alert" class="text-danger small">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="mb-3">
                            <div class="card col-md-6">
                                <h5 class="card-header">General availability and notice for lead time? <span
                                        class="starrequired">*</span></h5>
                                <div class="table-responsive text-nowrap">
                                    <table class="table">
                                        <thead>
                                        <tr class="text-nowrap">
                                            <th>Days <span class="starrequired">*</span></th>
                                            <th>Hours <span class="starrequired">*</span></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>
                                                <input
                                                    class="form-control @error('availability_days') is-invalid @enderror"
                                                    type="text" name="availability_days"
                                                    value="{{ old('availability_days', $availability->days ?? '') }}">
                                                @error('availability_days')
                                                <span role="alert" class="text-danger small">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </td>
                                            <td>
                                                <input
                                                    class="form-control @error('availability_hours') is-invalid @enderror"
                                                    type="text" name="availability_hours"
                                                    value="{{ old('availability_hours', $availability->hours ?? '') }}">
                                                @error('availability_hours')
                                                <span role="alert" class="text-danger small">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="mb-3">
                            <div class="card col-md-6">
                                <h5 class="card-header">Availability <span class="starrequired">*</span></h5>
                                <div class="table-responsive text-nowrap">
                                    <table class="table">
                                        <thead>
                                        <tr class="">
                                            <th>Distance - You willing to travel to work a case? (in miles) <span
                                                    class="starrequired">*</span></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>
                                                <input
                                                    class="form-control w-50 @error('availability_distance') is-invalid @enderror"
                                                    type="text" name="availability_distance"
                                                    value="{{ old('availability_distance', $availability->distance ?? '') }}">
                                                @error('availability_distance')
                                                <span role="alert" class="text-danger small">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="mb-3">
                            <div class="card col-md-6">
                                <h5 class="card-header">Timezone <span class="starrequired">*</span></h5>
                                <div class="table-responsive text-nowrap">
                                    <table class="table">
                                        <thead>
                                        <tr class="">
                                            <th>Select Timezone <span
                                                    class="starrequired">*</span></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>
                                                <select id="timezone-select"
                                                        class="form-select @error('timezone') is-invalid @enderror"
                                                        name="timezone">
                                                    <option value="">--select--</option>
                                                    @foreach($timezones as $timezone)
                                                        <option value="{{ $timezone->id }}"
                                                            @selected(old('timezone', $availability->timezone_id ?? '') == $timezone->id)>
                                                            {{ $timezone->timezone }} - [{{ $timezone->name }}]
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('timezone')
                                                <span role="alert" class="text-danger small">
                                                  {{ $message }}
                                                </span>
                                                @enderror
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <button type="submit"
                                class="btn btn-primary">
                            {{ $user->is_investigator_profile_submitted ? 'Update' : 'Submit' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@include('investigator.calendar-sync-modal')

@endsection

@push('styles')
    <style type="text/css">
        .dollarIcon span {
            position: relative;
        }

        .dollarIcon span:before {
            content: "$";
            z-index: 123;
            position: absolute;
            left: 10px;
            top: 10px;
        }
    </style>
@endpush

@push('scripts')
 <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.api_key') }}&libraries=places&callback=initAutocomplete"
            async defer></script>
    <script src="{{ asset('html/assets/js/address-auto-complete.js') }}"></script>

    <script>
        $(document).ready(function(){
    $('#bio').keyup(function() {
    console.log('typing');
    var characterCount = $(this).val().length,
        current = $('#current'),
        maximum = $('#maximum'),
        theCount = $('#the-count');

    current.text(characterCount);

    /*This isn't entirely necessary, just playin around*/
    /* if (characterCount < 70) {
      current.css('color', '#666');
    }
    if (characterCount > 70 && characterCount < 90) {
      current.css('color', '#6d5555');
    }
    if (characterCount > 90 && characterCount < 100) {
      current.css('color', '#793535');
    }
    if (characterCount > 100 && characterCount < 120) {
      current.css('color', '#841c1c');
    }
    if (characterCount > 120 && characterCount < 139) {
      current.css('color', '#8f0001');
    }

    if (characterCount >= 140) {
      maximum.css('color', '#8f0001');
      current.css('color', '#8f0001');
      theCount.css('font-weight','bold');
    } else {
      maximum.css('color','#666');
      theCount.css('font-weight','normal');
    } */
    });
  });
  </script>
@endpush
