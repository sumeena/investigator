@extends('layouts.dashboard')
@section('title', 'Company Users')
@section('content')
    <div class="card manage-index-list">
        <h5 class="card-header">Manage Company Users</h5>
        <a href="{{ route('company-admin.company-users.add') }}" class="float-right">
            <button type="button" class="btn btn-primary" style="float:right;margin-right: 26px;">
                Add Company User
            </button>
        </a>
        <div class="table-responsive text-nowrap">
            @if(session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            @if(!empty($companyAdmins))
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>First Name</th>
                    <th>Last</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($companyAdmins as $key=>$companyAdmin)
                    <tr>
                        <td>{{ $companyAdmins->firstItem() + $loop->index }}</td>
                        <td>{{$companyAdmin->first_name}}</td>
                        <td>{{$companyAdmin->last_name}}</td>
                        <td>{{$companyAdmin->email}}</td>
                        <td>
                            @if($companyAdmin->userRole->role == 'company-admin')
                                Company Admin
                            @else
                                Hiring Manager
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('company-admin.company-users.edit', $companyAdmin->id) }}">Edit</a> | <a
                                onclick="return confirm('Are you sure want to delete?')"
                                href="{{route('company-admin.company-users.delete', $companyAdmin->id)}}">Delete</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>

                @if(count($companyAdmins))
                    <tfoot>
                    <tr>
                        <td colspan="100%">
                            <div class="float-end">
                                {{ $companyAdmins->withQueryString()->links() }}
                            </div>
                        </td>
                    </tr>
                    </tfoot>
                @endif
            </table>
            @else
            <h2>Users not Found related to You!</h2>
            @endif
        </div>
    </div>
@endsection
