$(document).ready(function(){

    $('input[name="datetimes"]').daterangepicker({
        timePicker: true,
        startDate: moment().startOf('hour'),
        endDate: moment().startOf('hour').add(32, 'hour'),
        locale: {
          format: 'M/DD/YYYY hh:mm A'
        }
      });

    $(document).on('click', '.close-calendars-list-modal',function() {
        $('#calendars-list').modal('hide');
    })

    var currentURL = window.location.href;
    console.log('currentURL = ',currentURL);
    var checkURL = currentURL.includes('/investigator/');

    // console.log(checkURL);

    /* if(checkURL)
    checkGoogleAccessToken();  */// check if google access token is expired or not
    

    $('.disconnect-yes-btn').click(function() { // disconnect google sync
        $.ajax({
            url : '/investigator/disconnect-calendar',
            method : 'delete',
            success : function(data) {
                location.reload();
            }
        })
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
    });
}