@extends('layouts.dashboard')
@section('title', 'Dashboard')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        {{--<div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="card">
                    <div class="d-flex align-items-end row">
                        <div class="col-sm-7">
                            <div class="card-body">
                                <h5 class="card-title text-primary">Dashboard</h5>
                                <p class="mb-4">
                                    <span class="fw-bold">Admin</span> Dashboard <span class="fw-bold">Features</span>
                                    Coming Soon!
                                </p>

                                <!-- <a href="javascript:;" class="btn btn-sm btn-outline-primary">View Badges</a> -->
                            </div>
                        </div>
                        <div class="col-sm-5 text-center text-sm-left">
                            <div class="card-body pb-0 px-0 px-md-4">
                                <img
                                    src="html/assets/img/illustrations/man-with-laptop-light.png"
                                    height="140"
                                    alt="View Badge User"
                                    data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                    data-app-light-img="illustrations/man-with-laptop-light.png"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>--}}

        <div class="row">
            <div class="col-xl-6 col-md-6">
                <div class="card mini-stat">
                    <div class="card-body">
                        <div class="mb-4">
                            <h5 class="font-size-16 text-uppercase">Investigators</h5>
                            <h4 class="fw-medium font-size-24">{{ $investigators_count }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-md-6">
                <div class="card mini-stat">
                    <div class="card-body">
                        <div class="mb-4">
                            <h5 class="font-size-16 text-uppercase">Hiring Managers</h5>
                            <h4 class="fw-medium font-size-24">{{ $hm_count }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
