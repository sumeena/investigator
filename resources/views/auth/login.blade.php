@extends('layouts.app')
@section('title')
{{ __('Login') }}
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2>Servicing the the Greater San Francisco<br>Bay Area, San Jose, Sacramento, Fresno<br>and Southern California since 1969.</h2>
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
                <h2 class="text-center"><b>Our Services</b></h2>
            </div>
            <div class="col-md-4 mt-4">
                <ul>
                    <li>
                        <p><img width="20" src="{{ asset('html/green_tick.png') }}"> INVESTIGATION</p>
                    </li>
                </ul>
            </div>
            <div class="col-md-4 mt-4">
                <ul>
                    <li>
                        <p><img width="20" src="{{ asset('html/green_tick.png') }}"> ACTIVITY CHECK</p>
                    </li>
                </ul>
            </div>
            <div class="col-md-4 mt-4">
                <ul>
                    <li>
                        <p><img width="20" src="{{ asset('html/green_tick.png') }}"> SOCIAL MEDIA CHECKS</p>
                    </li>
                </ul>
            </div>

            <div class="col-md-4 mt-4">
                <ul>
                    <li>
                        <p><img width="20" src="{{ asset('html/green_tick.png') }}"> BACKGROUND CHECKS</p>
                    </li>
                </ul>
            </div>
            <div class="col-md-4 mt-4">
                <ul>
                    <li>
                        <p><img width="20" src="{{ asset('html/green_tick.png') }}"> AOE/COE INVESTIGATIONS</p>
                    </li>
                </ul>
            </div>
            <div class="col-md-4 mt-4">
                <ul>
                    <li>
                        <p><img width="20" src="{{ asset('html/green_tick.png') }}"> RECORDED STATEMENT INVESTIGATIONS</p>
                    </li>
                </ul>
            </div>

            <div class="col-md-4 mt-4">
                <ul>
                    <li>
                        <p><img width="20" src="{{ asset('html/green_tick.png') }}"> TRANSCRIPTION</p>
                    </li>
                </ul>
            </div>
            <div class="col-md-8 mt-4">
                <ul>
                    <li>
                        <p><img width="20" src="{{ asset('html/green_tick.png') }}"> PHARMACY/MEDICAL SWEEP INVESTIGATIONS</p>
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

            <div class="col-md-12 mt-4">
                <h4 style="margin-left: 40px;"><b>For Company:</b></h4>
                <ul class="mt-4">
                    <li><p><img width="20" src="{{ asset('html/green_tick.png') }}"> Register as company</p></li>
                    <li><p><img width="20" src="{{ asset('html/green_tick.png') }}"> Add staff members</p></li>
                    <li><p><img width="20" src="{{ asset('html/green_tick.png') }}"> Create assignments and search for the right investigator from the available database.</p></li>
                    <li><p><img width="20" src="{{ asset('html/green_tick.png') }}"> Filter investigators based on their availability, distance, rates etc.</p></li>
                    <li><p><img width="20" src="{{ asset('html/green_tick.png') }}"> Chat with the shortlisted candidates.</p></li>
                </ul>
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