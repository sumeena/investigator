@extends('layouts.dashboard')
@section('title', 'Invitation Details')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            Invitation Details

                            <a href="{{ route('investigator.invitations.index') }}" class="btn btn-secondary float-end">
                                <i class="fas fa-arrow-left"></i>
                                Back
                            </a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover table-bordered table-striped text-center">
                            <tr>
                                <th>User Name</th>
                                <td>{{ @$assignmentUser->assignment->author->first_name . ' ' . @$assignmentUser->assignment->author->last_name }}</td>
                            </tr>

                            <tr>
                                <th>Email</th>
                                <td>{{ @$assignmentUser->assignment->author->email ?? 'N/A' }}</td>
                            </tr>

                            <tr>
                                <th>Phone</th>
                                <td>{{ @$assignmentUser->assignment->author->phone ?? 'N/A' }}</td>
                            </tr>

                            <tr>
                                <th>Client ID</th>
                                <td>{{ @Str::upper($assignmentUser->assignment->client_id) }}</td>
                            </tr>

                            <tr>
                                <th>Assignment ID</th>
                                <td>{{ @Str::upper($assignmentUser->assignment->assignment_id) }}</td>
                            </tr>

                            <tr>
                                <th>Sent Time</th>
                                <td>{{ $assignmentUser->created_at->diffForHumans() }}</td>
                            </tr>

                        </table>

                        <p class="text-center mt-3">
                            <a href="{{ route('investigator.invitations.destroy', $assignmentUser->id) }}"
                               class="btn btn-outline-danger ms-2"
                               onclick="return confirm('Are you sure want to delete?')">
                                <i class="fas fa-trash"></i>
                                Delete Invitation
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
