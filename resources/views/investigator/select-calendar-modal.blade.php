<div class="modal" id="calendars-list" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="width:50%">
      <div class="modal-header">
        <h5 class="modal-title">Choose Calendar</h5>

        <button type="button" class="close close-calendars-list-modal" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>

      

      </div>
      <div class="modal-body text-center">
          <form class="sync-my-calendar" method="post">
            @csrf
            <div class="mb-3">
              <select class="form-control select-calendar">
                <option>Select Calendar</option>
                @foreach( $calendars as $calendar)
                <option value="{{$calendar->id}}">{{$calendar->name}}</option>
                @endforeach
              </select>
            </div>
            <div class="mb-3">
              <input type="submit" name="sync" value="SYNC" class="btn btn-primary sync-btn">
            </div>
          </form>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
