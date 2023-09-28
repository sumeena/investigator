$(document).ready(function(){

    if($('.users-list').length > 0) {
        setTimeout(() => {
            $('.btn-users:first-child').click();
        }, 1000);
    }

    $(document).on('click', '.attachment-button', function() {
        $('.attachment').click();
    });

    $(document).on('change', '.attachment', function(e) {

        var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif|\.doc|\.docx|\.pdf|\.xls|\.xlsx|\.csv)$/i;
        var filePath = $(this).val();
             
            if (!allowedExtensions.exec(filePath)) {
                alert('Invalid file type');
                $(this).val('');
                return false;
            }

        for (var i = 0; i < e.originalEvent.srcElement.files.length; i++) {
            
            var file = e.originalEvent.srcElement.files[i];

            var renderedFile = '';

            if(file.type == 'image/png' || file.type == 'image/jpg' || file.type == 'image/jpeg' || file.type == 'image/gif') {
                renderedFile = document.createElement("img");
                var reader = new FileReader();
                reader.onloadend = function() {
                    renderedFile.src = reader.result;
                    renderedFile.width = '200';
                    renderedFile.addClass = 'img-css';
                }
                reader.readAsDataURL(file);
            }
            else {
                renderedFile = '<i class="fa-solid fa-file-arrow-up fa-6x"></i>';
            }
            $('.attachment-src').html(renderedFile);
            $('#showAttachment').modal('show');
        }
    });

    $(document).on('click', '.send-attachment', function() {
        var formData = new FormData();
        // var uploadedFile = $('#attachment').files[0];
        var uploadedFile = $(".attachment").prop("files")[0];
        var chatId = $('.attachment').data('chat-id');
        var action = $('.sendMessageFromAssignment').data('attachment-action');
        formData.append('file', uploadedFile);
        formData.append('chat_id', chatId);

        $.ajax({
            url : action,
            type : 'POST',
            data : formData,
            processData: false, // important
            contentType: false, // important
            success : function(data) {
                $(".attachment").val('');
            },
            complete : function(data){
                var file = '';

                if(data.responseJSON.ext == 'png' || data.responseJSON.ext == 'jpg' || data.responseJSON.ext == 'jpeg' || data.responseJSON.ext == 'gif')
                    file = '<img src="'+data.responseJSON.attachment+'" width="200" >';
                else
                    file = '<i class="fa-solid fa-file-arrow-up fa-6x"></i>';

                $('#showAttachment').modal('hide');
                $('.send-msg-box').before(`<div class="d-flex flex-row justify-content-end mb-4">
                    <p class="mb-0">`+file+`</p>
                 </div><div class="d-flex flex-row justify-content-end mb-4"> <p class="success-msg small"> Message Sent </p> </div> `);
                $(".success-msg").fadeOut(1500);
            }
        });
    });

      

      var eMinDate = $('input[name="e_datetimes"]').data('min-date');
      var etimeStart = $('.e-timepickerstart').data('start-time');
      var etimeEnd = $('.e-timepickerend').data('end-time');

      $('input[name="e_datetimes"]').daterangepicker({
        minDate: eMinDate,
        opens: 'left'
      });

      var startTimeOptions = { twentyFour: true, now : etimeStart };
      var endTimeOptions = { twentyFour: true, now : etimeEnd };

      $('.timepickerstart, .e-timepickerstart').wickedpicker(startTimeOptions);
      $('.timepickerend, .e-timepickerend').wickedpicker(endTimeOptions);

      $('input[name="datetimes"]').daterangepicker({
        minDate:moment().format('MM/DD/YYYY'),
        opens: 'left'
      });
      

    $(document).on('click', '.close-calendars-list-modal',function() {
        $('#calendars-list').modal('hide');
    });

    $(document).on('click', '.close',function() {
        $('#showAttachment').modal('hide');
    });

    $('.disconnect-yes-btn').click(function() { // disconnect google sync
        $.ajax({
            url : '/investigator/disconnect-calendar',
            method : 'delete',
            success : function(data) {
                location.reload();
            }
        })
    });


    $(document).on('keypress','#messageTextArea', function() { 
        $(this).removeClass('empty-error');
     })

    /** Send msg from assignment */

    $(document).on('click', '.sendMessageFromAssignment', function() {
        
        var msgContent = $('#messageTextArea').val();
        var chatId = $('#messageTextArea').data('chat-id');
        var action = $(this).data('no-attachment-action');

        if(!msgContent) {
            $('#messageTextArea').addClass('empty-error')
            return false;
        }

        $.ajax({
            url : action,
            method : 'POST',
            data : { message : msgContent, chat_id : chatId },
            success : function(data) {
                $('#messageTextArea').val('');  
            },
            complete : function(){
                $('.send-msg-box').before(`<div class="d-flex flex-row justify-content-end mb-4">
                <div class="p-3 border send-msg">
                    <p class="mb-0">`+msgContent+`</p>
                </div> </div><div class="d-flex flex-row justify-content-end mb-4"> <p class="success-msg small"> Message Sent </p> </div> `);
                $(".success-msg").parent('div').fadeOut(1500);
                setTimeout(() => {
                    $(".success-msg").parent('div').remove();
                }, 1500);
            }
        })
    });

    $(document).on('click', '.users-list', function() {
        $(".users-list").removeClass("active");
        $(this).addClass("active");
        var userId = $(this).data('user-id');
        var assignmentId = $(this).data('assignment-id');
        var assignmentStatus = $('.job-status').html();
        $('.view-investigator-profile').attr('href','/company-admin/investigators/'+userId+'/view')
        $.ajax({
            url: '/company-admin/assignment/fetchAssignmentUser',
            data : { user_id : userId, assignment_id: assignmentId },
            success : function(response) {
                $('.message-heading').removeClass('d-none');
                $('.chat-frame').html(response.data);

                $('#notesTextArea').val(response.notes);
                $('#notesTextArea').data('userid',userId);
                $('#notesTextArea').data('assignmentid',assignmentId);

                /* $('.hire-user').html('<button data-user-id="'+userId+'" data-assignment-id="'+assignmentId+'" type="button" class="btn btn-outline-light btn-sm btn-hire-now">ASSIGN NOW</button>'); */
                if(assignmentStatus == 'INVITED') {
                    $('.hire-user').data('user-id',userId).data('assignment-id',assignmentId).removeClass('d-none').html('ASSIGN NOW');
                }
                else {
                    var hiredUser = $('.hired-user').val();
                    if(hiredUser == userId) {
                        $('.hire-user').removeClass('btn-hire-now btn-outline-light').addClass('btn-hired btn-light').removeClass('d-none').html('ASSIGNED');
                        // $('.hire-user').html('<button type="button" class="btn btn-light btn-sm btn-hired">ASSIGNED</button>');
                    }
                    else
                    $('.hire-user').addClass('d-none');
                }
                
            }
        })
  
    });

    $(document).on('keyup', '#notesTextArea', function(){
        $('.confirm-div').html('<div class="col-md-1"><button type="button" class="btn btn-success btn-notes-check"><i class="fa fa-check fa-lg"></i></button></div> <div class="col-md-1"><button type="button" class="btn btn-danger btn-notes-cancel"><i class="fa fa-times fa-lg"></i></button></div>');
    });

    $(document).on('click', '.btn-notes-cancel', function() {
        var userId = $('#notesTextArea').data('userid');
        var assignmentId = $('#notesTextArea').data('assignmentid');
        $.ajax({
            url : '/company-admin/assignment/get-notes',
            method : 'GET',
            data : { assignment_id:assignmentId },
            success : function(data) {
                $('#notesTextArea').val(data.notes);
                $('.confirm-div').html('');
            }
        });
    });


    $(document).on('click', '.btn-notes-check', function() {
        var notesTextArea = $(this).parents('.confirm-div').prev('div.row').children('div').children('textarea#notesTextArea');
        var notes =notesTextArea.val();
        // var notes_user_id =notesTextArea.data('userid');
        var notes_assignment_id =notesTextArea.data('assignmentid');
        $.ajax({
            url : '/company-admin/assignment/save-notes',
            method : 'POST',
            data : { notes:notes, assignment_id:notes_assignment_id },
            success : function(data) {
                $('.confirm-div').html('<p class="success-msg">Notes updated</p>');
                setTimeout(() => {
                    $('.confirm-div p').fadeOut();
                }, 2000);
            }
        })
    });


    $(document).on('click', '.btn-hire-now', function() {
        $(this).html('Assigning...').css('pointer-events','none');
        var userId = $(this).data('user-id');
        var assignmentId = $(this).data('assignment-id');

        $.ajax({
            url: '/company-admin/assignment/hire-now',
            method : 'POST',
            data : { user_id : userId, assignment_id: assignmentId },
            success : function(response) {
                location.reload();
                /* $('.hire-user').html('<button data-user-id="'+userId+'" data-assignment-id="'+assignmentId+'" type="button" class="btn btn-light btn-sm btn-hired">Hired</button>');
                $('.job-status').html('HIRED'); */
            }
        })
    });


    /** clone assignment module start */
    $(document).on('click', '.callCloneAssignmentModal', function() {

        var assignmentUrl = $(this).data('assignment-url');
        var assignmentId = $(this).data('assignment-id');
        var clientId = $(this).data('client-id');

        $.ajax({
            url: assignmentUrl,
            type: 'GET',
            success: function(response) {
                $('#assignmentId').val(response.data.assignment_id);
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
        
        $('#clientId').val(clientId);
        $('#sourceAssignmentId').val(assignmentId);
        $('#cloneAssignmentModal').modal('show');
    });


    $('#assignmentCloneForm').on('submit', function(e) {

        e.preventDefault();

        var assignmentId = $('#assignmentId');
        var sourceAssignmentId = $('#sourceAssignmentId');
        var clientId = $('#clientId');

        var formAction = $(this).attr('action');

        var assignmentIdVal = assignmentId.val();
        var clientIdVal = clientId.val();
        var sourceAssignmentIdVal = sourceAssignmentId.val();

        var data = {
            assignment_id: assignmentIdVal,
            old_assignment_id : sourceAssignmentIdVal,
            client_id: clientIdVal,
            type : 'clone'
        };

        $.ajax({
            url: formAction,
            method: 'POST',
            data: data,
            success: function(response) {
                window.location.replace(response);
                // window.location.href="/company-admin/assignments/"+response.assignmentID+"/edit";
                /* $('#assignment-flash').text(response.message);
                $('#assignment-flash').show();
                fetchAssignmentData({
                    page: 1
                });
                $('#assignmentCreateModal').modal('hide'); */
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    });


    $(document).on('click', '#cloneModalCloseIconBtn, #cloneModalCloseBtn', function(){
        $('#cloneAssignmentModal').modal('hide');
        $('#assignmentCloneForm')[0].reset();
    });

});


function checkGoogleAccessToken() {
    $.ajax({
        url : "/investigator/checkToken",
        success : function(data) {
            // console.log(data);
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {

    var calendarEl = document.getElementById('calendar');
    if(calendarEl) {
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
        });
        calendar.render();
    }


    var currentURL = window.location.href;
    var checkURL = currentURL.includes('/investigator/');

    if(checkURL)
    fetchEvents();

    $('.sync-btn').click(function(e) {
        e.preventDefault();
        var selectedCalendar = $('.select-calendar').val();

        $.ajax({
            url: '/investigator/calendar/fetch-events',
            data: {
                calendar_id: selectedCalendar
            },
            method: 'POST',
            success: function(data) {
                $('#calendars-list').modal('hide');
                $('.update-calender-button').removeClass('d-none');
                var events = JSON.parse(data);

                var source = {
                    events: events
                };

                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    events: source,
                    dayMaxEvents: 3
                });
                calendar.render();

                
            }
        });

    });

    $('.update-calendar-yes-btn').click(function() {
        $.ajax({
            url : 'remove-events',
            method : 'delete',
            success : function(data) {
                location.reload();
            }
        })
    });
  
});

function fetchEvents() {
    $.ajax({
        url: '/investigator/calendar/fetch-events-onload',
        method: 'GET',
        success: function(data) {
            console.log(data);
            if(data) {
            var events = JSON.parse(data);
            if(events.length > 0)
            $('.update-calender-button').removeClass('d-none');
            var source = {
                events: events
            };
            var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    events: source,
                    dayMaxEvents: 3
                });
                calendar.render();
            }
        }
    });
}