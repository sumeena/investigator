@extends('layouts.dashboard')
@section('title', 'Assignments')
@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            Assignments
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
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

                            <table class="table table-striped table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Company Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Client ID</th>
                                    <th>Assignment ID</th>
                                    <th>Status</th>
                                    <th>Date Received</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($invitations as $invitation)
                                    <tr>
                                        <td>{{ $invitations->firstItem() + $loop->index }}</td>
                                        <td>{{ @$invitation->assignment->author->CompanyAdminProfile->company_name }}</td>
                                        <td>{{ @$invitation->assignment->author->email ?? 'N/A' }}</td>
                                        <td>{{ @$invitation->assignment->author->CompanyAdminProfile->company_phone ?? 'N/A' }}</td>
                                        <td>{{ @Str::upper($invitation->assignment->client_id) }}</td>
                                        <td>{{ @Str::upper($invitation->assignment->assignment_id) }}</td>
                                        <td>{{ @Str::upper($invitation->assignment->status) }}</td>
                                        <!-- <td>{{ $invitation->created_at->diffForHumans() }}</td> -->
                                        <td>{{ $invitation->created_at->format('d-m-Y') }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('investigator.assignment.show', $invitation->id) }}">View</a> |
                                            <a onclick="return confirm('Are you sure want to delete?')"
                                               href="{{ route('investigator.assignment.destroy', $invitation->id) }}">Delete</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="100%" class="text-center">
                                            No invitations found!
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>

                                @if($invitations->count())
                                    <tfoot>
                                    <tr>
                                        <td colspan="100%">
                                            <div class="float-end">
                                                {{ $invitations->withQueryString()->links() }}
                                            </div>
                                        </td>
                                    </tr>
                                    </tfoot>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection