@extends('layouts.dashboard')
@section('title', 'Assignment Details')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-12">
            @if(session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
            @endif

            <!-- {{$assignmentUser}} -->

            <div class="card profileData">
                <!-- Profile start -->
                <div class="row">
                    <div class="col">
                        <h5 class="">
                            Assignment ID: {{ @Str::upper($assignmentUser->assignment->assignment_id) }}

                            <a href="javascript:history.back()" class="investigator-view-profile-link">
                                <button type="button" class="pull-right btn btn-outline-light btn-sm">Back</button>
                            </a>

                            @if($assignmentUser->hired == 1)
                            <a style="margin-right: 20px;" href="javascript:void(0)" class="hire-user investigator-view-profile-link">
                                <button type="button" class="btn btn-light btn-sm btn-hired">ASSIGNED</button>
                            </a>
                            @endif

                            @if($assignmentUser->status == 'OFFER RECEIVED')
                                <a style="margin-right: 500px;" href="{{route('investigator.assignment.confirmation',[$assignmentUser->id,'REJECTED'])}}" class="investigator-view-profile-link"><button type="button" class="btn btn-outline-light btn-sm">Reject</button></a>

                                <a  href="{{route('investigator.assignment.confirmation',[$assignmentUser->id,'ACCEPTED'])}}" class="investigator-view-profile-link"><button type="button" class="btn btn-outline-light btn-sm">Accept</button></a>
                            @endif

                        </h5>
                    </div>
                </div>
                <div class="row mx-0 py-1 px-3">
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-6">
                                <b><label>Client ID:</label></b>
                            </div>
                            <div class="col-md-6">{{ @Str::upper($assignmentUser->assignment->client_id) ?? null ?: 'N/A' }}</div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-6">
                                <b><label>Company:</label></b>
                            </div>
                            <div class="col-md-6">
                                @php
                                    if($assignmentUser->assignment->author->parentCompany != null)
                                    {
                                    $company_name = $assignmentUser->assignment->author->parentCompany->company->CompanyAdminProfile->company_name;
                                    }
                                    else
                                    $company_name = $assignmentUser->assignment->author->CompanyAdminProfile->company_name;
                                @endphp
                                {{ @$company_name ?? null ?: 'N/A' }}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-6">
                                <b><label>Date Received:</label></b>
                            </div>
                            <div class="col-md-6">{{ @$assignmentUser->created_at->format('d-m-Y') ?? null ?: 'N/A' }}</div>
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
                                $investigationTypesArray = array(@$assignmentUser->assignment->searchHistory->surveillance, @$assignmentUser->assignment->searchHistory->statements, @$assignmentUser->assignment->searchHistory->misc);

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
                            <div class="col-md-6">{{ @$assignmentUser->assignment->author->first_name.' '.@$assignmentUser->assignment->author->last_name ?? null ?: 'N/A' }}</div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-6">
                                <b><label>Job Location:</label></b>
                            </div>
                            @php
                                $jobLocationArray = array(@$assignmentUser->assignment->searchHistory->street, @$assignmentUser->assignment->searchHistory->city, @$assignmentUser->assignment->searchHistory->state, @$assignmentUser->assignment->searchHistory->zipcode, @$assignmentUser->assignment->searchHistory->country);
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
                            <div class="col-md-6">{{ @$assignmentUser->assignment->searchHistory->license->name ?? null ?: 'N/A' }}</div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-6">
                                <b><label>Availability (Date):</label></b>
                            </div>
                            @php
                            $availabilityDate = explode(',', @$assignmentUser->assignment->searchHistory->availability);
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
                            @php
                                $status = '';
                                if($assignmentUser->hired == 0 && ( $assignmentUser->assignment->status == 'INVITED')) {
                                    $status = $assignmentUser->status;
                                }
                                else if($assignmentUser->hired == 0 && ($assignmentUser->status == 'OFFER RECEIVED' || $assignmentUser->status == 'OFFER REJECTED' || $assignmentUser->status == 'OFFER CANCELLED' || $assignmentUser->status == 'INVITED')) {
                                    $status = $assignmentUser->status;
                                }
                                else if($assignmentUser->hired == 1) {
                                    $status = $assignmentUser->status;
                                }
                                else if($assignmentUser->hired == 0 && $assignmentUser->assignment->status == 'ASSIGNED')
                                {
                                    $status = 'CLOSED';
                                }
                            @endphp
                            <div class="col-md-6">{{ @$status ?? null ?: 'N/A' }}</div>
                        </div>
                    </div>
                </div>

                <div class="row pt-3">
                    <div class="col col-md-12">
                        <h5 class="">Messages
                        </h5>
                    </div>
                </div>

                <div class="row mx-0 py-1 px-3">

                    <div class="chat-frame">
                        @if(isset($chats))
                        @forelse($chats[0]->chatUsers->sortBy('created_at') as $message)

                        @if($message->user_id != $authUserId)
                        <div class="d-flex flex-row justify-content-start mb-4">
                            @if($message->type == 'media')
                            @if(isset($message['media'][0]->file_ext))
                            <p class="mb-0">
                                <a href="{{ env('APP_URL')}}{{$message->content}}" download>
                                    @if( $message['media'][0]->file_ext == 'png' || $message['media'][0]->file_ext == 'jpg' || $message['media'][0]->file_ext == 'jpeg' || $message['media'][0]->file_ext == 'gif')
                                    <img title="{{$message['media'][0]->file_name}}" alt="{{$message['media'][0]->file_name}}" src="{{ env('APP_URL')}}{{$message->content}}" width="200">
                                    @else
                                    <i title="{{$message['media'][0]->file_name}}" class="fa-solid fa-file-arrow-up fa-6x"></i>
                                    @endif
                                </a>
                            </p>
                            @endif
                            @else
                            <div class="p-3 receive-msg">
                                <p class="mb-0">
                                    {{$message->content}}
                                </p>
                            </div>
                            @endif
                        </div>
                        @else
                        <div class="d-flex flex-row justify-content-end mb-4">
                            @if($message->type == 'media')
                            @if(isset($message['media'][0]->file_ext))
                            <p class="mb-0">
                                <a href="{{ env('APP_URL')}}{{$message->content}}" download>
                                    @if( $message['media'][0]->file_ext == 'png' || $message['media'][0]->file_ext == 'jpg' || $message['media'][0]->file_ext == 'jpeg' || $message['media'][0]->file_ext == 'gif')
                                    <img title="{{$message['media'][0]->file_name}}" alt="{{$message['media'][0]->file_name}}" src="{{ env('APP_URL')}}{{$message->content}}" width="200">
                                    @else
                                    <i title="{{$message['media'][0]->file_name}}" class="fa-solid fa-file-arrow-up fa-6x"></i>
                                    @endif
                                </a>
                            </p>
                            @endif
                            @else
                            <div class="p-3 border send-msg">
                                <p class="mb-0">
                                    {{$message->content}}
                                </p>
                            </div>
                            @endif
                        </div>
                        @endif

                        @empty

                        <div class="alert alert-secondary attachment-src" role="alert">
                            No messages
                        </div>

                        @endforelse
                        @endif

                        @php
                        $disabled = 'disabled';
                        if(($assignmentUser->status == 'INVITED' && $assignmentUser->assignment->status == 'INVITED') || ($assignmentUser->status == 'OFFER RECEIVED') || ($assignmentUser->status == 'INVITED' && $assignmentUser->assignment->status == 'OFFER REJECTED') || ($assignmentUser->status == 'INVITED' && $assignmentUser->assignment->status == 'OFFER CANCELLED') || ($assignmentUser->status == 'ASSIGNED' && $assignmentUser->assignment->status == 'ASSIGNED'))
                        $disabled = '';
                        @endphp

                        <div class="row mb-3 send-msg-box">
                            <div class="form-outline textarea-div col-md-11 pad-a-0">
                                <textarea {{$disabled}} data-chat-id="{{$chats[0]->id}}" class="form-control" id="messageTextArea" placeholder="Type your message"></textarea>
                            </div>
                            <div class="col-md-1 pad-a-0 text-center">
                                <!-- <div class="start-chat-btn position-relative"> -->
                                <input type="file" data-chat-id="{{$chats[0]->id}}" name="attachment" id="attachment" class="attachment">
                                <button {{$disabled}} type="button" class="btn btn-warning btn-rounded btn-icon mt-2 btn-sm attachment-button" id="attachment-button">
                                    <i class="fa-solid fa-paperclip"></i>
                                </button>

                                <button {{$disabled}} data-no-attachment-action="/investigator/assignment/send-msg" data-attachment-action="/investigator/assignment/send-attachment" type="button" class="btn btn-primary btn-rounded btn-icon mt-2 btn-sm sendMessageFromAssignment">
                                    <i class="fa-solid fa-paper-plane"></i>
                                </button>
                                <!-- <input class="form-control bg-info text-white border-0 p-2" type="button" name="" value="Start Chat"> -->
                                <!-- </div> -->
                            </div>
                        </div>


                    </div>


                </div>

            </div>

        </div>
    </div>
</div>
</div>


<div class="modal fade showAttachment" id="showAttachment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="width:300px; height:200px">
        <div class="modal-content">
            <div class="modal-header">
                <!-- w-100 class so that header
                div covers 100% width of parent div -->
                <h5 class="modal-title w-100 text-center" id="exampleModalLabel">
                    Attachment
                </h5>

            </div>
            <!--Modal body with image-->
            <div class="modal-body text-center attachment-src">

            </div>
            <div class="modal-footer" style="margin: 0 auto;">
                <button type="button" class="btn btn-primary send-attachment"> <i class="fa-solid fa-paper-plane"></i> </button>
                <button type="button" class="btn btn-danger close" data-dismiss="modal"> <i class="fa fa-times"></i> </button>
            </div>
        </div>
    </div>
</div>

@endsection