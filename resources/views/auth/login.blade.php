@extends('layouts.app')
@section('title')
{{ __('Login') }}
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2>iLogistics is the platform for experienced investigators to get matched efficiently to cases that fit their: schedule, distance and rates.</h2>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                <a href="/register" class="btn btn-primary">
                                    {{ __('Register') }}
                                    </button>

                                    @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                    @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="card mt-4">
        <div class="row mt-4 our-services justify-content-center">
            <div class="col-md-12">
                <h2 class="text-center"><b>Customized Filtering and Search Parameters</b></h2>
                <h4 class="text-center">Investigation Firms can search using the same criteria the investigators customize.</h4>
            </div>
            <div class="col-md-4 mt-4">
                <ul>
                    <li>
                        <p><img width="20" src="{{ asset('html/green_tick.png') }}"> AVAILABILITY</p>
                    </li>
                </ul>
            </div>
            <div class="col-md-4 mt-4">
                <ul>
                    <li>
                        <p><img width="20" src="{{ asset('html/green_tick.png') }}"> DISTANCE</p>
                    </li>
                </ul>
            </div>
            <div class="col-md-4 mt-4">
                <ul>
                    <li>
                        <p><img width="20" src="{{ asset('html/green_tick.png') }}"> HOURLY RATE</p>
                    </li>
                </ul>
            </div>

            <div class="col-md-4 mt-4">
                <ul>
                    <li>
                        <p><img width="20" src="{{ asset('html/green_tick.png') }}"> TRAVEL RATE</p>
                    </li>
                </ul>
            </div>
            <div class="col-md-4 mt-4">
                <ul>
                    <li>
                        <p><img width="20" src="{{ asset('html/green_tick.png') }}"> MILEAGE RATE</p>
                    </li>
                </ul>
            </div>
            <div class="col-md-4 mt-4">
                <ul>
                    <li>
                        <p><img width="20" src="{{ asset('html/green_tick.png') }}"> EXPERIENCE LEVEL</p>
                    </li>
                </ul>
            </div>

            <div class="col-md-4 mt-4">
                <ul>
                    <li>
                        <p><img width="20" src="{{ asset('html/green_tick.png') }}"> INVESTIGATOR PERFORMANCE RATING</p>
                    </li>
                </ul>
            </div>
            <div class="col-md-4 mt-4">
                <ul>
                    <li>
                        <p><img width="20" src="{{ asset('html/green_tick.png') }}"> IMMEDIATE TEXT NOTIFICATION</p>
                    </li>
                </ul>
            </div>

            <div class="col-md-4 mt-4">
                <ul>
                    <li>
                        <p><img width="20" src="{{ asset('html/green_tick.png') }}"> INTERNAL STAFF SCHEDULING</p>
                    </li>
                </ul>
            </div>

        </div>
    </div>




    <div class="card mt-4">
        <div class="row mt-4 our-services justify-content-center">
            <div class="col-md-12">
                <h2 class="text-center"><b>About US</b></h2>
            </div>

            <div class="mt-4 col-md-12">
                <p class="text-center">iLogisticsinc is an Investigation Professionals Company of experience, communication and results.</p>
                <p class="text-center">Our platform provides services for companies looking for surveillance services and for surveillance investigator projects.</p>
            </div>

            <div class="col-md-12 mt-4 company-about-us">
                <h4 style="margin-left: 40px;"><b>Investigative Agencies:</b></h4>

                <p class="m-l-5">
                    iLogistics platform provides a comprehensive solution for efficiently managing and assigning insurance investigation cases. If you have a need for experienced and trained staff investigators that know how to write reports & updates, get & send video and follow instructions that are throughout the state then this platform is a great tool.
                </p>
                <p class="m-l-5">
                    Your case is matched with investigators that have synced their calendars with iLogistics platform so you only see the investigators that meet your time frame and are in the location you need.
                </p>
                <p class="m-l-5">
                    iLogistics filters the investigator pool per your needs by;
                </p>

                <ul class="mt-4">
                    <li><p><img width="20" src="{{ asset('html/green_tick.png') }}"> Availability</p></li>
                    <li><p><img width="20" src="{{ asset('html/green_tick.png') }}"> Location</p></li>
                    <li><p><img width="20" src="{{ asset('html/green_tick.png') }}"> Experience Level</p></li>
                    <li><p><img width="20" src="{{ asset('html/green_tick.png') }}"> Cost.</p></li>
                </ul>

                <p class="m-l-5"> You then get a list of investigators that match your needs and you decide to send them a case notification. The investigators instantly get a text and email. They then confirm the case and you can get it scheduled.</p>
                <p class="m-l-5">iLogistics platform can work for your current in house investigators or you can use additional investigator resources. Giving you the ability to quickly make fast comparisons to as to who best assign the cases based on time frame, experience, availability and cost.</p>
                <p class="m-l-5">Whether you use the platform to schedule only in house investigators or other investigative resources, iLogistics is the most efficient unbiased way to quickly schedule your assignments.</p>

            </div>


            <div class="col-md-12 mt-4">
                <h4 style="margin-left: 40px;"><b>For Investigators:</b></h4>
                <ul class="mt-4">
                    <li><p><img width="20" src="{{ asset('html/green_tick.png') }}"> Register as an investigator</p></li>
                    <li><p><img width="20" src="{{ asset('html/green_tick.png') }}"> Complete your profile</p></li>
                    <li><p><img width="20" src="{{ asset('html/green_tick.png') }}"> Connect your google calendar for your availability.</p></li>
                    <li><p><img width="20" src="{{ asset('html/green_tick.png') }}"> Get your profile viewed by companies looking for hiring.</p></li>
                    <li><p><img width="20" src="{{ asset('html/green_tick.png') }}"> Get invites and chat before accepting any offer.</p></li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection