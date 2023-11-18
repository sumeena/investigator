@extends('layouts.dashboard')
@section('title', 'Assignment Details')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="card col-xs-12 assignmentMain p-0">
            <div class="row m-0">
                @php
                $viewProfile = '/company-admin/';
                if (request()->routeIs('hm.assignment.show')) {
                $action = route('hm.find_investigator');
                $assignmentsAction = route('hm.assignments');
                $assignmentCreateAction = route('hm.assignments.create');
                $assignmentEditAction = 'hm.assignments.edit';
                $assignmentShowAction = 'hm.assignment.show';
                $assignmentStoreAction = route('hm.assignments.store');
                $assignmentInviteAction = route('hm.assignments.invite');
                $assignmentSelect2Action = route('hm.select2-assignments');
                $searchStoreAction = route('hm.save-investigator-search-history');
                $viewProfile = '/hm/';
                }

                $usersCount = count($assignment->users);
                @endphp

                <div class="col-md-12 py-3">
                    @if(session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if(session('success') && session('recalled'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                    @endif

                    <div class="card profileData assignment-details">
                        <div class="row">
                            <div class="offset-md-9 col-md-3">
                                <a href="{{$viewProfile}}assignments-list" class="investigator-view-profile-link">
                                    <button type="button" class="btn btn-outline-primary btn-md btn-back">Back</button>
                                </a>
                            </div>
                        </div>
                        <!-- Profile start -->
                        <div class="row row-heading">
                            <!-- <div class="col col-heading col-md-12"> -->
                            <div class="col-md-12 assignment-col">
                                <h5 class="assignment-heading">
                                    Assignment ID: {{ @Str::upper($assignment->assignment_id) }}
                                </h5>
                            </div>

                        </div>
                        <div class="row mx-0 py-1 px-3">
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <b><label>Client ID:</label></b>
                                    </div>
                                    <div class="col-md-6">{{ @Str::upper($assignment->client_id) ?? null ?: 'N/A' }}</div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <b><label>Company:</label></b>
                                    </div>
                                    <div class="col-md-6">{{ @$assignment->author->CompanyAdminProfile->company_name ?? null ?: 'N/A' }}</div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <b><label>Date Received:</label></b>
                                    </div>
                                    <div class="col-md-6">{{ @$assignment->created_at->format('d-m-Y') ?? null ?: 'N/A' }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="row mx-0 py-1 px-3">
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <b><label>Investigation Types:</label></b>
                                    </div>
                                    @php
                                    $investigationTypesArray = array(@$assignment->searchHistory->surveillance, @$assignment->searchHistory->statements, @$assignment->searchHistory->misc);

                                    $investigationTypesArray = array_filter($investigationTypesArray);
                                    $investigationTypes = implode(',',$investigationTypesArray);
                                    @endphp
                                    <div class="col-md-6">{{ @$investigationTypes ?? null ?: 'N/A' }}</div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <b><label>Contact:</label></b>
                                    </div>
                                    <div class="col-md-6">{{ @$assignment->author->first_name.' '.@$assignment->author->last_name ?? null ?: 'N/A' }}</div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <b><label>Job Location:</label></b>
                                    </div>
                                    @php
                                    $jobLocationArray = array(@$assignment->searchHistory->street, @$assignment->searchHistory->city, @$assignment->searchHistory->state, @$assignment->searchHistory->zipcode, @$assignment->searchHistory->country);

                                    $jobLocationArray = array_filter($jobLocationArray);
                                    $jobLocation = implode(',',$jobLocationArray);
                                    @endphp

                                    <div class="col-md-6">{{ @$jobLocation ?? null ?: 'N/A' }}</div>
                                </div>
                            </div>


                        </div>
                        <div class="row mx-0 py-1 px-3">
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <b><label>Language Proficiency:</label></b>
                                    </div>
                                    <div class="col-md-6">
                                        @forelse($languages as $language)
                                        {{$language}}<br>
                                        @empty
                                        N/A
                                        @endforelse
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <b><label>License:</label></b>
                                    </div>
                                    <div class="col-md-6">{{ @$assignment->searchHistory->license->name ?? null ?: 'N/A' }}</div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <b><label>Availability (Date):</label></b>
                                    </div>
                                    @php
                                    $availabilityDate = explode(',', @$assignment->searchHistory->availability);
                                    @endphp
                                    <div class="col-md-6">{{ @$availabilityDate[0] ?? null ?: 'N/A' }}</div>
                                </div>
                            </div>

                        </div>

                        <div class="row mx-0 py-1 px-3">
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <b><label>Availability (Time):</label></b>
                                    </div>
                                    <div class="col-md-6">{{ @$availabilityDate[1] ?? null ?: 'N/A' }}</div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <b><label>Job Status:</label></b>
                                    </div>
                                    <div class="col-md-6 job-status">{{ @$assignment->status ?? null ?: 'N/A' }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="row pt-3">
                            <div class="col col-md-12">
                                <h5 class="">Notes</h5>
                            </div>
                        </div>


                        <div class="row mx-0 py-1 px-3">
                            <div class="form-outline textarea-div col-md-12 pad-a-0">
                                @php
                                $disabled = '';
                                if(@$assignment->status == 'COMPLETED')
                                $disabled = 'disabled';
                                @endphp
                                <textarea rows="5" data-role="{{$viewProfile}}" data-assignmentid="{{ $assignment->id }}" {{$disabled}} class="form-control" id="notesTextArea" name="notes" placeholder="Type notes here..">{{$assignment->notes}}</textarea>
                            </div>
                        </div>

                        <div class="row confirm-div mx-0 py-1 px-3">

                        </div>

                    </div>
                </div>

                </div>
                </div>
    </div>

    <!-- end row -->

    <div class="row">
        <div class="card col-xs-12 assignmentMain p-0">
                        @if($usersCount > 0)
                        <div class="row m-0">
                            <div class="col-md-2 pad-a-0">
                                <div class="card profileData">
                                    @foreach($assignment->users as $user)
                                    @if($user->pivot->hired == 1)
                                    <button type="button" data-user-id="{{ $user->id }}" data-assignment-id="{{ $assignment->id }}" class="btn btn-success btn-users users-list">{{$user->first_name}} {{$user->last_name}} </button>
                                    @else
                                    <button type="button" data-user-id="{{ $user->id }}" data-assignment-id="{{ $assignment->id }}" class="btn btn-outline-secondary btn-users users-list">{{$user->first_name}} {{$user->last_name}}</button>
                                    @endif
                                    @endforeach
                                    </ul>
                                </div>
                            </div>

                            <div class=" {{ $usersCount > 0 ? 'col-md-10' : 'col-md-12' }} py-3">
                                @if(session('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('success') }}
                                </div>
                                @endif

                                <div class="card profileData assignment-details">
                                    <div class="row pt-3 message-heading d-none">
                                        <div class="col col-md-12">
                                            <h5 class="">
                                                Messages
                                                <a href="" data-role="{{$viewProfile}}" target="_blank" class="btn btn-outline-light btn-md m-l-20 view-investigator-profile">View Profile</a>

                                                <a data-role="{{$viewProfile}}" href="javascript:void(0)" class="btn btn-outline-light btn-md m-l-20 hire-user btn-hire-now"></a>
                                            </h5>
                                        </div>
                                    </div>

                                    <div class="row mx-0 py-1 px-3">

                                        <div class="chat-frame">

                                        </div>

                                    </div>
                                    
                                </div>

                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="modal fade" id="showAttachment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document" style="width:300px; height:200px">
                        <div class="modal-content">
                            <div class="modal-header">

                                <h5 class="modal-title w-100 text-center" id="exampleModalLabel">
                                    Attachment
                                </h5>

                            </div>
                            <!--Modal body with image-->
                            <div class="modal-body text-center attachment-src"></div>
                            <div class="modal-footer" style="margin: 0 auto;">
                                <!-- <small class="error">jpg, jpeg, png, docx, ppt are allowed</small> -->
                                <button type="button" class="btn btn-primary send-attachment" data-dismiss="modal"> <i class="fa-solid fa-paper-plane"></i> </button>
                                <button type="button" class="btn btn-danger close" data-dismiss="modal"> <i class="fa fa-times"></i> </button>
                            </div>
                        </div>
                    </div>
                </div>

                @endsection
