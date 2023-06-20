@extends('layouts.dashboard')
@section('content')
    <div class="container">
        <div class="row mt-4 mb-4 mx-0">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header pt-2 pb-0 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 invSearchTitle">Investigator Search</h5>
                    </div>
                    <div class="card-body">
                        @php
                            $action = route('company-admin.find_investigator');
                            if (request()->routeIs('hm.find_investigator')) {
                                $action = route('hm.find_investigator');
                            }
                        @endphp
                        <form method="get" action="{{ $action }}"
                              id="find-investigator-form">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-1">
                                        <div class="card">
                                            <h5 class="card-header pt-2 pb-0">Case Location</h5>
                                            <div class="table-responsive text-nowrap">
                                                <table class="table hr_contact">
                                                    <tbody>
                                                    <tr>
                                                        <td>
                                                            <input type="text"
                                                                   class="form-control caseLocationField"
                                                                   placeholder="Street" name="address" id="autocomplete"
                                                                   value="{{ old('address', $request->get('address')) }}">
                                                            <span role="alert" class="text-danger small d-none"
                                                                  id="address-error">
                                             Address is required!
                                             </span>
                                                        </td>
                                                        <td>
                                                            <input type="hidden" id="street_number">
                                                            <input type="text" id="locality"
                                                                   class="form-control caseLocationField"
                                                                   placeholder="City" name="city"
                                                                   value="{{ old('city', $request->get('city')) }}">
                                                            <span role="alert" class="text-danger small d-none"
                                                                  id="city-error">
                                             City is required!
                                             </span>
                                                        </td>
                                                        <td>
                                                            <input type="text"
                                                                   class="form-control caseLocationField"
                                                                   name="state" placeholder="State"
                                                                   value="{{ old('state', $request->get('state')) }}"
                                                                   id="administrative_area_level_1">
                                                            <span role="alert" class="text-danger small d-none"
                                                                  id="state-error">
                                             State is required!
                                             </span>
                                                        </td>
                                                        <input type="hidden" id="country" class="form-control"
                                                               name="country">

                                                        <input type="hidden" id="lat" name="lat"
                                                               value="{{ old('lat', $request->get('lat')) }}">
                                                        <input type="hidden" id="lng" name="lng"
                                                               value="{{ old('lng', $request->get('lng')) }}">
                                                        <td>
                                                            <input type="text"
                                                                   class="form-control caseLocationField"
                                                                   name="zipcode" placeholder="Zipcode"
                                                                   value="{{ old('zipcode', $request->get('zipcode')) }}"
                                                                   id="postal_code">
                                                            <span role="alert" class="text-danger small d-none"
                                                                  id="zipcode-error">
                                                             Zipcode is required!
                                                             </span>
                                                            <span role="alert" class="text-danger small d-none"
                                                                  id="zipcode-lat-lng-error">
                                                              Lat and lng is not found for this zipcode, please try another zipcode!
                                                             </span>
                                                            <span role="alert" class="text-info small ms-1 d-none"
                                                                  id="zipcode-lat-lng-loading">
                                                              <i class="fas fa-spinner fa-spin"></i>
                                                                Lat and Lng is getting from zipcode, please wait...
                                                             </span>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-1">
                                        <div class="card">
                                            <h5 class="card-header pt-2 pb-0">Service Type</h5>
                                            <div class="table-responsive text-nowrap">
                                                <table class="table hr_contact">
                                                    <tbody>
                                                    <tr>
                                                        <td>
                                                            <input class="form-check-input" type="checkbox"
                                                                   id="surveillance"
                                                                   value="surveillance" name="surveillance"
                                                                @checked(old('surveillance', $request->get('surveillance')) == 'surveillance')>
                                                            <label>Surveillance</label>
                                                        </td>
                                                        <td>
                                                            <input class="form-check-input" type="checkbox"
                                                                   id="statements"
                                                                   value="statements" name="statements"
                                                                @checked(old('statements', $request->get('statements')) == 'statements')>
                                                            <label>Statements</label>
                                                        </td>
                                                        <td>
                                                            <input class="form-check-input" type="checkbox" value="misc"
                                                                   name="misc" id="misc"
                                                                @checked(old('misc', $request->get('misc')) == 'misc')>
                                                            <label>Misc</label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="100%">
                                                            <span role="alert" class="text-danger small d-none"
                                                                  id="service-type-error">
                                                                Service Type is required, please select at least one!
                                                             </span>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-1">
                                        <div class="card">
                                            <h5 class="card-header pt-2 pb-0">License / Card Required</h5>
                                            <div class="table-responsive text-nowrap">
                                                <table class="table hr_contact">
                                                    <tbody>
                                                    <tr>
                                                        <td>
                                                            <select class="form-select" name="license">
                                                                <option value="">Select License</option>
                                                                @foreach($states as $state)
                                                                    <option
                                                                        value="{{ $state->id }}"
                                                                        @selected(old('license', $request->get('license')) == $state->id)>
                                                                        {{ $state->code }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @error('license')
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
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-1">
                                        <div class="card">
                                            <h5 class="card-header pt-2 pb-0">Language Spoken</h5>
                                            <table class="table hr_contact">
                                                <tbody>
                                                <tr>
                                                    <td>
                                                        <select id="language-select" class="form-control form-select"
                                                                name="languages[]" multiple>
                                                            <option value="">Select Languages</option>
                                                            @foreach($languageOptions as $languageOption)
                                                                <option value="{{ $languageOption['id'] }}"
                                                                    @selected(old('languages', $request->get('languages')) && in_array($languageOption['id'], old('languages', $request->get('languages'))))>
                                                                    {{ $languageOption['name'] }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-1">
                                        <div class="card">
                                            <div class="table-responsive">
                                                <button type="submit" class="btn btn-primary hr_investigator_search"
                                                        id="form-submit-btn">
                                                    Search
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            Investigators
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Surveillance</th>
                                    <th>Hourly Rate</th>
                                    <th>Statements</th>
                                    <th>Hourly Rate</th>
                                    <th>Misc</th>
                                    <th>Hourly Rate</th>
                                    <th class="text-center">Distance (In Miles)</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($investigators as $investigator)
                                    @if(
                                            !$investigator->checkIsBlockedCompanyAdmin(auth()->id())
                                            && ($investigator->investigatorAvailability && $investigator->investigatorAvailability->distance >=
                                            $investigator->calculated_distance)
                                        )
                                        <tr>
                                            <td>{{ $investigators->firstItem() + $loop->index }}</td>
                                            <td>{{ $investigator->first_name }}</td>
                                            <td>{{ $investigator->last_name }}</td>
                                            @php
                                                $surv = $investigator->getServiceType('surveillance');
                                                $stat = $investigator->getServiceType('statements');
                                                $misc = $investigator->getServiceType('misc');
                                            @endphp
                                            <td>{{ $surv ? 'Yes' : '-' }}</td>
                                            <td>{{ $surv ? $surv->hourly_rate : '-' }}</td>
                                            <td>{{ $stat ? 'Yes' : '-' }}</td>
                                            <td>{{ $stat ? $stat->hourly_rate : '-' }}</td>
                                            <td>{{ $misc ? 'Yes' : '-' }}</td>
                                            <td>{{ $misc ? $misc->hourly_rate : '-' }}</td>
                                            <td class="text-center">{{ number_format($investigator->calculated_distance, 2) }}
                                                miles
                                            </td>
                                        </tr>
                                    @endif
                                @empty
                                    <tr>
                                        <td colspan="100%" class="text-center">No investigators found!</td>
                                    </tr>
                                @endforelse
                                </tbody>
                                @if(count($investigators))
                                    <tfoot>
                                    <tr>
                                        <td colspan="100%">
                                            <div class="float-end">
                                                {{ $investigators->withQueryString()->links() }}
                                            </div>
                                        </td>
                                    </tr>
                                    </tfoot>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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

    <link href="//cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
@endpush
@push('scripts')
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAB80hPTftX9xYXqy6_NcooDtW53kiIH3A&libraries=places&callback=initAutocomplete"
        async defer></script>
    <script src="{{ asset('html/assets/js/address-auto-complete.js') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        function getLatLngFromZipCode(zipCode) {
            var geocoder = new google.maps.Geocoder();
            $('#form-submit-btn').attr('disabled', 'disabled');
            $('#zipcode-lat-lng-loading').removeClass('d-none');

            geocoder.geocode({'address': zipCode}, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    let lat = results[0].geometry.location.lat();
                    let lng = results[0].geometry.location.lng();

                    console.log('Latitude: ' + lat);
                    console.log('Longitude: ' + lng);

                    // check lat id and lng id is exist or not
                    if ($('#lat').length) {
                        $('#lat').val(lat);
                    }

                    if ($('#lng').length) {
                        $('#lng').val(lng);
                    }

                    if ($('#lat').val() && $('#lng').val() && $('#postal_code').val()) {
                        $('#zipcode-lat-lng-error').addClass('d-none');
                        $('#zipcode-lat-lng-loading').addClass('d-none');
                        $('#form-submit-btn').removeAttr('disabled');
                        $('#zipcode-error').addClass('d-none');
                    } else {
                        $('#zipcode-lat-lng-error').removeClass('d-none');
                        $('#zipcode-lat-lng-loading').addClass('d-none');
                        $('#form-submit-btn').attr('disabled', 'disabled');
                        $('#zipcode-error').addClass('d-none');
                    }
                } else {
                    $('#zipcode-lat-lng-loading').addClass('d-none');
                    $('#zipcode-lat-lng-error').removeClass('d-none');
                    $('#form-submit-btn').attr('disabled', 'disabled');
                    $('#zipcode-error').addClass('d-none');
                    console.log('Geocode was not successful for the following reason: ' + status);
                }
            });
        }

        $(document).ready(function () {
            $('#language-select').select2({
                placeholder  : 'Select Languages',
                allowClear   : true,
                closeOnSelect: false,
                width        : '100%',
            });

            const form = $('#find-investigator-form');
            form.on('submit', function () {

                // input selector
                const zip = $('#postal_code');
                const surv = $('#surveillance');
                const stat = $('#statements');
                const misc = $('#misc');

                // values
                const zipValue = zip.val();

                // error selector
                const zipError = $('#zipcode-error');
                const serviceTypeError = $('#service-type-error');
                let hasError = false;

                // Hide error
                zipError.addClass('d-none');
                serviceTypeError.addClass('d-none');

                // Remove error class
                zip.removeClass('is-invalid');


                if (!zipValue) {
                    // Show error
                    zipError.removeClass('d-none');

                    // Add error class
                    zip.addClass('is-invalid');

                    hasError = true;
                }

                if (!surv.is(':checked') && !stat.is(':checked') && !misc.is(':checked')) {
                    // Show error
                    serviceTypeError.removeClass('d-none');
                    hasError = true;
                }

                if (hasError) {
                    return false;
                }

                // Hide error
                zipError.addClass('d-none');
                serviceTypeError.addClass('d-none');

                // Remove error class
                zip.removeClass('is-invalid');

                // hide other errors
                $('#zipcode-lat-lng-error').addClass('d-none');
                $('#zipcode-lat-lng-loading').addClass('d-none');

                form.submit();
            });

            $('#postal_code').on('input', function () {
                let zipCode = $(this).val();
                if (!zipCode) {
                    return false;
                }
                getLatLngFromZipCode(zipCode);
            });
        });
    </script>
@endpush
