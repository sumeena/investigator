@extends('layouts.dashboard')
@section('title', 'Assignments')
@section('content')
<div class="container">
    <div class="alert alert-success" role="alert" id="assignment-flash" style="display: none;">
    </div>
    <div class="row mt-3">
        <div class="col-md-12">

            @php
            $action = route('company-admin.find_investigator');
            $assignmentsAction = route('company-admin.assignments');
            $assignmentCreateAction = route('company-admin.assignments.create');
            $assignmentStoreAction = route('company-admin.assignments.store');
            $assignmentEditAction = '/company-admin/assignments/';
            $assignmentInviteAction = route('company-admin.assignments.invite');
            $assignmentSelect2Action = route('company-admin.select2-assignments');
            $searchStoreAction = route('company-admin.save-investigator-search-history');
            if (request()->routeIs('hm.find_investigator')) {
            $action = route('hm.find_investigator');
            $assignmentsAction = route('hm.assignments');
            $assignmentCreateAction = route('hm.assignments.create');
            $assignmentStoreAction = route('hm.assignments.store');
            $assignmentEditAction = '/hm/assignments/';
            $assignmentInviteAction = route('hm.assignments.invite');
            $assignmentSelect2Action = route('hm.select2-assignments');
            $searchStoreAction = route('hm.save-investigator-search-history');
            }
            @endphp

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col">
                                    <h5 class="">
                                        Assignments

                                        <!-- <a href="http://127.0.0.1:8000/company-admin/profile" class="btn btn-outline-primary btn-sm text-white float-end mt-n1">
                                                Edit Company Profile
                                            </a> -->
                                    </h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive text-nowrap" id="assignment-container">
                                <table class="table" id="assignment-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Assignment ID</th>
                                            <th>Client ID</th>
                                            <th>Invites Sent</th>
                                            <th>Status</th>
                                            <th>Date Created</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($assignments as $assignment)
                                        <tr>
                                            <td>{{ $assignments->firstItem() + $loop->index }}</td>
                                            <td>{{ Str::upper($assignment->assignment_id) }}</td>
                                            <td>{{ Str::upper($assignment->client_id) }}</td>
                                            <td>{{ Str::upper($assignment->users_count) }}</td>
                                            <td>{{ Str::upper($assignment->status) }}</td>
                                            <td>
                                                {{ $assignment->created_at->format('m/d/Y') }}
                                            </td>

                                            <td class="text-center">
                                                <a href="{{ route('company-admin.assignments.edit', [$assignment->id]) }}"><i class="fas fa-pencil"></i></a> |

                                                <a href="{{ route('company-admin.assignment.show', [$assignment->id]) }}"><i class="fas fa-eye"></i></a> |

                                                @php
                                                $pointer="pointer-events: none";
                                                if($assignment->status == 'OPEN')
                                                    $pointer="";
                                                @endphp
                                                <a style="@php echo $pointer; @endphp" href="javascript:void(0)" class="deleteAssignmentBtn" data-id="{{ $assignment->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="100%" class="text-center">
                                                No assignments found!
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                    @if(count($assignments))
                                    <tfoot>
                                        <tr>
                                            <td colspan="100%">
                                                <div class="float-end" id="assignment-pagination-links">
                                                    {{ $assignments->withQueryString()->links() }}
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
    </div>
</div>


{{-- Create Assignment Modal --}}
<div class="modal fade" id="assignmentCreateModal" tabindex="-1" aria-labelledby="assignmentCreateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignmentCreateModalLabel">Create Assignment</h5>
                <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close" id="createModalCloseIconBtn">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="assignmentCreateForm">
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="assignment-id">
                            Assignment ID
                        </label>
                        <input type="text" name="assignment_id" class="form-control" id="assignment-id" placeholder="Enter assignment ID" readonly required>
                    </div>
                    <div class="form-group">
                        <label for="client-id">
                            Client ID
                        </label>
                        <input type="text" name="client_id" class="form-control" id="client-id" placeholder="Enter client ID" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="createModalCloseBtn">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- No Assignment Create Assignment Modal --}}
<div class="modal fade" id="noAssignmentCreateModal" tabindex="-1" aria-labelledby="noAssignmentCreateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="noAssignmentCreateModalLabel">Create Assignment</h5>
                <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close" id="noCreateModalCloseIconBtn">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="noAssignmentCreateForm">
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="no-assignment-id">
                            Assignment ID
                        </label>
                        <input type="text" name="assignment_id" class="form-control" id="no-assignment-id" placeholder="Enter assignment ID" readonly required>
                    </div>
                    <div class="form-group">
                        <label for="no-client-id">
                            Client ID
                        </label>
                        <input type="text" name="client_id" class="form-control" id="no-client-id" placeholder="Enter client ID" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="noCreateModalCloseBtn">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Edit Assignment Modal --}}
<div class="modal fade" id="assignmentEditModal" tabindex="-1" aria-labelledby="assignmentEditModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignmentEditModalLabel">Edit Assignment</h5>
                <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close" id="editModalCloseIconBtn">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="assignmentEditForm">
                <div class="modal-body">
                    <input type="hidden" name="id" id="assignment-edit-id">
                    <div class="form-group mb-3">
                        <label for="edit-assignment-id">
                            Assignment ID
                        </label>
                        <input type="text" name="assignment_id" class="form-control" id="edit-assignment-id" placeholder="Enter assignment ID" readonly required>
                    </div>
                    <div class="form-group">
                        <label for="edit-client-id">
                            Client ID
                        </label>
                        <input type="text" name="client_id" class="form-control" id="edit-client-id" placeholder="Enter client ID" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="editModalCloseBtn">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Update
                    </button>
                </div>
            </form>
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

