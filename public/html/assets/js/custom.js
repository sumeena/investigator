$(document).ready(function () {
    //   setInterval(function() { latestNotification() }, 2000);
    //latestNotification()
    timepicker()
    resetPassword("#password");
    resetPassword("#new-password");
    miscTypeahead();
    if ($('.users-list').length > 0) {
        setTimeout(() => {
            $('.btn-users:first-child').click();
        }, 1000);
    }

    $(document).on('click', '.attachment-button', function () {
        $('.attachment').click();
    });
    $(document).on('click', '.assignment_accepted', function () {
        $('.custom-loader-overlay').attr("style", "display: flex !important");
    });
    $(document).on('click', '.assignment_rejected', function () {
        $('.custom-loader-overlay').attr("style", "display: flex !important");
    });

    $(document).on('change', '.attachment', function (e) {

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

            if (file.type == 'image/png' || file.type == 'image/jpg' || file.type == 'image/jpeg' || file.type == 'image/gif') {
                renderedFile = document.createElement("img");
                var reader = new FileReader();
                reader.onloadend = function () {
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

    $(document).on('click', '.send-attachment', function () {
        var formData = new FormData();
        // var uploadedFile = $('#attachment').files[0];
        var uploadedFile = $(".attachment").prop("files")[0];
        var chatId = $('.attachment').data('chat-id');
        var action = $('.sendMessageFromAssignment').data('attachment-action');
        formData.append('file', uploadedFile);
        formData.append('chat_id', chatId);

        $.ajax({
            url: action,
            type: 'POST',
            data: formData,
            processData: false, // important
            contentType: false, // important
            success: function (data) {
                $(".attachment").val('');
            },
            complete: function (data) {
                var file = '';

                if (data.responseJSON.ext == 'png' || data.responseJSON.ext == 'jpg' || data.responseJSON.ext == 'jpeg' || data.responseJSON.ext == 'gif')
                    file = '<img src="' + data.responseJSON.attachment + '" width="200" >';
                else
                    file = '<i class="fa-solid fa-file-arrow-up fa-6x"></i>';

                $('#showAttachment').modal('hide');
                $('.send-msg-box').before(`<div class="d-flex flex-row justify-content-end mb-4">
                    <p class="mb-0">`+ file + `</p>
                 </div><div class="d-flex flex-row justify-content-end mb-4"> <p class="success-msg small"> Message Sent </p> </div> `);
                $(".success-msg").fadeOut(1500);
            }
        });
    });



    // var eMinDate = $('input[name="e_datetimes"]').data('min-date');
    // var etimeStart = $('.e-timepickerstart').data('start-time');
    // var etimeEnd = $('.e-timepickerend').data('end-time');
    //
    // $('input[name="e_datetimes"]').daterangepicker({
    //   minDate: eMinDate,
    //   opens: 'left'
    // });
    //
    // var startTimeOptions = { twentyFour: true, now : etimeStart };
    // var endTimeOptions = { twentyFour: true, now : etimeEnd };
    //
    // $('.timepickerstart, .e-timepickerstart').wickedpicker(startTimeOptions);
    // $('.timepickerend, .e-timepickerend').wickedpicker(endTimeOptions);
    //
    // $('input[name="datetimes"]').daterangepicker({
    //   minDate:moment().format('MM/DD/YYYY'),
    //   opens: 'left'
    // });


    $(document).on('click', '.close-calendars-list-modal', function () {
        $('#calendars-list').modal('hide');
    });

    $(document).on('click', '.close', function () {
        $('#showAttachment').modal('hide');
    });

    $('.disconnect-yes-btn').click(function () { // disconnect google sync
        $.ajax({
            url: '/investigator/disconnect-calendar',
            method: 'delete',
            success: function (data) {
                location.reload();
            }
        })
    });


    $(document).on('keypress', '#messageTextArea', function () {
        $(this).removeClass('empty-error');
    });


    /** on click of misc checkbox */

    /* $(document).on('change', '.misc-checkbox', function() {
        if($(this).prop('checked')){
            cloneRow();
            $('.add-more-rows').parents('tr').removeClass('d-none');
        }
    }) */

    if($('.miscellaneous-checkbox').prop('checked'))
    {
        $('.add-more-rows').parents('tr').removeClass('d-none');
    }

    $(document).on('change', '.miscellaneous-checkbox', function() {
        if(!$(this).prop('checked'))
        {
            $('.each-misc-row').remove();
            $('.miscellaneous-checkbox').addClass('misc-checkbox');
            $('.add-more-rows').parents('tr').addClass('d-none');
        }
        else {
            cloneRow();
            $('.add-more-rows').parents('tr').removeClass('d-none');
        }

        $('.typeahead').typeahead('destroy');
        miscTypeahead();
    })

    $(document).on('click', '.add-misc-row', function() {
        cloneRow();
        $('.miscellaneous-checkbox').prop('checked',true);
        $('.typeahead').typeahead('destroy');
        miscTypeahead();
    })

    $(document).on('click', '.remove-misc-row', function() {
        $(this).parents('tr').remove();
        var miscRowsLength = $('.each-misc-row').length;

        if(!miscRowsLength || miscRowsLength <= 0)
        {
            $('.miscellaneous-checkbox').prop('checked',false);
            $('.miscellaneous-checkbox').addClass('misc-checkbox');
            $('.add-more-rows').parents('tr').addClass('d-none');
        }
        $('.typeahead').typeahead('destroy');
        miscTypeahead();
    });


    /** on click of misc checkbox */

    /** Send msg from assignment */

    $(document).on('click', '.sendMessageFromAssignment', function () {

        var msgContent = $('#messageTextArea').val();
        var chatId = $('#messageTextArea').data('chat-id');
        var action = $(this).data('no-attachment-action');

        if (!msgContent) {
            $('#messageTextArea').addClass('empty-error')
            return false;
        }

        $('.custom-loader-overlay').attr("style", "display: flex !important");

        $.ajax({
            url: action,
            method: 'POST',
            data: { message: msgContent, chat_id: chatId },
            success: function (data) {
                if (data.error) {
                    alert(data.message)
                }
                $('#messageTextArea').val('');
            },
            complete: function () {
                $('.send-msg-box').before(`<div class="d-flex flex-row justify-content-end mb-4">
                <div class="p-3 border send-msg">
                    <p class="mb-0">`+ msgContent + `</p>
                </div> </div><div class="d-flex flex-row justify-content-end mb-4"> <p class="success-msg small"> Message Sent </p> </div> `);
                $(".success-msg").parent('div').fadeOut(1500);
                setTimeout(() => {
                    $(".success-msg").parent('div').remove();
                }, 1500);
                $('.custom-loader-overlay').hide();
            }
        })
    });

    $(document).on('click', '.select-all-investigators', function () {
        $('.send-invite-checkbox').not(":disabled").prop('checked', this.checked);
        var allCheckedUsers = [];
        $(".send-invite-checkbox:checked").each(function () {
            allCheckedUsers.push($(this).data('userid'));
        });

        if(allCheckedUsers.length > 0)
        $('.btn-send-invites').removeClass('d-none');
        else
        $('.btn-send-invites').addClass('d-none');

        $('.selected-investigators').val(allCheckedUsers);
    });

    $(document).on('change', '.send-invite-checkbox', function () {
        var allCheckedUsers = [];
        $(".send-invite-checkbox:checked").each(function () {
            allCheckedUsers.push($(this).data('userid'));
        });

        if(allCheckedUsers.length > 0)
        $('.btn-send-invites').removeClass('d-none');
        else {
            $('.select-all-investigators').prop('checked',false);
            $('.btn-send-invites').addClass('d-none');
        }
        $('.selected-investigators').val(allCheckedUsers);
    });

    $(document).on('click', '.btn-send-invites', function () {
        const inviteBtn = $(this);
        const assignmentID = $('#assignmentID').val();
        var allCheckedUsers = $('.selected-investigators').val();
        var role = $('.find-investigator-role').data('role');
        $(inviteBtn).attr('disabled', true);
        $(inviteBtn).html('<i class="fa fa-spinner fa-pulse"></i>');
        $(".custom-loader-overlay").attr("style", "display: flex !important;")

        $.ajax({
            url: role + 'assignment/send-bulk-invites',
            method: 'POST',
            data: { users: allCheckedUsers, assignment: assignmentID },
            success: function (response) {
                $(".custom-loader-overlay").hide()
                $('#assignment-flash').text(response.message);
                $('#assignment-flash').show();
                $(inviteBtn).html('Send Invites');
                // $('#inviteModal').modal('hide');
                setTimeout(() => {
                    location.reload();
                }, 1000);
                if (response.error) {
                    alert(response.message);
                }
            }
        })
    });

    $(document).on('click', '.users-list', function () {
        $(".users-list").removeClass("active");
        $(this).addClass("active");
        var userId = $(this).data('user-id');
        var assignmentId = $(this).data('assignment-id');
        var assignmentStatus = $('.job-status').html();
        var role = $('.view-investigator-profile').data('role');
        $('.view-investigator-profile').attr('href', role + 'investigators/' + userId + '/view')
        $.ajax({
            url: role + 'assignment/fetchAssignmentUser',
            data: { user_id: userId, assignment_id: assignmentId },
            success: function (response) {
                $('.message-heading').removeClass('d-none');
                $('.chat-frame').html(response.data);

                $('#notesTextArea').val(response.notes);
                $('#notesTextArea').data('userid', userId);
                var userAssignmentStatus = response.userAssignmentStatus;

                if (userAssignmentStatus == 'INVITED') {
                    $('.hire-user').data('user-id', userId).data('assignment-id', assignmentId).addClass('btn btn-outline-light btn-md m-l-20 btn-hire-now').removeClass('d-none').html('ASSIGN NOW');
                }
                else if (userAssignmentStatus == 'OFFER RECEIVED') {
                    $('.hire-user').removeClass('d-none').removeClass('btn btn-outline-light btn-md m-l-20 btn-hire-now').html('<span class="label label-success" style="background: #5cb85c;padding: 4px;border: #5cb85c;margin-left: 20px;color: #fff; cursor:default">OFFER SENT</span>');

                    $('.hire-user').append('<a href="' + role + 'assignment/' + assignmentId + '/' + userId + '/recall" class="investigator-view-profile-link"><button type="button" style="width:140px" class="btn btn-outline-light btn-sm">RECALL OFFER</button></a>');
                }
                else {
                    var style = '';
                    if (userAssignmentStatus == 'ASSIGNED')
                        style = '#5cb85c';
                    else
                        style = '#d9534f';

                    $('.hire-user').removeClass('d-none').removeClass('btn btn-outline-light btn-md m-l-20 btn-hire-now').html('<span class="label label-success" style="background: ' + style + ';padding: 4px;border: ' + style + ';margin-left: 20px;color: #fff; cursor:default">' + userAssignmentStatus + '</span>');
                }
            }
        })

    });



    $(document).on('keyup', '#notesTextArea', function () {
        var role = $(this).data('role');
        $('.confirm-div').html('<div class="col-md-1"><button type="button" class="btn btn-success btn-notes-check" data-role="' + role + '"><i class="fa fa-check fa-lg"></i></button></div> <div class="col-md-1"><button type="button" data-role="' + role + '" class="btn btn-danger btn-notes-cancel"><i class="fa fa-times fa-lg"></i></button></div>');
    });

    $(document).on('click', '.btn-notes-cancel', function () {
        var userId = $('#notesTextArea').data('userid');
        var assignmentId = $('#notesTextArea').data('assignmentid');
        var userRole = $(this).data('role');
        $.ajax({
            url: userRole + 'assignment/get-notes',
            method: 'GET',
            data: { assignment_id: assignmentId },
            success: function (data) {
                $('#notesTextArea').val(data.notes);
                $('.confirm-div').html('');
            }
        });
    });


    $(document).on('click', '.btn-notes-check', function () {
        var notesTextArea = $(this).parents('.confirm-div').prev('div.row').children('div').children('textarea#notesTextArea');
        var notes = notesTextArea.val();
        var userRole = $(this).data('role');
        // var notes_user_id =notesTextArea.data('userid');
        var notes_assignment_id = notesTextArea.data('assignmentid');
        $.ajax({
            url: userRole + 'assignment/save-notes',
            method: 'POST',
            data: { notes: notes, assignment_id: notes_assignment_id },
            success: function (data) {
                $('.confirm-div').html('<p class="success-msg">Notes updated</p>');
                setTimeout(() => {
                    $('.confirm-div p').fadeOut();
                }, 2000);
            }
        })
    });

    $(document).on('click', '.availabilityTimeField', function () {
        var parentid = $(this).parent().parent().parent().parent().parent().parent().parent().parent().attr("id");

        // var parentLastid= $(".wickedpicker__close").attr("id");
        // if(parentLastid  !="1"){
        //     $("#"+parentLastid).click();
        // }

        $(".wickedpicker__close").attr("id", parentid);


    })

    $(document).on('click', '.btn-hire-now', function () {
        $(this).html('Assigning...').css('pointer-events', 'none');
        var userId = $(this).data('user-id');
        var assignmentId = $(this).data('assignment-id');
        var role = $('.view-investigator-profile').data('role');
        $('.custom-loader-overlay').attr("style", "display: flex !important");
        $.ajax({
            url: role + 'assignment/hire-now',
            method: 'POST',
            data: { user_id: userId, assignment_id: assignmentId },
            success: function (response) {
                $('.custom-loader-overlay').hide();
                location.reload();
                /* $('.hire-user').html('<button data-user-id="'+userId+'" data-assignment-id="'+assignmentId+'" type="button" class="btn btn-light btn-sm btn-hired">Hired</button>');
                $('.job-status').html('HIRED'); */
            }
        })
    });


    /** clone assignment module start */
    $(document).on('click', '.callCloneAssignmentModal', function () {

        var assignmentUrl = $(this).data('assignment-url');
        var assignmentId = $(this).data('assignment-id');
        var clientId = $(this).data('client-id');

        $.ajax({
            url: assignmentUrl,
            type: 'GET',
            success: function (response) {
                $('#assignmentId').val(response.data.assignment_id);
            },
            error: function (xhr) {
                console.log(xhr.responseText);
            }
        });

        $('#clientId').val(clientId);
        $('#sourceAssignmentId').val(assignmentId);
        $('#cloneAssignmentModal').modal('show');
    });


    $('#assignmentCloneForm').on('submit', function (e) {

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
            old_assignment_id: sourceAssignmentIdVal,
            client_id: clientIdVal,
            type: 'clone'
        };

        $.ajax({
            url: formAction,
            method: 'POST',
            data: data,
            success: function (response) {
                window.location.replace(response);
            },
            error: function (xhr) {
                console.log(xhr.responseText);
            }
        });
    });


    $(document).on('click', '#cloneModalCloseIconBtn, #cloneModalCloseBtn', function () {
        $('#cloneAssignmentModal').modal('hide');
        $('#assignmentCloneForm')[0].reset();
    });

});



function latestNotification() {
    //'investigator'
    var role = $(".badge.bg-primary").attr("rel");
    if (role == "investigator") {
        var sendUrl = '/investigator/notifications/latestNotification';
    } else if (role == "company-admin") {
        var sendUrl = '/company-admin/notification/latestNotification';
    } else {
        var sendUrl = '/hm/notification/latestNotification';
    }

    $.ajax({
        url: '' + sendUrl + '',
        method: 'GET',
        success: function (response) {
            $('.badge.bg-primary').text(response);
        }
    })
}
function checkGoogleAccessToken() {
    $.ajax({
        url: "/investigator/checkToken",
        success: function (data) {
            // console.log(data);
        }
    });
}

document.addEventListener('DOMContentLoaded', function () {

    var calendarEl = document.getElementById('calendar');
    if (calendarEl) {
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
        });
        calendar.render();
    }


    var currentURL = window.location.href;
    var checkURL = currentURL.includes('/investigator/');

    if (checkURL)
        fetchEvents();

    $('.sync-btn').click(function (e) {
        e.preventDefault();
        var selectedCalendar = $('.select-calendar').val();
        $('.custom-loader-overlay').attr("style", "display: flex !important");
        $.ajax({
            url: '/investigator/calendar/fetch-events',
            data: {
                calendar_id: selectedCalendar
            },
            method: 'POST',
            success: function (data) {
                $('.custom-loader-overlay').hide();
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

    $('.update-calendar-yes-btn').click(function () {
        $('.custom-loader-overlay').attr("style", "display: flex !important");
        $.ajax({
            url: 'remove-events',
            method: 'delete',
            success: function (data) {

                $('#update-calendar .close').click();
                $('.custom-loader-overlay').hide();
                location.reload();
            }
        })
    });
});

function miscTypeahead() {
    console.log('working');

    var role = $('.investigators-role').data('role');

    var bestPictures = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        // prefetch: 'searchForServiceLine/%QUERY',
        remote: {
          url: '/'+role+'/searchForServiceLine?q=%QUERY%',
          wildcard: '%QUERY%'
        }
      });

    $('.typeahead').typeahead({
        hint: true,
        highlight: true,
        minLength: 1
    }, {
        name: 'investigation_types',
        source: bestPictures,
        display: function(data) {
            return data.type_name  //Input value to be set when you select a suggestion. 
        },
        templates: {
            empty: [],
            header: [
                '<div class="list-group search-results-dropdown">'
            ],
            suggestion: function(data) {
            return '<div style="font-weight:normal; margin-top:-10px ! important; z-index:9999" class="list-group-item">' + data.type_name + '</div></div>'
            }
        }
    });
}

var rowCounter = 2;

// Function to clone the template row and update the IDs and names
function cloneRow() {
    if (!isRowEmpty())
        return false;
    /* 
        if (isRowEmpty(rowCounter)) {
    
            alert('Please fill in the current row before adding a new one.');
            return;
        } */

    var newRow = $('.misc-row-1').clone().attr('id', 'misc-row-' + rowCounter).removeClass('misc-row-1 d-none').addClass('misc-rows each-misc-row misc-row-' + rowCounter);

    newRow.children('td:first').find('input').attr('name','investigation_type[2][misc_service_name][]')
    newRow.children('td:nth-child(2)').find('select').attr('name','investigation_type[2][case_experience][]')
    newRow.children('td:nth-child(3)').find('input').attr('name','investigation_type[2][years_experience][]')
    newRow.children('td:nth-child(4)').find('input').attr('name','investigation_type[2][hourly_rate][]')
    newRow.children('td:nth-child(5)').find('input').attr('name','investigation_type[2][travel_rate][]')
    newRow.children('td:nth-child(6)').find('input').attr('name','investigation_type[2][milage_rate][]')


    console.log();
    // Update IDs and names in the cloned row
    /* newRow.find('td:nth-child(0)').each(function (index) {
        console.log(index);
        var currentId = $(this).attr('id');
        var currentName = $(this).find(':nth-child(0)').find('input').attr('name','investigation_type[2][misc_service_name][]');
        $(this).val('');
    }); */

    var appendTo = $('.add-more-rows').parents('tr');
    $(newRow).insertBefore(appendTo);
    $('.misc-row-' + rowCounter + ' td:first input').addClass('typeahead')

    // Increment the row counter for the next row
    rowCounter++;
}


// Function to check if the previous row is empty
function isRowEmpty() {
    var lastTrWithClass = $('tr.each-misc-row:last');
    var isValid = true;
    lastTrWithClass.find('td').each(function () {
        $(this).find('input,select').each(function () {
            if (!$(this).attr('readonly')) {
                if ($(this).val().trim() === '') {
                    isValid = false;
                    $(this).addClass('empty-error');
                } else {
                    $(this).removeClass('empty-error');
                }
            }
        });
    });

    if (isValid) {
        return true;
        // Proceed with further actions if all inputs are valid
    } else {
        // Show a message or handle validation failure appropriately
        alert('Please fill in all fields before adding a new row.');
        return false;
    }
}

function reCalculateTime(row) {
    var rowObject = $(row);
    var timeperiodElement = rowObject.attr("id").match(/\d+/);;
    dayType(timeperiodElement);
}
$(document).on('click', '.wickedpicker__controls__control-up', function () {
    dayType($(".wickedpicker__close").attr("id"));
});
$(document).on('click', '.wickedpicker__controls__control-down', function () {
    dayType($(".wickedpicker__close").attr("id"));
});


function removeSection(row) {
    var rowObject = $(row);
    var rowclass = rowObject.parent().parent().parent().remove();
    $('#fieldsUpdated').val('1');
    $('#callConfirmUpdateSearchModal').removeAttr('disabled');
}
var rowCount = $('#callConfirmUpdateSearchModal').data('dayscount');

function addNewSection(row) {
    var rowObject = $(row);
    rowCount++;
    var newRowClass = rowCount;
    var rowclass = rowObject.parent().parent().parent().parent().attr("class");
    var newRow = rowObject.closest('.dayRow').clone().addClass('dayRow' + newRowClass);
    newRow.find('#timepickerstart').addClass("timepickerstart" + newRowClass);
    newRow.find('#timepickerstart').removeClass("timepickerstart");
    newRow.find('.availabilitydateepicker').addClass("availabilitydateepicker" + newRowClass);
    newRow.find('.heading').text("Day " + newRowClass);
    newRow.find('.AvailabilityRow').attr("id", newRowClass);
    newRow.find('.timeperiod').attr("id", "timeperiod" + newRowClass);
    newRow.find('.availabilitydateepicker').attr("name", "datetimes[" + newRowClass + "]");
    newRow.find('.timeperiod').attr("name", "timeperiod[" + newRowClass + "]");
    newRow.find('#timepickerstart').attr("name", "start_time[" + newRowClass + "]");
    newRow.find('#timepickerend').attr("name", "end_time[" + newRowClass + "]");
    newRow.find('.remove').removeClass("disabled");
    $('.daysRow').append(newRow);
    timepicker(newRowClass);

}

function padZero(number) {
    return (number < 10 ? '0' : '') + number;
}

function dayType(id = "") {
    var timePeriod = $('#timeperiod' + id).val();
    var timeHours = $('.wickedpicker__controls__control--hours').text();
    var timeMinutes = $('.wickedpicker__controls__control--minutes').text();
    var time = "";
    if (timePeriod == 1) {
        time = 4;
    }
    if (timePeriod == 2) {
        time = 8;
    }
    var hours = parseInt(timeHours);
    var minutes = parseInt(timeMinutes);
    hours = (hours + parseInt(time)) % 24;
    var newTime = padZero(hours) + ':' + padZero(minutes);
    $("#" + id + " .availabilityTimepickerend").val(newTime)
}

function timepicker(count = "") {
    var eMinDate = $('input[name="e_datetimes"]').data('min-date');
    var etimeStart = $('.e-timepickerstart' + count).data('start-time');
    var etimeEnd = $('.e-timepickerend').data('end-time');

    $('.availabilitydateepicker' + count).daterangepicker({
        minDate: eMinDate,
        opens: 'left'
    });

    var startTimeOptions = { twentyFour: true, now: etimeStart };
    var endTimeOptions = { twentyFour: true, now: etimeEnd };

    $('.timepickerstart' + count).wickedpicker(startTimeOptions);
    $('.timepickerend' + count).wickedpicker(endTimeOptions);

    $('.availabilitydateepicker' + count).daterangepicker({
        minDate: moment().format('MM/DD/YYYY'),
        opens: 'left'
    });
}
function resetPassword(selected) {
    $("" + selected + "").on("input", function () {
        let password = $(this).val();
        // Validate minimum length
        let minLengthValid = password.length >= 10;

        // Validate presence of at least 1 capital letter, 1 number, 1 lowercase letter, and 1 special character
        let capitalLetterValid = /[A-Z]/.test(password);
        let numberValid = /[0-9]/.test(password);
        let lowercaseLetterValid = /[a-z]/.test(password);
        let specialCharacterValid = /[@$!%*?&]/.test(password);
        let allConditionsValid = capitalLetterValid && numberValid && lowercaseLetterValid && specialCharacterValid;
        let errorBagsEle = $(document).find(".password-error-bags");
        let errorBagTypes = [];
        // for min length
        if (minLengthValid)
            errorBagTypes.push("length");
        else
            removeErrorSuccess("length");
        //removeItem(errorBagTypes, 'length');

        // for atleast single number
        if (numberValid)
            errorBagTypes.push("number");
        else
            removeErrorSuccess("number");


        // for lower case
        if (lowercaseLetterValid)
            errorBagTypes.push("lowercase");
        else
            removeErrorSuccess("lowercase");

        // for upper case
        if (capitalLetterValid)
            errorBagTypes.push("uppercase");
        else
            removeErrorSuccess("uppercase");

        // for special symbols
        if (specialCharacterValid)
            errorBagTypes.push("special_character");
        else
            removeErrorSuccess("special_character");

        if (errorBagTypes.length > 0) {
            $.each(errorBagTypes, function (key, errType) {
                errorBagsEle.find('li[type="' + errType + '"]').removeClass('text-danger').addClass('text-success');
            })
        }

        // Display error messages
        if (!minLengthValid || !allConditionsValid) {
            $("#password-error").html(`<strong>Password is invalid, please follow the instructions below!</strong>`);
            $("#password-error").removeClass("hide");
            $(this).addClass("is-invalid");

        } else {
            $("#password-error").text("");
            $("#password-error").addClass("hide");
            $(this).removeClass("is-invalid");
        }
    });
}
function fetchEvents() {
    $.ajax({
        url: '/investigator/calendar/fetch-events-onload',
        method: 'GET',
        success: function (data) {
            console.log(data);
            if (data) {
                var events = JSON.parse(data);
                if (events.length > 0)
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
