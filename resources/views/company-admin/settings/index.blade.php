@extends('layouts.dashboard')
@section('title', "Notification for Investigator")
@section('content')
<div class="row mt-4 mb-4 mx-0 justify-content-center">
    <div class="col-md-10">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Notification for Investigator</h5>
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
                <form method="post" action="{{ route('company-admin.settings.store') }}" enctype="multipart/form-data">
                    @csrf
                    <hr>
                    <h6 class="mb-0">Notification for Email</h6>
                    <hr>
                    <div class="row">

                        <div class="col-md-12">
                            <div class="mb-3">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">New Message on assignments
                                        <label class="switch ">
                                            <input name="new_message" type="checkbox" value="1" class="primary" {{isset($settings->new_message) ? 'checked':'' }}>
                                            <span class="slider round"></span>
                                        </label>
                                    </li>

                                    <li class="list-group-item">Assignment status updates
                                        <label class="switch ">
                                            <input name="assignment_confirmation" type="checkbox" value="1" class="primary" {{isset($settings->assignment_confirmation) ? 'checked':'' }}>
                                            <span class="slider round"></span>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                        </div>

                    </div>
                    <hr>
                    <h6 class="mb-0">Notification for SMS</h6>
                    <hr>
                    <div class="row">

                        <div class="col-md-12">
                            <div class="mb-3">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">New Message on assignments
                                        <label class="switch ">
                                            <input name="new_message_on_message" type="checkbox" value="1" class="primary" {{isset($settings->new_message_on_message) ? 'checked':'' }}>
                                            <span class="slider round"></span>
                                        </label>
                                    </li>
                                    <li class="list-group-item">Assignment status updates
                                        <label class="switch ">
                                            <input name="assignment_confirmation_on_message" type="checkbox" value="1" class="primary" {{isset($settings->assignment_confirmation_on_message) ? 'checked':'' }}>
                                            <span class="slider round"></span>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                        </div>

                    </div>
                    <hr>
                    <button type="submit" class="btn btn-primary">
                        {{ 'Update' }}
                    </button>
                    <input type="hidden" class="form-check-input" name="id" value="{{isset($settings->id) ? $settings->id:'' }}">
                </form>
            </div>
        </div>
    </div>
</div>



@endsection
