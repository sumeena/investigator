@if(!$googleAuthDeatils)
<div class="modal" id="sync-calendar" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="width:50%">
      <div class="modal-header">
        <h5 class="modal-title">Choose Provider</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
          <form action="/investigator/sync-calendar" method="post">
            @csrf
            <div class="mb-3">
              <input type="submit" name="google" value="Google" class="btn btn-primary">
              <!-- <input type="submit" name="exchange" value="Exchange" class="btn btn-primary"> -->
            </div>
          </form>

      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
@else
<div class="modal" id="disconnect-calendar" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="width:50%">
      <div class="modal-header">
        <h5 class="modal-title">Are you sure, you want to disconnect your calendar?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <button class="btn btn-success disconnect-yes-btn">Yes</button>
        <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close">No</button>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
@endif