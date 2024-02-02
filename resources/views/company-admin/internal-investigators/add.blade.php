@extends('layouts.dashboard')
@section('title', 'Company User')
@section('content')
<div data-role="company-admin/internal-investigators" class="row mt-4 mb-4 justify-content-center investigators-role">
    <div class="col-md-10">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    {{ @$investigator->id ? 'Edit' : 'Add' }}
                    Internal Investigator
                </h5>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('company-admin.internal-investigators.submit') }}">
                    @csrf

                    <input type="hidden" name="submit_type" value="{{ @$investigator->id ? 'edit' : 'add' }}">

                    <div class="mb-3">
                        <label class="form-label" for="first-name">First Name</label>
                        <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" id="first-name" value="{{ old('first_name', $investigator->first_name ?? '') }}">
                        @error('first_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="last-name">Last Name</label>
                        <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" id="last-name" value="{{ old('last_name', $investigator->last_name ??  '') }}">
                        @error('last_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    @if (@$investigator->email)
                    <div class="mb-3">
                        <label class="form-label" for="email">Email</label>
                        <div class="input-group input-group-merge">
                            <input type="text" class="form-control" id="email" value="{{ $investigator->email }}" disabled>
                            <input type="hidden" class="form-control" required name="email" value="{{ $investigator->email }}">
                        </div>
                    </div>
                    @else
                    <div class="mb-3">
                        <label class="form-label" for="email">Email</label>
                        <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" id="email">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    @endif


                    {{ old('investigation_type.0.type') }}
                    <div class="mb-3">
                        <div class="card">
                            <h5 class="card-header">Service Lines</h5>
                            @error('investigation_type')
                            <p class="ms-4 text-danger">{{ $message }}</p>
                            @enderror
                            <div class="table-responsive text-nowrap">
                                <table class="table">
                                    <thead>
                                        <tr class="text-nowrap">
                                            <th>Investigation Types</th>
                                            <th>Case Experience</th>
                                            <th>Years Experience</th>
                                            <th>Hourly Rate</th>
                                            <th>Travel Rate</th>
                                            <th>Mileage Rate</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                Surveillance
                                                <input class="form-check-input" type="checkbox" value="1" name="investigation_type[0][type]" @checked((@$survServiceLine) || old('investigation_type.0.type')==1)>

                                                <input type="hidden" value="surveillance" name="investigation_type[0][service_name]">
                                            </td>
                                            <td>
                                                <select class="form-select @error('investigation_type.0.case_experience') is-invalid @enderror" name="investigation_type[0][case_experience]">
                                                    <option value="">--select--</option>
                                                    <option value="1" @selected(@$survServiceLine && $survServiceLine->case_experience == 1 || old('investigation_type.0.case_experience') == 1)>
                                                        Under 50
                                                    </option>
                                                    <option value="2" @selected(@$survServiceLine && $survServiceLine->case_experience == 2 || old('investigation_type.0.case_experience') == 2)>
                                                        50-499
                                                    </option>
                                                    <option value="3" @selected(@$survServiceLine && $survServiceLine->case_experience == 3 || old('investigation_type.0.case_experience') == 3)>
                                                        500+
                                                    </option>
                                                </select>
                                                @error('investigation_type.0.case_experience')
                                                <span role="alert" class="text-danger small">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                            </td>
                                            <td>
                                                <input type="text" class="form-control @error('investigation_type.0.years_experience') is-invalid @enderror" name="investigation_type[0][years_experience]" value="{{ old('investigation_type.0.years_experience', $survServiceLine->years_experience ?? '') }}">
                                                @error('investigation_type.0.years_experience')
                                                <span role="alert" class="text-danger small">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                            </td>
                                            <td>
                                                <span class="investigation_span">$</span>
                                                <input type="text" class="form-control @error('investigation_type.0.hourly_rate') is-invalid @enderror investigation_input_dollar_sign" name="investigation_type[0][hourly_rate]" value="{{ old('investigation_type.0.hourly_rate', $survServiceLine->hourly_rate ?? '25') }}">
                                                @error('investigation_type.0.hourly_rate')
                                                <span role="alert" class="text-danger small">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                            </td>
                                            <td>
                                                <span class="investigation_span">$</span>
                                                <input type="text" class="form-control @error('investigation_type.0.travel_rate') is-invalid @enderror investigation_input_dollar_sign" name="investigation_type[0][travel_rate]" value="{{ old('investigation_type.0.travel_rate', $survServiceLine->travel_rate ?? '25') }}">
                                                @error('investigation_type.0.travel_rate')
                                                <span role="alert" class="text-danger small">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                            </td>
                                            <td>
                                                <span class="investigation_span">$</span>
                                                <input type="text" class="form-control @error('investigation_type.0.milage_rate') is-invalid @enderror investigation_input_dollar_sign" name="investigation_type[0][milage_rate]" value="{{ old('investigation_type.0.milage_rate', $survServiceLine->milage_rate ?? '25') }}">
                                                @error('investigation_type.0.milage_rate')
                                                <span role="alert" class="text-danger small">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Statements
                                                <input class="form-check-input" type="checkbox" value="2" name="investigation_type[1][type]" @checked(@$statServiceLine || old('investigation_type.1.type')==2)>
                                                <input type="hidden" value="statements" name="investigation_type[1][service_name]">
                                            </td>
                                            <td>
                                                <select class="form-select @error('investigation_type.1.case_experience') is-invalid @enderror" name="investigation_type[1][case_experience]">
                                                    <option value="">--select--</option>
                                                    <option value="1" @selected(@$statServiceLine && $statServiceLine->case_experience == 1 || old('investigation_type.1.case_experience') == 1)>
                                                        Under 50
                                                    </option>
                                                    <option value="2" @selected(@$statServiceLine && $statServiceLine->case_experience == 2 || old('investigation_type.1.case_experience') == 2)>
                                                        50-499
                                                    </option>
                                                    <option value="3" @selected(@$statServiceLine && $statServiceLine->case_experience == 3 || old('investigation_type.1.case_experience') == 3)>
                                                        500+
                                                    </option>
                                                </select>
                                                @error('investigation_type.1.case_experience')
                                                <span role="alert" class="text-danger small">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                            </td>
                                            <td>
                                                <input type="text" class="form-control @error('investigation_type.1.years_experience') is-invalid @enderror" name="investigation_type[1][years_experience]" value="{{ old('investigation_type.1.years_experience', $statServiceLine->years_experience ?? '') }}">
                                                @error('investigation_type.1.years_experience')
                                                <span role="alert" class="text-danger small">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                            </td>
                                            <td>
                                                <span class="investigation_span">$</span>
                                                <input type="text" class="form-control @error('investigation_type.1.hourly_rate') is-invalid @enderror investigation_input_dollar_sign" name="investigation_type[1][hourly_rate]" value="{{ old('investigation_type.1.hourly_rate', $statServiceLine->hourly_rate ?? '25') }}">
                                                @error('investigation_type.1.hourly_rate')
                                                <span role="alert" class="text-danger small">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                            </td>
                                            <td>
                                                <span class="investigation_span">$</span>
                                                <input type="text" class="form-control @error('investigation_type.1.travel_rate') is-invalid @enderror investigation_input_dollar_sign" name="investigation_type[1][travel_rate]" value="{{ old('investigation_type.1.travel_rate', $statServiceLine->travel_rate ?? '25') }}">
                                                @error('investigation_type.1.travel_rate')
                                                <span role="alert" class="text-danger small">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                            </td>
                                            <td>
                                                <span class="investigation_span">$</span>
                                                <input type="text" class="form-control @error('investigation_type.1.milage_rate') is-invalid @enderror investigation_input_dollar_sign" name="investigation_type[1][milage_rate]" value="{{ old('investigation_type.1.milage_rate', $statServiceLine->milage_rate ?? '25') }}">
                                                @error('investigation_type.1.milage_rate')
                                                <span role="alert" class="text-danger small">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                            </td>
                                        </tr>





                                        <tr>
                                            <td colspan="7">
                                                Misc
                                                <input class="form-check-input miscellaneous-checkbox @if(@$miscServiceLine && count($miscServiceLine) <= 0) misc-checkbox @endif" type="checkbox" value="3" name="investigation_type[2][type]" @checked(@$miscServiceLine && count($miscServiceLine)> 0 || old('investigation_type.2.type') == 3)>
                                            </td>
                                        </tr>

                                        <?php
                                        $miscServiceLineCount = 0;
                                        if (@$miscServiceLine) {
                                            $miscServiceLineCount = count($miscServiceLine);
                                        }

                                        if (@count(old('investigation_type.2.misc_service_name', [])))
                                            $oldValuesCount = count(old('investigation_type.2.misc_service_name', []));

                                        ?>

                                        @if(@$miscServiceLine)
                                        @foreach($miscServiceLine as $key => $miscServiceLineEach)
                                        <tr class="each-misc-row">
                                            <td>
                                                <input type="text" class="typeahead form-control @error('investigation_type.2.misc_service_name.'.$key) is-invalid @enderror" name="investigation_type[2][misc_service_name][]" value="{{ old('investigation_type.2.misc_service_name.'.$key,@$miscServiceLineEach->investigationType['type_name'] ?? '') }}">
                                                @error('investigation_type.2.misc_service_name.'.$key)
                                                <span role="alert" class="text-danger small d-block ">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                            </td>
                                            <td>
                                                <select class="form-select @error('investigation_type.2.case_experience.'.$key) is-invalid @enderror" name="investigation_type[2][case_experience][]">
                                                    <option value="">--select--</option>
                                                    <option value="1" @selected(@$miscServiceLineEach && @$miscServiceLineEach->case_experience == 1 ||
                                                        old('investigation_type.2.case_experience.'.$key) == 1)>
                                                        Under 50
                                                    </option>
                                                    <option value="2" @selected(@$miscServiceLineEach && @$miscServiceLineEach->case_experience == 2 ||
                                                        old('investigation_type.2.case_experience.'.$key) == 2)>
                                                        50-499
                                                    </option>
                                                    <option value="3" @selected(@$miscServiceLineEach && @$miscServiceLineEach->case_experience == 3 ||
                                                        old('investigation_type.2.case_experience.'.$key) == 3)>
                                                        500+
                                                    </option>
                                                </select>
                                                @error('investigation_type.2.case_experience.'.$key)
                                                <span role="alert" class="text-danger small d-block">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                            </td>
                                            <td>
                                                <input type="text" class="form-control @error('investigation_type.2.years_experience.'.$key) is-invalid @enderror" name="investigation_type[2][years_experience][]" value="{{ old('investigation_type.2.years_experience.'.$key, @$miscServiceLineEach->years_experience ?? '') }}">
                                                @error('investigation_type.2.years_experience.'.$key)
                                                <span role="alert" class="text-danger small d-block">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                            </td>
                                            <td>
                                                <span class="investigation_span">$</span>
                                                <input type="text" class="form-control @error('investigation_type.2.hourly_rate.'.$key) is-invalid @enderror investigation_input_dollar_sign" name="investigation_type[2][hourly_rate][]" value="{{ old('investigation_type.2.hourly_rate.'.$key, @$miscServiceLineEach->hourly_rate ?? $rate) }}">
                                                @error('investigation_type.2.hourly_rate.'.$key)
                                                <span role="alert" class="text-danger small d-block">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                            </td>
                                            <td>
                                                <span class="investigation_span">$</span>
                                                <input type="text" class="form-control @error('investigation_type.2.travel_rate.'.$key) is-invalid @enderror investigation_input_dollar_sign" name="investigation_type[2][travel_rate][]" value="{{ old('investigation_type.2.travel_rate.'.$key,  @$miscServiceLineEach->travel_rate ?? $rate) }}">
                                                @error('investigation_type.2.travel_rate.'.$key)
                                                <span role="alert" class="text-danger small d-block">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                            </td>
                                            <td>
                                                <span class="investigation_span">$</span>
                                                <input type="text" class="form-control @error('investigation_type.2.milage_rate.'.$key) is-invalid @enderror investigation_input_dollar_sign" name="investigation_type[2][milage_rate][]" value="{{ old('investigation_type.2.milage_rate.'.$key, @$miscServiceLineEach->milage_rate ?? $rate) }}">
                                                @error('investigation_type.2.milage_rate.'.$key)
                                                <span role="alert" class="text-danger small d-block">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger remove-misc-row"><i class="fa fa-minus-circle"></i></button>
                                            </td>
                                        </tr>
                                        @endforeach

                                        @endif


                                       


                                        @if(@$oldValuesCount > 0)
                                            @for($i=$miscServiceLineCount; $i<$oldValuesCount; $i++)

                                        <tr class="each-misc-row">
                                        <td>
                                                <input type="text" class="typeahead form-control @error('investigation_type.2.misc_service_name.' . $i) is-invalid @enderror" name="investigation_type[2][misc_service_name][]" value="{{ old('investigation_type.2.misc_service_name.' . $i) }}">
                                                @error('investigation_type.2.misc_service_name.'.$i)
                                                <span role="alert" class="text-danger invalid-feedback small d-block">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                            </td>
                                            <td>
                                                <select class="form-select @error('investigation_type.2.case_experience.' . $i) is-invalid @enderror" name="investigation_type[2][case_experience][]">
                                                    <option value="">--select--</option>
                                                    <option value="1" @selected(old('investigation_type.2.case_experience.'.$i)==1)>
                                                        Under 50
                                                    </option>
                                                    <option value="2" @selected(old('investigation_type.2.case_experience.'.$i)==2)>
                                                        50-499
                                                    </option>
                                                    <option value="3" @selected(old('investigation_type.2.case_experience.'.$i)==3)>
                                                        500+
                                                    </option>
                                                </select>
                                                @error('investigation_type.2.case_experience.'.$i)
                                                <span role="alert" class="text-danger small d-block">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                            </td>
                                            <td>
                                                <input type="text" class="form-control @error('investigation_type.2.years_experience.' . $i) is-invalid @enderror" name="investigation_type[2][years_experience][]" value="{{ old('investigation_type.2.years_experience.' . $i) }}">
                                                @error('investigation_type.2.years_experience.'.$i)
                                                <span role="alert" class="text-danger small d-block">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                            </td>
                                            <td>
                                                <span class="investigation_span">$</span>
                                                <input type="text" class="form-control @error('investigation_type.2.hourly_rate.' . $i) is-invalid @enderror investigation_input_dollar_sign" name="investigation_type[2][hourly_rate][]" value="{{ old('investigation_type.2.hourly_rate.' . $i) }}">
                                                @error('investigation_type.2.hourly_rate.'.$i)
                                                <span role="alert" class="text-danger small d-block">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                            </td>
                                            <td>
                                                <span class="investigation_span">$</span>
                                                <input type="text" class="form-control @error('investigation_type.2.travel_rate.' . $i) is-invalid @enderror investigation_input_dollar_sign" name="investigation_type[2][travel_rate][]" value="{{ old('investigation_type.2.travel_rate.' . $i) }}">
                                                @error('investigation_type.2.travel_rate.'.$i)
                                                <span role="alert" class="text-danger small d-block">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                            </td>
                                            <td>
                                                <span class="investigation_span">$</span>
                                                <input type="text" class="form-control @error('investigation_type.2.milage_rate.' . $i) is-invalid @enderror investigation_input_dollar_sign" name="investigation_type[2][milage_rate][]" value="{{ old('investigation_type.2.milage_rate.' . $i) }}">
                                                @error('investigation_type.2.milage_rate.'.$i)
                                                <span role="alert" class="text-danger small d-block">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger remove-misc-row"><i class="fa fa-minus-circle"></i></button>
                                            </td>
                                            </tr>

                                            @endfor

                                            @endif


                                            <tr class="d-none misc-row-1">
                                                <td>
                                                    <input type="text" class="form-control @error('investigation_type.2.misc_service_name') is-invalid @enderror" name="" value="">
                                                    @error('investigation_type.2.misc_service_name')
                                                    <span role="alert" class="text-danger small d-block">
                                                        {{ $message }}
                                                    </span>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <select class="form-select @error('investigation_type.2.case_experience') is-invalid @enderror" name="">
                                                        <option value="">--select--</option>
                                                        <option value="1">
                                                            Under 50
                                                        </option>
                                                        <option value="2">
                                                            50-499
                                                        </option>
                                                        <option value="3">
                                                            500+
                                                        </option>
                                                    </select>
                                                    @error('investigation_type.2.case_experience')
                                                    <span role="alert" class="text-danger small d-block">
                                                        {{ $message }}
                                                    </span>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control @error('investigation_type.2.years_experience') is-invalid @enderror" name="" value="">
                                                    @error('investigation_type.2.years_experience')
                                                    <span role="alert" class="text-danger small d-block">
                                                        {{ $message }}
                                                    </span>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <span class="investigation_span">$</span>
                                                    <input type="text" class="form-control @error('investigation_type.2.hourly_rate') is-invalid @enderror investigation_input_dollar_sign" name="" value="">
                                                    @error('investigation_type.2.hourly_rate')
                                                    <span role="alert" class="text-danger small d-block">
                                                        {{ $message }}
                                                    </span>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <span class="investigation_span">$</span>
                                                    <input type="text" class="form-control @error('investigation_type.2.travel_rate') is-invalid @enderror investigation_input_dollar_sign" name="" value="">
                                                    @error('investigation_type.2.travel_rate')
                                                    <span role="alert" class="text-danger small d-block">
                                                        {{ $message }}
                                                    </span>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <span class="investigation_span">$</span>
                                                    <input type="text" class="form-control @error('investigation_type.2.milage_rate') is-invalid @enderror investigation_input_dollar_sign" name="" value="">
                                                    @error('investigation_type.2.milage_rate')
                                                    <span role="alert" class="text-danger small d-block">
                                                        {{ $message }}
                                                    </span>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-danger remove-misc-row"><i class="fa fa-minus-circle"></i></button>
                                                </td>
                                            </tr>


                                            <tr class="d-none">
                                                <td colspan="7"><button type="button" class="btn btn-success add-more-rows add-misc-row"><i class="fa fa-plus-circle"></i> Add more rows</button></td>
                                            </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="password">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" autocomplete="current-password">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="password-confirm">Password Confirmation</label>
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" id="password-confirm" autocomplete="current-password">
                        @error('password_confirmation')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <input type="hidden" name="id" value="{{ @$investigator->id ?? '' }}">
                    <input type="hidden" name="company_profile_id" value="{{ @$user->company_profile_id ?? '' }}">

                    <div class="mb-3">
                        <label class="form-label" for="role">Role</label>
                        <input type="text" disabled name="role" value="Investigator" class="form-control" id="role">
                    </div>

                    <button type="submit" class="btn btn-primary">{{ @$investigator->id ? 'Update' : 'Submit' }}</button>
                    @if (@$investigator->id)
                    <a href="{{ route('company-admin.internal-investigators.reset-password', @$investigator->id) }}">
                        <button type="button" class="btn btn-primary">Reset Password</button>
                    </a>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
@endsection