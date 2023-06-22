@extends('layouts.dashboard')
@section('title', 'Reset Password')
@section('content')
<div class="row mt-4 mb-4">
  <div class="col-md-1"></div>
  <div class="col-md-10">
    <div class="card mb-4">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Reset Password</h5>
      </div>
      <div class="card-body">
        <form method="post" action="/admin/update-password">
          @csrf
          <!-- <div class="mb-3">
            <label class="form-label" for="basic-default-fullname">Enter New Password</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password">
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div> -->

          <div class="mb-3">
            <label for="new-password" class="form-label">Enter New Password</label>
            <input id="new-password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
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
            <input type="password" class="form-control @error('last_name') is-invalid @enderror"  name="password_confirmation">
          </div>
          <input type="hidden"  name="user_id" value="{{isset($admin) && !empty($admin) ? $admin->id :''}}">
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

            $("#new-password").on("input", function () {
                let password = $(this).val();
                console.log(password)

                // Validate minimum length
                let minLengthValid = password.length >= 10;

                // Validate presence of at least 1 capital letter, 1 number, 1 lowercase letter, and 1 special character
                let capitalLetterValid    = /[A-Z]/.test(password);
                let numberValid           = /[0-9]/.test(password);
                let lowercaseLetterValid  = /[a-z]/.test(password);
                let specialCharacterValid = /[@$!%*?&]/.test(password);
                let allConditionsValid    = capitalLetterValid && numberValid && lowercaseLetterValid && specialCharacterValid;
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
                    //removeItem(errorBagTypes, 'number');

                // for lower case
                if (lowercaseLetterValid)
                    errorBagTypes.push("lowercase");
                else
                    removeErrorSuccess("lowercase");

                    //removeItem(errorBagTypes, 'lowercase');

                // for upper case
                if (capitalLetterValid)
                    errorBagTypes.push("uppercase");
                else
                    removeErrorSuccess("uppercase");

                    //removeItem(errorBagTypes, 'uppercase');

                // for special symbols
                if (specialCharacterValid)
                    errorBagTypes.push("special_character");
                else
                    removeErrorSuccess("special_character");

                    //removeItem(errorBagTypes, 'special_character');

                console.log("ERR", errorBagTypes)
                if (errorBagTypes.length > 0){
                    $.each(errorBagTypes, function(key,errType) {
                        errorBagsEle.find('li[type="'+errType+'"]').removeClass('text-danger').addClass('text-success');
                    })
                }

                // Display error messages
                if (!minLengthValid || !allConditionsValid) {
                    $("#password-error").html(`<strong>Password is invalid, please follow the instructions below!</strong>`);
                    $("#password-error").removeClass("hide");
                    $(this).addClass("is-invalid");
                    //$(document).find(".text-success").removeClass("text-success").addClass("text-danger")
                } else {
                    $("#password-error").text("");
                    $("#password-error").addClass("hide");
                    $(this).removeClass("is-invalid");
                }
            });
        });
    </script>
@endpush
