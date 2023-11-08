@extends('layouts.dashboard')
@section('title', 'Find Investigators')
@section('content')

<div class="container">

    <div class="row mt-4 mb-4 mx-0">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header pt-2 pb-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 invSearchTitle">Investigator Search</h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @php
                        $action = route('company-admin.find_investigator');
                        $assignmentsAction = route('company-admin.assignments');
                        $assignmentCreateAction = route('company-admin.assignments.create');
                        $assignmentStoreAction = route('company-admin.assignments.store');
                        $assignmentEditAction = '/company-admin/assignments/';
                        $assignmentInviteAction = route('company-admin.assignments.invite');
                        $assignmentSelect2Action = route('company-admin.select2-assignments');
                        $searchStoreAction = route('company-admin.save-investigator-search-history');
                        $searchEditAction = route('company-admin.update-investigator-search-history');
                        if (request()->routeIs('hm.assignments.edit')) {
                            $action = route('hm.find_investigator');
                            $assignmentsAction = route('hm.assignments');
                            $assignmentCreateAction = route('hm.assignments.create');
                            $assignmentStoreAction = route('hm.assignments.store');
                            $assignmentEditAction = '/hm/assignments/';
                            $assignmentInviteAction = route('hm.assignments.invite');
                            $assignmentSelect2Action = route('hm.select2-assignments');
                            $searchStoreAction = route('hm.save-investigator-search-history');
                            $searchEditAction = route('hm.update-investigator-search-history');
                        }
                    @endphp
                    
                    <form method="get" action="{{ $action }}" id="find-investigator-form">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-1">
                                    <div class="card">
                                        <h5 class="card-header pt-2 pb-0">Assignment ID</h5>
                                        <table class="table"> <!-- hr_contact -->
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <input type="text" name="e_assignment_id" class="form-control e-assignment-id" id="e-assignment-id" placeholder="Enter assignment ID" readonly required value="{{$assignment->assignment_id}}">
                                                        <span role="alert" class="text-danger small d-none" id="e-assignment-id-error"> Assignment ID is required! </span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

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
                                                            <input type="text" class="form-control caseLocationField" placeholder="Street" name="address" id="autocomplete" value="{{@$assignment->searchHistory->street}}">
                                                            <span role="alert" class="text-danger small d-none" id="address-error">
                                                                Address is required!
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <input type="hidden" id="street_number">
                                                            <input type="text" id="locality" class="form-control caseLocationField" placeholder="City" name="city" value="{{@$assignment->searchHistory->city}}">
                                                            <span role="alert" class="text-danger small d-none" id="city-error">
                                                                City is required!
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control caseLocationField" name="state" placeholder="State" value="{{@$assignment->searchHistory->state}}" id="administrative_area_level_1">
                                                            <span role="alert" class="text-danger small d-none" id="state-error">
                                                                State is required!
                                                            </span>
                                                        </td>
                                                        <input type="hidden" id="country" class="form-control" name="country">

                                                        <input type="hidden" id="lat" name="lat" value="{{@$assignment->searchHistory->lat}}">
                                                        <input type="hidden" id="lng" name="lng" value="{{@$assignment->searchHistory->lng}}">
                                                        <td>
                                                            <input type="text" class="form-control caseLocationField" name="zipcode" placeholder="Zipcode" value="{{@$assignment->searchHistory->zipcode}}" id="postal_code">
                                                            <span role="alert" class="text-danger small d-none" id="zipcode-error">
                                                                Zipcode is required!
                                                            </span>
                                                            <span role="alert" class="text-danger small d-none" id="zipcode-lat-lng-error">
                                                                Lat and lng is not found for this zipcode, please try another zipcode!
                                                            </span>
                                                            <span role="alert" class="text-info small ms-1 d-none" id="zipcode-lat-lng-loading">
                                                                <i class="fas fa-spinner fa-spin"></i>
                                                                Lat and Lng is getting from zipcode, please wait...
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control caseDistanceField" name="distance" placeholder="Distance (IN MILES)" value="{{@$assignment->searchHistory->distance}}" id="distance">
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
                                                            <input class="form-check-input" type="checkbox" id="surveillance" value="surveillance" name="surveillance" @checked(@$assignment->searchHistory->surveillance == 'surveillance')>
                                                            <label>Surveillance</label>
                                                        </td>
                                                        <td>
                                                            <input class="form-check-input" type="checkbox" id="statements" value="statements" name="statements" @checked(@$assignment->searchHistory->statements == 'statements')>
                                                            <label>Statements</label>
                                                        </td>
                                                        <td>
                                                            <input class="form-check-input" type="checkbox" value="misc" name="misc" id="misc" @checked(@$assignment->searchHistory->misc == 'misc')>
                                                            <label>Misc</label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="100%">
                                                            <span role="alert" class="text-danger small d-none" id="service-type-error">
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
                                        <h5 class="card-header pt-2 pb-0">License / Card
                                            Required</h5>
                                        <div class="table-responsive text-nowrap">
                                            <table class="table hr_contact">
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <select class="form-select" name="license" id="license-select">
                                                                <option value="">Select License</option>
                                                                @foreach($states as $state)
                                                                <option value="{{ $state->id }}" @selected(@$assignment->searchHistory->license_id == $state->id)>
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
                                                        <select id="language-select" class="form-control form-select" name="languages[]" multiple>
                                                            <option value="">Select Languages</option>
                                                            @foreach($languageOptions as $languageOption)
                                                            <option value="{{ $languageOption['id'] }}" @selected(@$assignment->searchHistory->languages && in_array($languageOption['id'], $assignment->searchHistory->languages))>
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

                            @php
                                if(@$assignment->searchHistory->availability){
                                $availability = explode(',',@$assignment->searchHistory->availability);
                                $minDate = explode('-', $availability[0]);
                                $timeAvailability = explode('-', $availability[1]);
                            }
                            @endphp

                            <div class="col-md-6">
                                <div class="mb-1">
                                    <div class="card">
                                        <h5 class="card-header pt-2 pb-0">Availability (Date)</h5>
                                        <table class="table"> <!-- hr_contact -->
                                            <tbody>
                                                <tr>
                                                    <td>

                                                        <input type="text" class="form-control caseAvailabilityField" data-min-date="{{@$minDate[0]}}" name="e_datetimes" placeholder="Availability (Date)" value="{{@$availability[0]}}" id="e-availability" />

                                                        <span role="alert" class="text-danger small d-none" id="availability-error"> Availability is required! </span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-1">
                                    <div class="card">
                                        <h5 class="card-header pt-2 pb-0">Availability (Start Time)</h5>
                                        <table class="table"> <!-- hr_contact -->
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <input type="text" class="form-control availabilityTimeField e-timepickerstart" data-start-time="{{@$timeAvailability[0]}}" name="start_time" placeholder="Availability (Time)" id="timepickerstart" value="{{@$timeAvailability[0]}}" />

                                                        <span role="alert" class="text-danger small d-none" id="time-error"> Time is required! </span>
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
                                        <h5 class="card-header pt-2 pb-0">Availability (End Time)</h5>
                                        <table class="table"> <!-- hr_contact -->
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <input type="text" class="form-control availabilityTimeField e-timepickerend" name="end_time" data-end-time="{{@$timeAvailability[1]}}" value="{{@$timeAvailability[1]}}" placeholder="Availability (Time)" id="timepickerend" />

                                                        <span role="alert" class="text-danger small d-none" id="time-error"> Time is required! </span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-1">
                                    <div class="card">
                                        <div class="table-responsive">

                                            <input type="hidden" id="assignmentID" value="{{@$assignment->id}}">
                                            <input type="hidden" id="searchHistoryID" value="{{@$assignment->searchHistory->id}}">

                                            <input type="hidden" id="fieldsUpdated" value="0">

                                            <button type="button" data-target="#confirmUpdateSearchModal" data-toggle="modal" class="btn btn-primary hr_investigator_search" disabled id="callConfirmUpdateSearchModal"> Search </button>

                                            <button type="submit" class="btn btn-primary hr_investigator_search d-none" id="form-submit-btn">
                                                Search
                                            </button>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-1 mt-2">
                                  <div class="card">
                                          <h5 class="card-header pt-2 pb-0">Search Investigators</h5>
                                          <div class="table-responsive text-nowrap">
                                              <table class="table hr_contact">
                                                  <tbody>
                                                      <tr>
                                                          <td>
                                                            <input class="form-check-input" type="checkbox"
                                                                   id="withInternalInvestigator" value="internal"
                                                                   name="withInternalInvestigator" @checked(@$assignment->searchHistory->withInternalInvestigator == 'internal')>
                                                              <label>Internal</label>
                                                          </td>
                                                          <td>
                                                            <input class="form-check-input" type="checkbox"
                                                                   id="withExternalInvestigator" value="external"
                                                                   name="withExternalInvestigator" @checked(@$assignment->searchHistory->withExternalInvestigator == 'external')>
                                                              <label>External</label>
                                                          </td>

                                                      </tr>
                                                      <tr>
                                                          <td colspan="100%">
                                                              <span role="alert" class="text-danger small d-none" id="searchInvestigatorsTypeError">
                                                                  Search Investigators is required, please select at least one!
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
                    <div class="table-responsive text-nowrap" id="data-container">
                        <table class="table" id="investigator-table">
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
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($investigators as $investigator)
                                @if( !$investigator->checkIsBlockedCompanyAdmin(auth()->id())
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
                                    <td class="text-center">
                                        {{ number_format($investigator->calculated_distance, 2) }}
                                        miles
                                    </td>

                                    <td class="text-center">
                                        <button type="button" class="btn btn-info btn-sm inviteSendBtn" data-assignment-count="{{ $assignments->count() }}" data-investigator-id="{{ $investigator->id }}">
                                            <i class="fas fa-paper-plane"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endif
                                @empty
                                <tr>
                                    <td colspan="100%" class="text-center">No investigators found!
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                            @if(count($investigators))
                            <tfoot>
                                <tr>
                                    <td colspan="100%">
                                        <div class="float-end" id="pagination-links">
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


{{-- Confirm Update Search Modal Alert Modal --}}
<div class="modal fade" id="confirmUpdateSearchModal" tabindex="-1" aria-labelledby="confirmUpdateSearchModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body pt-5">
                <h4 class="h4 text-center">
                    You have updated search criteria. You sure you want to proceed
                </h4>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-primary" id="confirmUpdateSearchModalBtn">
                    YES
                </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="confirmUpdateSearchModalCloseBtn">
                    NO
                </button>
            </div>
        </div>
    </div>
</div>


{{-- Send Invitation Modal --}}



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

<link href="//cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@push('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo Config::get('constants.GOOGLE_MAPS_API_KEY'); ?>&libraries=places&callback=initAutocomplete" async defer></script>
<script src="{{ asset('html/assets/js/address-auto-complete.js') }}"></script>
<script src="//cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    function getLatLngFromZipCode(zipCode) {
        var geocoder = new google.maps.Geocoder();
        $('#form-submit-btn').attr('disabled', 'disabled');
        $('#zipcode-lat-lng-loading').removeClass('d-none');

        geocoder.geocode({
            'address': zipCode
        }, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                let lat = results[0].geometry.location.lat();
                let lng = results[0].geometry.location.lng();

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
            }
        });
    }

    function fetchData(data) {
        var fieldsUpdated = $('#fieldsUpdated').val();

        data['fieldsUpdated'] = fieldsUpdated;

        $.ajax({
            url: '{{ $action }}',
            type: 'GET',
            data: data,
            success: function(response) {
              $(".custom-loader-overlay").hide();
                $('#data-container').html(response.data);
                $('button#form-submit-btn').html('Search').removeAttr('disabled');
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    }

    function fetchAssignmentData(data) {
        $.ajax({
            url: '{{ $assignmentsAction }}',
            type: 'GET',
            data: data,
            success: function(response) {
                $('#assignment-container').html(response.data);
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    }

    function saveSearchHistoryData() {

        // input selector
        const country = $('#country');
        const street = $('#autocomplete');
        const city = $('#locality');
        const state = $('#administrative_area_level_1');
        const zip = $('#postal_code');
        const surv = $('#surveillance');
        const stat = $('#statements');
        const misc = $('#misc');
        const lang = $('#language-select');
        const license = $('#license-select');
        const lat = $('#lat');
        const lng = $('#lng');
        const availability = $('#e-availability');
        const timepickerstart = $('#timepickerstart');
        const timepickerend = $('#timepickerend');
        const assignmentID = $('#assignmentID');
        const searchHistoryID = $('#searchHistoryID');
        const distance = $('#distance');
        const withInternalInvestigator = $('#withInternalInvestigator');
        const withExternalInvestigator = $('#withExternalInvestigator');


        // values
        const countryValue = country.val();
        const streetValue = street.val();
        const cityValue = city.val();
        const stateValue = state.val();
        const zipValue = zip.val();
        const survValue = surv.is(':checked');
        const statValue = stat.is(':checked');
        const miscValue = misc.is(':checked');
        const languages = lang.val();
        const licenseValue = license.val();
        const latValue = lat.val();
        const lngValue = lng.val();
        const availabilityValue = availability.val();
        const timepickerstartValue = timepickerstart.val();
        const timepickerendValue = timepickerend.val();
        const assignmentIDValue = assignmentID.val();
        const searchHistoryIDValue = searchHistoryID.val();
        const distanceValue = distance.val();
        const withInternalInvestigatorValue = withInternalInvestigator.is(':checked');
        const withExternalInvestigatorValue = withExternalInvestigator.is(':checked');

        const data = {
            country: countryValue,
            street: streetValue,
            city: cityValue,
            state: stateValue,
            zipcode: zipValue,
            distance: distanceValue
        };

        if (latValue && lngValue) {
            data['lat'] = latValue;
            data['lng'] = lngValue;
        }

        if (statValue) {
            data['statements'] = 'statements';
        }
        if (withInternalInvestigatorValue) {
            data['withInternalInvestigator'] = 'internal';
        }
        if (withExternalInvestigatorValue) {
            data['withExternalInvestigator'] = 'external';
        }

        if (miscValue) {
            data['misc'] = 'misc';
        }

        if (survValue) {
            data['surveillance'] = 'surveillance';
        }

        if (languages && languages.length) {
            data['languages'] = languages;
        }

        if (licenseValue) {
            data['license'] = licenseValue;
        }

        if (availabilityValue) {
            data['availability'] = availabilityValue;
        }

        if (timepickerstartValue) {
            data['start_time'] = timepickerstartValue;
        }

        if (timepickerendValue) {
            data['end_time'] = timepickerendValue;
        }

        if (assignmentIDValue) {
            data['assignment_id'] = assignmentIDValue;
        }

        if(searchHistoryIDValue)
        data['search_history_id'] = searchHistoryIDValue;

        let success = false;

        $.ajax({
            url: '{{ $searchEditAction }}',
            type: 'POST',
            data: data,
            success: function(response) {
                success = true
                // console.log(response);
            },
            error: function(xhr) {
                console.log(xhr.responseText);
                success = false;
            }
        });

        return success;
    }

    $(document).ready(function() {

        setTimeout(() => {
            $('#form-submit-btn').click();
        }, 2000);


        $(document).on('keyup', '#autocomplete, #locality, #administrative_area_level_1, #postal_code, #distance', function() {
            var assignmentID = $('#assignmentID').val();
            if(assignmentID != '') {
                $('#fieldsUpdated').val('1');
                $('#callConfirmUpdateSearchModal').removeAttr('disabled');
             }
        });

        $(document).on('change', 'input[type="checkbox"]', function() {
            var assignmentID = $('#assignmentID').val();
            if(assignmentID != '') {
                $('#fieldsUpdated').val('1');
                $('#callConfirmUpdateSearchModal').removeAttr('disabled');
             }
        });

        $(document).on('change', 'select, input[type="text"]', 'input[type="checkbox"]', function() {
            var assignmentID = $('#assignmentID').val();
            if(assignmentID != '') {
                $('#fieldsUpdated').val('1');
                $('#callConfirmUpdateSearchModal').removeAttr('disabled');
             }
        });

        $(document).on('click', '#callConfirmUpdateSearchModal', function() {
            $('#assignmentCreateModal').modal('show');
        });

        $(document).on('click', '#confirmUpdateSearchModalBtn', function(){
            $('#form-submit-btn').removeAttr('disabled').click();
            $('#confirmUpdateSearchModalCloseBtn').click();
            $('#fieldsUpdated').val('0');
            $('#callConfirmUpdateSearchModal').attr('disabled',true);
        });

        createAssignmentID();

        $('#language-select').select2({
            placeholder: 'Select Languages',
            allowClear: true,
            closeOnSelect: false,
            width: '100%',
        });

        const form = $('#find-investigator-form');
        form.on('submit', function(e) {
            $(this).find('button#form-submit-btn').html('Searching...').attr('disabled',true);
            e.preventDefault();

            // input selector
            const zip = $('#postal_code');
            const surv = $('#surveillance');
            const stat = $('#statements');
            const misc = $('#misc');
            const lang = $('#language-select');
            const license = $('#license-select');
            const lat = $('#lat');
            const lng = $('#lng');
            const availability = $('#e-availability');
            const timepickerstart = $('#timepickerstart');
            const timepickerend = $('#timepickerend');
            const assignmentID = $('#assignmentID');
            const distance = $('#distance');
            const withInternalInvestigator = $('#withInternalInvestigator');
            const withExternalInvestigator = $('#withExternalInvestigator');

            // values
            const zipValue = zip.val();
            const survValue = surv.is(':checked');
            const statValue = stat.is(':checked');
            const miscValue = misc.is(':checked');
            const languages = lang.val();
            const licenseValue = license.val();
            const latValue = lat.val();
            const lngValue = lng.val();
            const availabilityValue = availability.val();
            const timepickerstartValue = timepickerstart.val();
            const timepickerendValue = timepickerend.val();
            const assignmentIDValue = assignmentID.val();
            const distanceValue = distance.val();
            const withInternalInvestigatorValue = withInternalInvestigator.is(':checked');
            const withExternalInvestigatorValue = withExternalInvestigator.is(':checked');

            const data = {
                page: 1
            };

            // error selector
            const zipError = $('#zipcode-error');
            const serviceTypeError = $('#service-type-error');
            const searchInvestigatorsError = $('#searchInvestigatorsTypeError');

            let hasError = false;

            // Hide error
            zipError.addClass('d-none');
            serviceTypeError.addClass('d-none');
            searchInvestigatorsError.addClass('d-none');

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
            
            if (!withInternalInvestigator.is(':checked') && !withExternalInvestigator.is(':checked')) {
                // Show error
                searchInvestigatorsError.removeClass('d-none');
                hasError = true;
            }

            if (hasError) {
                return false;
            }
            $(".custom-loader-overlay").attr("style","display: flex !important;")
            // Hide error
            zipError.addClass('d-none');
            serviceTypeError.addClass('d-none');
            searchInvestigatorsError.addClass('d-none');

            // Remove error class
            zip.removeClass('is-invalid');

            // hide other errors
            $('#zipcode-lat-lng-error').addClass('d-none');
            $('#zipcode-lat-lng-loading').addClass('d-none');

            if (latValue && lngValue) {
                data['lat'] = latValue;
                data['lng'] = lngValue;
            }

            if (statValue) {
                data['statements'] = 'statements';
            }
            if (withExternalInvestigatorValue) {
                data['withExternalInvestigator'] = 'external';
            }
            if (withInternalInvestigatorValue) {
                data['withInternalInvestigator'] = 'internal';
            }

            if (miscValue) {
                data['misc'] = 'misc';
            }

            if (survValue) {
                data['surveillance'] = 'surveillance';
            }

            if (languages && languages.length) {
                data['languages'] = languages;
            }

            if (licenseValue) {
                data['license'] = licenseValue;
            }

            if (availabilityValue) {
                data['availability'] = availabilityValue;
            }

            if (timepickerstartValue) {
                data['start_time'] = timepickerstartValue;
            }

            if (timepickerendValue) {
                data['end_time'] = timepickerendValue;
            }

            data['assignment_id'] = assignmentIDValue;
            data['distance'] = distanceValue;

            saveSearchHistoryData();

            fetchData(data);
        });

        $('#postal_code').on('input', function() {
            let zipCode = $(this).val();
            if (!zipCode) {
                return false;
            }
            getLatLngFromZipCode(zipCode);
        });

        $(document).on('click', '#pagination-links a', function(e) {
            e.preventDefault();
            // input selector
            const surv = $('#surveillance');
            const stat = $('#statements');
            const misc = $('#misc');
            const lang = $('#language-select');
            const license = $('#license-select');
            const lat = $('#lat');
            const lng = $('#lng');
            const availability = $('#e-availability');
            const timepickerstart = $('#timepickerstart');
            const timepickerend = $('#timepickerend');

            // values
            const survValue = surv.is(':checked');
            const statValue = stat.is(':checked');
            const miscValue = misc.is(':checked');
            const languages = lang.val();
            const licenseValue = license.val();
            const latValue = lat.val();
            const lngValue = lng.val();
            const availabilityValue = availability.val();
            const timepickerstartValue = timepickerstart.val();
            const timepickerendValue = timepickerend.val();

            let page = $(this).attr('href').split('page=')[1];
            const data = {
                page: page
            };

            if (latValue && lngValue) {
                data['lat'] = latValue;
                data['lng'] = lngValue;
            }

            if (statValue) {
                data['statements'] = 'statements';
            }

            if (miscValue) {
                data['misc'] = 'misc';
            }

            if (survValue) {
                data['surveillance'] = 'surveillance';
            }

            if (languages && languages.length) {
                data['languages'] = languages;
            }

            if (licenseValue) {
                data['license'] = licenseValue;
            }

            if (availabilityValue) {
                data['availability'] = availabilityValue;
            }

            if (timepickerstartValue) {
                data['start_time'] = timepickerstartValue;
            }

            if (timepickerendValue) {
                data['end_time'] = timepickerendValue;
            }

            fetchData(data);
        });

        $(document).on('click', '#assignment-pagination-links a', function(e) {
            e.preventDefault();

            let page = $(this).attr('href').split('page=')[1];

            const data = {
                page: page
            };

            fetchAssignmentData(data);
        });


        $('button[data-toggle="pill"]').on('shown.bs.tab', function(event) {
            event.target // newly activated tab
            if (event.target.innerText === 'Assignments') {
                const data = {
                    page: 1
                };
                fetchAssignmentData(data);
            }
        });

        $('#createAssignmentBtn').on('click', function() {
            $('#assignmentCreateModal').modal('show');
        });

        $('#createModalCloseBtn').on('click', function() {
            $('#assignmentCreateModal').modal('hide');
        });

        $('#createModalCloseIconBtn').on('click', function() {
            $('#assignmentCreateModal').modal('hide');
        });


        // Create Assignment
        $('#assignmentCreateForm').on('submit', function(e) {
            e.preventDefault();

            const assignmentId = $('#assignment-id');
            const clientId = $('#client-id');

            let createAssignmentButton = $('#createAssignmentButton');

            $(createAssignmentButton).attr('disabled', true);
            $(createAssignmentButton).html('Saving...');

            const assignmentIdVal = assignmentId.val();
            const clientIdVal = clientId.val();

            const data = {
                assignment_id: assignmentIdVal,
                client_id: clientIdVal
            };


            $.ajax({
                url: '{{ $assignmentStoreAction }}',
                type: 'POST',
                data: data,
                success: function(response) {
                    $('#assignment-flash').text(response.message).removeClass('d-none');

                    $('#assignmentID').val(response.assignmentID);

                    $('#form-submit-btn').click();
                    $('#callCreateAssignmentModal').addClass('d-none');
                    $('#form-submit-btn').removeClass('d-none');
                    saveSearchHistoryData();

                    setTimeout(() => {
                        $('#createModalCloseBtn').click();
                    }, 1000);

                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                },
                complete: function() {
                    $(createAssignmentButton).html('Save');
                }
            });
        });


        $('#createAssignmentModalBtn').on('click', function() {
            $('#noAssignmentModal').modal('hide');
            $('#noAssignmentCreateModal').modal('show');
        });


        // Create Assignment from no assignment
        $('#noAssignmentCreateForm').on('submit', function(e) {
            e.preventDefault();

            const assignmentId = $('#no-assignment-id');
            const clientId = $('#no-client-id');

            const assignmentIdVal = assignmentId.val();
            const clientIdVal = clientId.val();

            const data = {
                assignment_id: assignmentIdVal,
                client_id: clientIdVal
            };

            $.ajax({
                url: '{{ $assignmentStoreAction }}',
                type: 'POST',
                data: data,
                success: function(response) {
                    $('#assignment-flash').text(response.message);
                    $('#assignment-flash').show();
                    fetchAssignmentData({
                        page: 1
                    });
                    $('#noAssignmentCreateModal').modal('hide');
                    $('#inviteModal').modal('show');
                    $('.inviteSendBtn').each(function() {
                        let inviteBtn = $(this);
                        let hasAssignment = !!inviteBtn.data('assignment-count');

                        if (!hasAssignment) {
                            inviteBtn.data('assignment-count', 1);
                        }
                    });
                    $('#jobs').select2({
                        placeholder: 'Select Assignments',
                        allowClear: true,
                        closeOnSelect: false,
                        width: '100%',
                        dropdownParent: $("#inviteModal"),
                        ajax: {
                            url: '{{ $assignmentSelect2Action }}'
                        }
                    });

                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });




        // Send Invitation
        $('#inviteModalCloseBtn').on('click', function() {
            $('#inviteModal').modal('hide');
        });

        $('#inviteCloseIconBtn').on('click', function() {
            $('#inviteModal').modal('hide');
        });

        $(document).on('click', '.inviteSendBtn', function() {

            const inviteBtn = $(this);

            const investigatorId = $(inviteBtn).data('investigator-id');
            const assignmentID = $('#assignmentID').val();
            const inviteFormSubmitBtn = $('#inviteFormSubmitBtn');

            const data = {
                investigator_id: investigatorId,
                assignment: assignmentID
            };

            $(inviteBtn).attr('disabled', true);
            $(inviteBtn).html('<i class="fa fa-spinner fa-pulse"></i>');
            $(".custom-loader-overlay").attr("style","display: flex !important;")
            $.ajax({
                url: '{{ $assignmentInviteAction }}',
                type: 'POST',
                data: data,
                success: function(response) {
                  $(".custom-loader-overlay").hide()
                    $('#assignment-flash').text(response.message);
                    $('#assignment-flash').show();
                    // $('#inviteModal').modal('hide');
                    if(response.error){
                      alert(response.message);
                    }

                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                },
                complete: function() {
                    // $(inviteBtn).attr('disabled', false);

                    $(inviteBtn).removeClass('btn-info').addClass('btn-success');
                    $(inviteBtn).html('<i class="fas fa-check"></i>');
                }
            });
        });

        $('#inviteForm').on('submit', function(e) {
            e.preventDefault();

            const investigatorId = $('#invite-investigator-id');
            const jobs = $('#jobs');
            const inviteFormSubmitBtn = $('#inviteFormSubmitBtn');

            const investigatorIdVal = investigatorId.val();
            const jobsVal = jobs.val();

            const data = {
                investigator_id: investigatorIdVal,
                assignments: jobsVal
            };

            inviteFormSubmitBtn.attr('disabled', true);
            inviteFormSubmitBtn.html(`<i class="fa fa-spinner fa-pulse"></i>
                            <span class="sr-only">Loading...</span>
                            Sending...`);

            $.ajax({
                url: '{{ $assignmentInviteAction }}',
                type: 'POST',
                data: data,
                success: function(response) {
                    // $('#assignment-flash').text(response.message);
                    // $('#assignment-flash').show();
                    $('#inviteModal').modal('hide');
                    // saveSearchHistoryData();
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                },
                complete: function() {
                    inviteFormSubmitBtn.attr('disabled', false);
                    inviteFormSubmitBtn.html('Send');
                }
            });
        });
    });


    function createAssignmentID() {
        $.ajax({
            url: '{{ $assignmentCreateAction }}',
            type: 'GET',
            success: function(response) {
                $('.assignment-id').val(response.data.assignment_id);
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    }
</script>
@endpush
