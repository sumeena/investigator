@extends('layouts.dashboard')
@section('title', 'Dashboard')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                @if(session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 mb-4 order-0">
                <div class="card">
                    <div class="d-flex align-items-end row">
                        <div class="col-sm-7">
                            <div class="card-body">
                                <h5 class="card-title text-primary">Dashboard</h5>
                                <p class="mb-4">
                                    <span class="fw-bold">Hiring Manager</span> Dashboard 
                                </p>
                                <table class="table" id="assignment-table">
                                 <tbody>
                                    <tr>
                                       <td>Assignments</td>
                                       <td>{{$assignmentCount}}</td>
                                    </tr>
                                    <tr>
                                       <td>Company admin users</td>
                                       <td>{{$companyAdminCount}}</td>
                                    </tr>
                                    <tr>
                                       <td>Company HM  users</td>
                                       <td>{{$companyHmCount}}</td>
                                    </tr>
                                    <tr>
                                       <td>Internal Investigators</td>
                                       <td>{{$internalCount}}</td>
                                    </tr>
                              </tbody>

                              </table>

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
        </div>
    </div>
@endsection
