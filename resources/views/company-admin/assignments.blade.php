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
            $assignmentsListAction = route('company-admin.assignments-list');
            $assignmentCreateAction = route('company-admin.assignments.create');
            $assignmentStoreAction = route('company-admin.assignments.store');
            $assignmentEditAction = 'company-admin.assignments.edit';
            $assignmentsDeleteAction = route('company-admin.assignments.destroy', ['assignment' => 'assignmentIdPlaceholder']);
            $assignmentShowAction = 'company-admin.assignment.show';
            $assignmentInviteAction = route('company-admin.assignments.invite');
            $assignmentSelect2Action = route('company-admin.select2-assignments');
            $searchStoreAction = route('company-admin.save-investigator-search-history');
            if (request()->routeIs('hm.assignments-list')) {
            $action = route('hm.find_investigator');
            $assignmentsAction = route('hm.assignments');
            $assignmentsListAction = route('hm.assignments-list');
            $assignmentsDeleteAction = route('hm.assignments.destroy', ['assignment' => 'assignmentIdPlaceholder']);
            $assignmentCreateAction = route('hm.assignments.create');
            $assignmentEditAction = 'hm.assignments.edit';
            $assignmentShowAction = 'hm.assignment.show';
            $assignmentStoreAction = route('hm.assignments.store');
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
                                    <h5 class="">Assignments</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive text-nowrap" id="assignment-container">
                                <form method="get" action="{{ $assignmentsListAction }}" id="findAssignmentForm">

<div class="row">
    <div class="col-md-12">
        <div class="mb-1">
            <div class="card">
                <h5 class="card-header pt-2 pb-0">Search</h5>
                <div class="table-responsive text-nowrap">
                    <table class="table hr_contact">
                        <tbody>
                            <tr>
                                <td>
                                    <input type="text" class="form-control" name="searchby" placeholder="Search by Assignment ID OR CLIENT ID OR CREATED BY" value="<?php if (isset($_GET['searchby'])) {
                                        echo $_GET['searchby'];
                                    }; ?>" id="searchby">
                                </td>
                                <td>
                                    <select class="form-select" name="status-select" id="status-select">
                                        <option value="">Select Status</option>
                                        <option value="OPEN" <?php if (isset($_GET['status-select']) && $_GET['status-select'] == "OPEN") {
                                                                    echo "selected";
                                                                }; ?>>OPEN </option>
                                        <option value="INVITED" <?php if (isset($_GET['status-select']) && $_GET['status-select'] == "INVITED") {
                                                                    echo "selected";
                                                                }; ?>>INVITED </option>
                                        <option value="ASSIGNED" <?php if (isset($_GET['status-select']) && $_GET['status-select'] == "ASSIGNED") {
                                                                        echo "selected";
                                                                    }; ?>>ASSIGNED </option>
                                    </select>
                                </td>
                                <td>
                                    <input type="submit" value="Search" class="btn btn-primary" />
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
                                <table class="table" id="assignment-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Assignment ID</th>
                                            <th>Client ID</th>
                                            <th>Created By</th>
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
                                            <td>{{ @$assignment->author->first_name }} {{ @$assignment->author->last_name }}</td>
                                            <td>{{ Str::upper($assignment->users_count) }}</td>
                                            <td>{{ Str::upper($assignment->status) }}</td>
                                            <td>
                                                {{ $assignment->created_at->format('m/d/Y') }}
                                            </td>

                                            <td class="text-center">
                                                @php
                                                $pointer="pointer-events: none";
                                                $aHref = "javascript:void(0)";
                                                if($assignment->status == 'OPEN' || $assignment->status == 'INVITED' || $assignment->status == 'OFFER REJECTED' || $assignment->status == 'OFFER CANCELLED') {
                                                    $pointer="";
                                                    $aHref = route($assignmentEditAction, [$assignment->id]);
                                                }
                                                @endphp
                                                
                                                <a style="@php echo $pointer; @endphp" href="{{ $aHref }}"><i class="fas fa-pencil"></i></a> |
                                               
                                                <a href="{{ route($assignmentShowAction, [$assignment->id]) }}"><i class="fas fa-eye"></i></a> |

                                                @php
                                                $pointer="pointer-events: none";
                                                if($assignment->status == 'OPEN')
                                                $pointer="";
                                                @endphp
                                                <a style="@php echo $pointer; @endphp" href="javascript:void(0)" class="deleteAssignmentBtn" data-id="{{ $assignment->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </a> |
                                                <a class="callCloneAssignmentModal" data-assignment-id="{{ $assignment->id }}" data-assignment-url="{{ $assignmentCreateAction }}" data-client-id="{{ $assignment->client_id }}" href="javascript:void(0)"><i class="fa-solid fa-clone"></i></a>
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
<div class="modal fade" id="cloneAssignmentModal" tabindex="-1" aria-labelledby="cloneAssignmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cloneAssignmentModalLabel">Create Assignment</h5>
                <button type="button" class="close btn btn-danger btn-sm" data-dismiss="modal" aria-label="Close" id="cloneModalCloseIconBtn">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ $assignmentStoreAction }}" method="post" id="assignmentCloneForm">
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="assignment-id">
                            Assignment ID
                        </label>
                        <input type="hidden" name="source_assignment_id" class="form-control" id="sourceAssignmentId" placeholder="Enter assignment ID" readonly required>

                        <input type="text" name="assignment_id" class="form-control" id="assignmentId" placeholder="Enter assignment ID" readonly required>
                    </div>
                    <div class="form-group">
                        <label for="client-id">
                            Client ID
                        </label>
                        <input type="text" name="client_id" class="form-control" id="clientId" placeholder="Enter client ID" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cloneModalCloseBtn">
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


    $(document).ready(function() {
        $('#language-select').select2({
            placeholder: 'Select Languages',
            allowClear: true,
            closeOnSelect: false,
            width: '100%',
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
        // Delete Assignment
        $(document).on('click', '.deleteAssignmentBtn', function() {
            const deleteBtn = $(this);

            // confirm prompt
            if (confirm('Are you sure you want to delete this assignment?')) {
                var assignmentId = deleteBtn.data("id");
                $.ajax({
                    url: '{{ $assignmentsDeleteAction }}'.replace('assignmentIdPlaceholder', assignmentId),
                    type: 'DELETE', // Use DELETE method
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
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


    });
</script>
@endpush