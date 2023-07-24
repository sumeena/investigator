$(document).ready(function(){
    // check if google access token is expired or not
    checkGoogleAccessToken();

    $('.disconnect-yes-btn').click(function() {
        $.ajax({
            url : 'disconnect-calendar',
            method : 'delete',
            success : function(data) {
                location.reload();
            }
        })
    });
});


function checkGoogleAccessToken() {
    $.ajax({
        url : "checkToken",
        data : {},
        success : function(data) {
            console.log(data);
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {

    fetchEvents();

    $('.sync-btn').click(function(e) {
        e.preventDefault();
        var selectedCalendar = $('.select-calendar').val();

        $.ajax({
            url: 'calendar/fetch-events',
            data: {
                calendarId: selectedCalendar
            },
            method: 'POST',
            success: function(data) {
                $('#calendars-list').modal('hide');
                var events = JSON.parse(data);

                var source = {
                    events: events
                };

                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    events: source
                });
                calendar.render();
            }
        });

    });
  
});

function fetchEvents() {
    $.ajax({
        url: 'calendar/fetch-events-onload',
        method: 'GET',
        success: function(data) {
            var events = JSON.parse(data);
console.log(events);
            var source = {
                events: events
            };

            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: source
            });
            calendar.render();
        }
    });
}