<link href="//cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@push('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAB80hPTftX9xYXqy6_NcooDtW53kiIH3A&libraries=places&callback=initAutocomplete" async defer></script>
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
                // console.log('Geocode was not successful for the following reason: ' + status);
            }
        });
    }

    function fetchData(data) {
        $.ajax({
            url: '{{ $action }}',
            type: 'GET',
            data: data,
            success: function(response) {
                $('#data-container').html(response.data);
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
                // console.log(response.data);
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

        const data = {
            country: countryValue,
            street: streetValue,
            city: cityValue,
            state: stateValue,
            zipcode: zipValue
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

        let success = false;

        $.ajax({
            url: '{{ $searchStoreAction }}',
            type: 'POST',
            data: data,
            success: function(response) {
                // console.log('searchHistoryStore', response);
            },
            error: function(xhr) {
                console.log(xhr.responseText);
                success = false;
            }
        });

        return success;
    }

    $(document).ready(function() {
        $('#language-select').select2({
            placeholder: 'Select Languages',
            allowClear: true,
            closeOnSelect: false,
            width: '100%',
        });

        const form = $('#find-investigator-form');
        form.on('submit', function(e) {
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
            const availability = $('#availability');


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

            const data = {
                page: 1
            };

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
            const availability = $('#availability');


            // values
            const survValue = surv.is(':checked');
            const statValue = stat.is(':checked');
            const miscValue = misc.is(':checked');
            const languages = lang.val();
            const licenseValue = license.val();
            const latValue = lat.val();
            const lngValue = lng.val();
            const availabilityValue = availability.val();

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

        // Load Assignment Create Modal Data
        $('#assignmentCreateModal').on('show.bs.modal', function(event) {
            const modal = $(this)

            $.ajax({
                url: '{{ $assignmentCreateAction }}',
                type: 'GET',
                success: function(response) {
                    modal.find('#assignment-id').val(response.data.assignment_id);
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });

        // Create Assignment
        $('#assignmentCreateForm').on('submit', function(e) {
            e.preventDefault();

            const assignmentId = $('#assignment-id');
            const clientId = $('#client-id');

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
                    $('#assignmentCreateModal').modal('hide');
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });

        $('#editModalCloseBtn').on('click', function() {
            $('#assignmentEditModal').modal('hide');
        });

        $('#editModalCloseIconBtn').on('click', function() {
            $('#assignmentEditModal').modal('hide');
        });

        // No assignment modal
        $('#noAssignmentCloseBtn').on('click', function() {
            $('#noAssignmentModal').modal('hide');
        });

        $('#createAssignmentModalBtn').on('click', function() {
            $('#noAssignmentModal').modal('hide');
            $('#noAssignmentCreateModal').modal('show');
        });

        $('#noCreateModalCloseBtn').on('click', function() {
            $('#noAssignmentCreateModal').modal('hide');
        });

        $('#noCreateModalCloseIconBtn').on('click', function() {
            $('#noAssignmentCreateModal').modal('hide');
        });

        // Load Assignment Create Modal Data
        $('#noAssignmentCreateModal').on('show.bs.modal', function(event) {
            const modal = $(this)

            $.ajax({
                url: '{{ $assignmentCreateAction }}',
                type: 'GET',
                success: function(response) {
                    modal.find('#no-assignment-id').val(response.data.assignment_id);
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
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

        // Edit Assignment
        $(document).on('click', '.editAssignmentBtn', function() {
            const editBtn = $(this);
            const modal = $('#assignmentEditModal');

            $.ajax({
                url: '{{ $assignmentEditAction }}' + editBtn.data('id') + '/edit',
                type: 'GET',
                success: function(response) {
                    modal.find('#assignment-edit-id').val(response.data.id);
                    modal.find('#edit-assignment-id').val(response.data.assignment_id);
                    modal.find('#edit-client-id').val(response.data.client_id);
                    modal.modal('show');
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });

        $('#assignmentEditModal').on('submit', function(e) {
            e.preventDefault();

            const assignmentId = $('#assignment-edit-id');
            const clientId = $('#edit-client-id');

            const assignmentIdVal = assignmentId.val();
            const clientIdVal = clientId.val();

            const data = {
                client_id: clientIdVal
            };


            $.ajax({
                url: '{{ $assignmentEditAction }}' + assignmentIdVal + '/update',
                type: 'PUT',
                data: data,
                success: function(response) {
                    $('#assignment-flash').text(response.message);
                    $('#assignment-flash').show();
                    fetchAssignmentData({
                        page: 1
                    });
                    $('#assignmentEditModal').modal('hide');
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });

        // Delete Assignment
        $(document).on('click', '.deleteAssignmentBtn', function() {
            const deleteBtn = $(this);

            // confirm prompt
            if (confirm('Are you sure you want to delete this assignment?')) {
                $.ajax({
                    url: '{{ $assignmentEditAction }}' + deleteBtn.data('id') + '/delete',
                    type: 'POST',
                    success: function(response) {
                        $('#assignment-flash').text(response.message);
                        $('#assignment-flash').show();
                        fetchAssignmentData({
                            page: 1
                        });
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            }
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
            const hasAssignments = !!inviteBtn.data('assignment-count');
            const modal = $('#inviteModal');
            const noAssignmentModal = $('#noAssignmentModal');
            modal.find('#invite-investigator-id').val(inviteBtn.data('investigator-id'));

            if (!hasAssignments) {
                noAssignmentModal.modal('show');
                return;
            }

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


            modal.modal('show');
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
                    $('#assignment-flash').text(response.message);
                    $('#assignment-flash').show();
                    $('#inviteModal').modal('hide');
                    saveSearchHistoryData();
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
</script>
@endpush