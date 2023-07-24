@extends('layouts.dashboard')
@section('title', 'Profile')
@section('content')

<?php

  $calendars = array();
  if(isset($profile['calendars']))
  $calendars = $profile['calendars'];
?>
<div class="row mt-4 mb-4">
  <div class="col-md-1"></div>
  <div class="col-md-10">
    <div class="card mb-4">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Calendar</h5>
      </div>

      <div class="card-body">
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

@if(!$nylasUser)
@include('investigator.select-calendar-modal')
@endif

@endsection
@push('scripts')
<script>
  $(document).ready(function(){
    $('#calendars-list').modal('show');
  })
</script>
@endpush