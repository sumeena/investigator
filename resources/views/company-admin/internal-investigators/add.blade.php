@extends('layouts.dashboard')
@section('title', 'Company User')
@section('content')
    <div class="row mt-4 mb-4 justify-content-center">
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
                            <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                                   name="first_name" id="first-name"
                                   value="{{ old('first_name', $investigator->first_name ?? '') }}">
                            @error('first_name')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="last-name">Last Name</label>
                            <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                   name="last_name" id="last-name"
                                   value="{{ old('last_name', $investigator->last_name ??  '') }}">
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
                                    <input type="text" class="form-control" id="email"
                                           value="{{ $investigator->email }}" disabled>
                                    <input type="hidden" class="form-control" required
                                           name="email" value="{{ $investigator->email }}">
                                </div>
                            </div>
                        @else
                            <div class="mb-3">
                                <label class="form-label" for="email">Email</label>
                                <input type="text" class="form-control @error('email') is-invalid @enderror"
                                       name="email" value="{{ old('email') }}" id="email">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        @endif
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
                                                <input class="form-check-input"
                                                       type="checkbox"
                                                       value="surveillance"
                                                       name="investigation_type[0][type]"
                                                    @checked((@$survServiceLine && $survServiceLine->investigation_type == 'surveillance') || old('investigation_type.0.type') == 'surveillance')>
                                            </td>
                                            <td>
                                                <select
                                                    class="form-select @error('investigation_type.0.case_experience') is-invalid @enderror"
                                                    name="investigation_type[0][case_experience]">
                                                    <option value="">--select--</option>
                                                    <option
                                                        value="1" @selected(@$survServiceLine && $survServiceLine->case_experience == 1 || old('investigation_type.0.case_experience') == 1)>
                                                        Under 50
                                                    </option>
                                                    <option
                                                        value="2" @selected(@$survServiceLine && $survServiceLine->case_experience == 2 || old('investigation_type.0.case_experience') == 2)>
                                                        50-499
                                                    </option>
                                                    <option
                                                        value="3" @selected(@$survServiceLine && $survServiceLine->case_experience == 3 || old('investigation_type.0.case_experience') == 3)>
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
                                                <input type="text"
                                                       class="form-control @error('investigation_type.0.years_experience') is-invalid @enderror"
                                                       name="investigation_type[0][years_experience]"
                                                       value="{{ old('investigation_type.0.years_experience', $survServiceLine->years_experience ?? '') }}">
                                                @error('investigation_type.0.years_experience')
                                                <span role="alert" class="text-danger small">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </td>
                                            <td>
                                                <span class="investigation_span">$</span>
                                                <input type="text"
                                                       class="form-control @error('investigation_type.0.hourly_rate') is-invalid @enderror investigation_input_dollar_sign"
                                                       name="investigation_type[0][hourly_rate]"
                                                       value="{{ old('investigation_type.0.hourly_rate', $survServiceLine->hourly_rate ?? '25') }}">
                                                @error('investigation_type.0.hourly_rate')
                                                <span role="alert" class="text-danger small">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </td>
                                            <td>
                                                <span class="investigation_span">$</span>
                                                <input type="text"
                                                       class="form-control @error('investigation_type.0.travel_rate') is-invalid @enderror investigation_input_dollar_sign"
                                                       name="investigation_type[0][travel_rate]"
                                                       value="{{ old('investigation_type.0.travel_rate', $survServiceLine->travel_rate ?? '25') }}">
                                                @error('investigation_type.0.travel_rate')
                                                <span role="alert" class="text-danger small">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </td>
                                            <td>
                                                <span class="investigation_span">$</span>
                                                <input type="text"
                                                       class="form-control @error('investigation_type.0.milage_rate') is-invalid @enderror investigation_input_dollar_sign"
                                                       name="investigation_type[0][milage_rate]"
                                                       value="{{ old('investigation_type.0.milage_rate', $survServiceLine->milage_rate ?? '25') }}">
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
                                                <input class="form-check-input" type="checkbox"
                                                       value="statements"
                                                       name="investigation_type[1][type]"
                                                    @checked(@$statServiceLine && $statServiceLine->investigation_type == 'statements' || old('investigation_type.1.type') == 'statements')>
                                            </td>
                                            <td>
                                                <select
                                                    class="form-select @error('investigation_type.1.case_experience') is-invalid @enderror"
                                                    name="investigation_type[1][case_experience]">
                                                    <option value="">--select--</option>
                                                    <option
                                                        value="1" @selected(@$statServiceLine && $statServiceLine->case_experience == 1 || old('investigation_type.1.case_experience') == 1)>
                                                        Under 50
                                                    </option>
                                                    <option
                                                        value="2" @selected(@$statServiceLine && $statServiceLine->case_experience == 2 || old('investigation_type.1.case_experience') == 2)>
                                                        50-499
                                                    </option>
                                                    <option
                                                        value="3" @selected(@$statServiceLine && $statServiceLine->case_experience == 3 || old('investigation_type.1.case_experience') == 3)>
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
                                                <input type="text"
                                                       class="form-control @error('investigation_type.1.years_experience') is-invalid @enderror"
                                                       name="investigation_type[1][years_experience]"
                                                       value="{{ old('investigation_type.1.years_experience', $statServiceLine->years_experience ?? '') }}">
                                                @error('investigation_type.1.years_experience')
                                                <span role="alert" class="text-danger small">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </td>
                                            <td>
                                                <span class="investigation_span">$</span>
                                                <input type="text"
                                                       class="form-control @error('investigation_type.1.hourly_rate') is-invalid @enderror investigation_input_dollar_sign"
                                                       name="investigation_type[1][hourly_rate]"
                                                       value="{{ old('investigation_type.1.hourly_rate', $statServiceLine->hourly_rate ?? '25') }}">
                                                @error('investigation_type.1.hourly_rate')
                                                <span role="alert" class="text-danger small">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </td>
                                            <td>
                                                <span class="investigation_span">$</span>
                                                <input type="text"
                                                       class="form-control @error('investigation_type.1.travel_rate') is-invalid @enderror investigation_input_dollar_sign"
                                                       name="investigation_type[1][travel_rate]"
                                                       value="{{ old('investigation_type.1.travel_rate', $statServiceLine->travel_rate ?? '25') }}">
                                                @error('investigation_type.1.travel_rate')
                                                <span role="alert" class="text-danger small">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </td>
                                            <td>
                                                <span class="investigation_span">$</span>
                                                <input type="text"
                                                       class="form-control @error('investigation_type.1.milage_rate') is-invalid @enderror investigation_input_dollar_sign"
                                                       name="investigation_type[1][milage_rate]"
                                                       value="{{ old('investigation_type.1.milage_rate', $statServiceLine->milage_rate ?? '25') }}">
                                                @error('investigation_type.1.milage_rate')
                                                <span role="alert" class="text-danger small">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Misc
                                                <input class="form-check-input" type="checkbox" value="misc"
                                                       name="investigation_type[2][type]" @checked(@$miscServiceLine && $miscServiceLine->investigation_type == 'misc' || old('investigation_type.2.type') == 'misc')>
                                            </td>
                                            <td>
                                                <select
                                                    class="form-select @error('investigation_type.2.case_experience') is-invalid @enderror"
                                                    name="investigation_type[2][case_experience]">
                                                    <option value="">--select--</option>
                                                    <option
                                                        value="1" @selected(@$miscServiceLine && $miscServiceLine->case_experience == 1 || old('investigation_type.2.case_experience') == 1)>
                                                        Under 50
                                                    </option>
                                                    <option
                                                        value="2" @selected(@$miscServiceLine && $miscServiceLine->case_experience == 2 || old('investigation_type.2.case_experience') == 2)>
                                                        50-499
                                                    </option>
                                                    <option
                                                        value="3" @selected(@$miscServiceLine && $miscServiceLine->case_experience == 3 || old('investigation_type.2.case_experience') == 3)>
                                                        500+
                                                    </option>
                                                </select>
                                                @error('investigation_type.2.case_experience')
                                                <span role="alert" class="text-danger small">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </td>
                                            <td>
                                                <input type="text"
                                                       class="form-control @error('investigation_type.2.years_experience') is-invalid @enderror"
                                                       name="investigation_type[2][years_experience]"
                                                       value="{{ old('investigation_type.2.years_experience', $miscServiceLine->years_experience ?? '') }}">
                                                @error('investigation_type.2.years_experience')
                                                <span role="alert" class="text-danger small">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </td>
                                            <td>
                                                <span class="investigation_span">$</span>
                                                <input type="text"
                                                       class="form-control @error('investigation_type.2.hourly_rate') is-invalid @enderror investigation_input_dollar_sign"
                                                       name="investigation_type[2][hourly_rate]"
                                                       value="{{ old('investigation_type.2.hourly_rate', $miscServiceLine->hourly_rate ?? '25') }}">
                                                @error('investigation_type.2.hourly_rate')
                                                <span role="alert" class="text-danger small">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </td>
                                            <td>
                                                <span class="investigation_span">$</span>
                                                <input type="text"
                                                       class="form-control @error('investigation_type.2.travel_rate') is-invalid @enderror investigation_input_dollar_sign"
                                                       name="investigation_type[2][travel_rate]"
                                                       value="{{ old('investigation_type.2.travel_rate', $miscServiceLine->travel_rate ?? '25') }}">
                                                @error('investigation_type.2.travel_rate')
                                                <span role="alert" class="text-danger small">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </td>
                                            <td>
                                                <span class="investigation_span">$</span>
                                                <input type="text"
                                                       class="form-control @error('investigation_type.2.milage_rate') is-invalid @enderror investigation_input_dollar_sign"
                                                       name="investigation_type[2][milage_rate]"
                                                       value="{{ old('investigation_type.2.milage_rate', $miscServiceLine->milage_rate ?? '25') }}">
                                                @error('investigation_type.2.milage_rate')
                                                <span role="alert" class="text-danger small">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="password">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                   name="password" id="password" autocomplete="current-password">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="password-confirm">Password Confirmation</label>
                            <input type="password"
                                   class="form-control @error('password_confirmation') is-invalid @enderror"
                                   name="password_confirmation" id="password-confirm" autocomplete="current-password">
                            @error('password_confirmation')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <input type="hidden" name="id"
                               value="{{ @$investigator->id ?? '' }}">
                               <input type="hidden" name="company_profile_id"
                                      value="{{ @$user->company_profile_id ?? '' }}">

                        <div class="mb-3">
                            <label class="form-label" for="role">Role</label>
                            <input type="text" disabled name="role" value="Investigator" class="form-control" id="role">
                        </div>

                        <button type="submit"
                                class="btn btn-primary">{{ @$investigator->id ? 'Update' : 'Submit' }}</button>
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
