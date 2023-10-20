@extends('layouts.dashboard')
@section('title', 'Company Profile')
@section('content')
    <div class="row mt-4 mb-4 mx-0">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Company Profile</h5>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('company-admin.profile.submit') }}"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-fullname">Company Name</label>
                                    <input type="text" class="form-control @error('company_name') is-invalid @enderror"
                                           name="company_name"
                                           value="{{ old('company_name', $profile->company_name ?? $parentCompany->company_name ?? '') }}">
                                </div>
                                @error('company_name')
                                <span role="alert" class="text-danger small">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-fullname">Company Phone</label>
                                    <input type="text" class="form-control @error('company_phone') is-invalid @enderror"
                                           name="company_phone"
                                           value="{{ old('company_phone', $profile->company_phone ?? $parentCompany->company_phone ?? '') }}">
                                </div>
                                @error('company_phone')
                                <span role="alert" class="text-danger small">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-fullname">Address</label>
                                    <input type="text" id="autocomplete"
                                           class="form-control @error('address') is-invalid @enderror" name="address"
                                           value="{{ old('address', $profile->address ?? $parentCompany->address ?? '') }}">
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
                                           value="{{ old('address_1', $profile->address_1 ?? $parentCompany->address_1 ?? '') }}">
                                </div>
                                <input type="hidden" id="street_number">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-email">City</label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" id="locality"
                                               class="form-control @error('city') is-invalid @enderror" name="city"
                                               value="{{ old('city', $profile->city ?? $parentCompany->city ?? '') }}">
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
                                    <label class="form-label" for="basic-default-email">State</label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" id="administrative_area_level_1"
                                               class="form-control @error('state') is-invalid @enderror" name="state"
                                               value="{{ old('state', $profile->state ?? $parentCompany->state ?? '') }}">
                                        <!-- <select class="form-select @error('state') is-invalid @enderror" name="state">
                                                                                                                                                        @if (isset($states))
                                            @foreach ($states as $state)
                                                <option
                                                                                                                                                                                                            value="{{ $state->id }}" {{ isset($user->state_id) && ($user->state_id == $state->id || old('state') == $state->id) ? 'selected' : '' }}>{{ $state->code }}</option>





                                            @endforeach
                                        @endif
                                        </select> -->
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
                                    <label class="form-label" for="basic-default-email">Country</label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" id="country"
                                               class="form-control @error('country') is-invalid @enderror"
                                               name="country"
                                               value="{{ old('country', $profile->country ?? $parentCompany->country ?? '') }}">
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
                                    <label class="form-label" for="basic-default-email">Zip Code</label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" id="postal_code"
                                               class="form-control @error('zipcode') is-invalid @enderror"
                                               name="zipcode"
                                               value="{{ old('zipcode', $profile->zipcode ?? $parentCompany->zipcode ?? '') }}">
                                    </div>
                                    @error('zipcode')
                                    <span role="alert" class="text-danger small">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-email">Website</label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" class="form-control"
                                               value="{{ $user?->website ?? $user?->companyAdmin?->company?->website ?? '' }}"
                                               disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label" for="timezone">Timezone</label>
                                    <select name="timezone" id="timezone"
                                            class="form-control @error('timezone') is-invalid @enderror">
                                        <option value="">Select Timezone</option>
                                        @foreach ($timezones as $timezone)
                                            <option
                                                value="{{ $timezone->id }}" @selected(old('timezone', $profile->timezone_id ?? $parentCompany->timezone_id ?? '') == $timezone->id)>
                                                {{ $timezone->timezone }} - [{{ $timezone->name }}]
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('timezone')
                                    <span role="alert" class="text-danger small">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-check">
                                    <input name="make_assignments_private" class="form-check-input" type="checkbox" value="1" {{ (@$parentCompany->make_assignments_private == 1 ? 'checked' : '') }} id="makeAssignmentsPrivate">
                                    <label class="form-check-label" for="makeAssignmentsPrivate">
                                        Make Assignments Private
                                    </label>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <button type="submit"
                                class="btn btn-primary">{{ isset($profile) && !empty($profile->id) ? 'Update' : 'Submit' }}</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-1"></div>
    </div>
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
   <script
            src="https://maps.googleapis.com/maps/api/js?key=<?php echo Config::get('constants.GOOGLE_MAPS_API_KEY'); ?>&libraries=places&callback=initAutocomplete"
            async defer></script>
    <script src="{{ asset('html/assets/js/address-auto-complete.js') }}"></script>
@endpush
