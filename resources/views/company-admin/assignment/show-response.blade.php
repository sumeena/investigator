@if(isset($messages))
    @forelse($messages->sortBy('created_at') as $message)

    @if($message->user_id == $authUserId)
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

    <div class="alert alert-secondary" role="alert">
        No messages
    </div>

    @endforelse
    @endif

    <div class="row mb-3 send-msg-box">
        @php
            $disabled = '';
            if($userAssignmentStatus == 'ASSIGNED')
            $disabled = '';
        @endphp

        <input type="hidden" value="{{$hiredUser[0]}}" class="hired-user">
        <div class="form-outline textarea-div col-md-11 pad-a-0">
            <textarea {{$disabled}} data-chat-id="{{$chat[0]}}" class="form-control" id="messageTextArea" placeholder="Type your message"></textarea>
        </div>
        <div class="col-md-1 pad-a-0 text-center">
            <!-- <div class="start-chat-btn position-relative"> -->
            @if(auth()->user()->userRole && auth()->user()->userRole->role == 'company-admin')
            <input type="file" data-chat-id="{{$chat[0]}}" name="attachment" id="attachment" class="attachment">
            <button type="button" class="btn btn-warning btn-rounded btn-icon mt-2 btn-sm attachment-button" {{$disabled}} id="attachment-button">
                <i class="fa-solid fa-paperclip"></i>
            </button>

            <button type="button" {{$disabled}} data-no-attachment-action="/company-admin/assignment/send-user-msg" data-attachment-action="/company-admin/assignment/send-attachment" class="btn btn-primary btn-rounded btn-icon mt-2 btn-sm sendMessageFromAssignment">
                <i class="fa-solid fa-paper-plane"></i>
            </button>
            @else
            <input type="file" data-chat-id="{{$chat[0]}}" name="attachment" id="attachment" class="attachment">
            <button type="button" class="btn btn-warning btn-rounded btn-icon mt-2 btn-sm attachment-button" {{$disabled}} id="attachment-button">
                <i class="fa-solid fa-paperclip"></i>
            </button>

            <button type="button" {{$disabled}} data-no-attachment-action="/hm/assignment/send-user-msg" data-attachment-action="/hm/assignment/send-attachment" class="btn btn-primary btn-rounded btn-icon mt-2 btn-sm sendMessageFromAssignment">
                <i class="fa-solid fa-paper-plane"></i>
            </button>
            @endif

        </div>
    </div>
