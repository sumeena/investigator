@extends('layouts.dashboard')
@section('title', 'Profile')
@section('content')

<?php
$calendars = array();
if (isset($profile['calendars']))
  $calendars = $profile['calendars'];
?>
<div class="row mt-4 mb-4">
  <div class="col-md-1"></div>
  <div class="col-md-10">
    <div class="card mb-4">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Calendar</h5>
        @if(!$googleAuthDetails && !$nylasUser)
        <button type="button" data-toggle="modal" data-target="#sync-calendar" class="float-end btn btn-outline-primary btn-sm mt-n1 mr-10">Sync Calendar</button>
        @endif
        <button type="button" data-toggle="modal" data-target="#update-calendar" class="float-end d-none btn btn-outline-primary btn-sm mt-n1 mr-10 update-calender-button">Update Calendar</button>
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

        <input type="hidden" class="nylas-user" value="{{$nylasUser}}">
        <input type="hidden" class="calendar-events" value="{{$calendarEvents}}">
        <input type="hidden" class="google-auth-user" value="{{$googleAuthDetails}}">
        @if(session('success'))
        <div class="alert alert-success" role="alert">
          {{ session('success') }}
        </div>
        @endif

        <div class="calendar" id="calendar"></div>
      </div>
    </div>
  </div>
  <div class="col-md-1"></div>
</div>

@include('investigator.calendar-sync-modal')

@if(!$nylasUser || !$calendarEvents)
@include('investigator.select-calendar-modal')
@endif


<div class="modal" id="update-calendar" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="width:50%">
      <div class="modal-header">
        <h5 class="modal-title">Are you sure, you want to update your calendar?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <button class="btn btn-success update-calendar-yes-btn">Yes</button>
        <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close">No</button>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>

@endsection
@push('scripts')
<script>
  $(document).ready(function() {
    var nylasUserValue = $('.nylas-user').val();
    var calendarEventsValue = $('.calendar-events').val();
    var googleAuthUserValue = $('.google-auth-user').val();
    if (googleAuthUserValue && (!nylasUserValue || !calendarEventsValue))
      $('#calendars-list').modal('show');
  })
</script>
@endpush