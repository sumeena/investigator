@extends('layouts.app')
@section('title')
{{ __('Register') }}
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Register') }}</div>
                    @if ($errors->any())
                        <div class="alert alert-danger dev75">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="name"
                                       class="col-md-4 col-form-label text-md-end">{{ __('First Name') }}</label>

                                <div class="col-md-6">
                                    <input id="first_name" type="text"
                                           class="form-control @error('first_name') is-invalid @enderror"
                                           name="first_name" value="{{ old('first_name') }}" required
                                           autocomplete="first_name" autofocus>

                                    @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="last_name"
                                       class="col-md-4 col-form-label text-md-end">{{ __('Last Name') }}</label>

                                <div class="col-md-6">
                                    <input id="last_name" type="text"
                                           class="form-control @error('last_name') is-invalid @enderror"
                                           name="last_name" value="{{ old('last_name') }}" required autocomplete="name"
                                           autofocus>

                                    @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email"
                                       class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                           class="form-control @error('email') is-invalid @enderror" name="email"
                                           value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="role"
                                       class="col-md-4 col-form-label text-md-end">{{ __('Select Role') }}</label>
                                <div class="col-md-6">
                                    <select id="role" class="form-control @error('role') is-invalid @enderror"
                                            name="role">
                                        @foreach($roles as $role)
                                            <option value="{{$role->id}}">
                                                @if($role->role == 'company-admin')
                                                    Company
                                                @else
                                                    {{ ucfirst($role->role) }}
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('role')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3" id="website-section">
                                <label for="website"
                                       class="col-md-4 col-form-label text-md-end">{{ __('Website') }}</label>
                                 <div class="col-md-2">
                                   <select class="form-control" name="pre_link">
                                      <option value="http://">http://</option>
                                      <option value="https://">https://</option>
                                  </select>
                                 </div>
                                <div class="col-md-4">
                                    <input id="website" type="text"
                                           class="form-control @error('website') is-invalid @enderror" name="website"
                                           value="{{ old('website') }}">
                                    @error('website')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password"
                                       class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                           class="form-control @error('password') is-invalid @enderror" name="password"
                                           required autocomplete="new-password">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    <span id="password-error" class="invalid-feedback hide" role="alert">

                                    </span>
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
                            </div>

                            <div class="row mb-3">
                                <label for="password-confirm"
                                       class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                           name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
                                    </button>
                                    <a href="{{ route('login') }}" class="btn btn-primary">
                                        {{ __('Login') }}
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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

            $("#password").on("input", function () {
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

                } else {
                    $("#password-error").text("");
                    $("#password-error").addClass("hide");
                    $(this).removeClass("is-invalid");
                }
            });
        });
    </script>
@endpush
