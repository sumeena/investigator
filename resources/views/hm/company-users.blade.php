@extends('layouts.dashboard')
@section('title', 'Company Users')
@section('content')
    <div class="card manage-index-list">
        <h5 class="card-header">Company Users</h5>
        <div class="table-responsive text-nowrap">
            @if(session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>First Name</th>
                    <th>Last</th>
                    <th>Email</th>
                    <th>Role</th>
                </tr>
                </thead>
                <tbody>
                @foreach($companyUsers as $key=>$value)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{$value->first_name}}</td>
                        <td>{{$value->last_name}}</td>
                        <td>{{$value->email}}</td>
                        <td>
                            @if($value->userRole->role == 'company-admin')
                                Company Admin
                            @else
                                Hiring Manager
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>

                @if(count($companyUsers))
                    <tfoot>
                    <tr>
                        <td colspan="100%">
                            <div class="float-end">
                                {{ $companyUsers->withQueryString()->links() }}
                            </div>
                        </td>
                    </tr>
                    </tfoot>
                @endif
            </table>
        </div>
    </div>
@endsection
