@extends('layouts.dashboard')
@section('content')
    <div class="row mt-4 mb-4">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Reset Password</h5>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('company-admin.update-password') }}">
                        @csrf



                        <div class="mb-3">
                            <label for="password" class="form-label">Enter New Password</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            <span id="password-error" class="invalid-feedback hide" role="alert"></span>
                            <small class="password-error-bags">
                                <ul class="ml-n4">
                                    <li type="length" class="text-danger">At least 10 characters</li>
                                    <li type="number" class="text-danger">At least 1 number</li>
                                    <li type="lowercase" class="text-danger">At least 1 lowercase letter</li>
                                    <li type="uppercase" class="text-danger">At least 1 uppercase letter</li>
                                    <li type="special_character" class="text-danger">
                                        At least 1 special character within a set of special characters: @$!%*?&
                                    </li>
                                </ul>
                            </small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="basic-default-company">Confirm Password</label>
                            <input type="password" class="form-control @error('last_name') is-invalid @enderror" name="password_confirmation">
                        </div>

                        <input type="hidden" name="user_id" value="{{isset($admin) && !empty($admin) ? $admin->id :''}}">
          <button type="submit" class="btn btn-primary">Update Password</button>
        </form>
      </div>
    </div>
  </div>
  <div class="col-md-1"></div>
</div>
@endsection
@push('scripts')
    <script type="text/javascript">
        function initWebsiteSection() {
            let roleText = $('#role option:selected').text();
            // trim text
            roleText     = roleText.trim();

            if (roleText === 'Company') {
                $('#website-section').show();
            } else {
                $('#website-section').hide();
            }
        }

        function removeItem(array, item){
            for(var i in array){
                if(array[i]==item){
                    array.splice(i,1);
                    break;
                }
            }
        }

        function removeErrorSuccess(itemType){
            $(document).find(".password-error-bags").find('li[type="'+itemType+'"]').removeClass('text-success').addClass('text-danger');
        }

        $(document).ready(function () {
            initWebsiteSection();

            $('#role').on('change', function () {
                initWebsiteSection();
            });


        });
    </script>
@endpush
