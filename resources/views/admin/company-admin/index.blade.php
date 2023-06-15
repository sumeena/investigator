@extends('layouts.dashboard')
@section('content')
    <div class="card manage-index-list">
        <h5 class="card-header">Manage Company Admins</h5>
        <a href="{{ route('admin.company-admins.add') }}" class="float-right">
            <button type="button" class="btn btn-primary" style="float:right;margin-right: 26px;">
                Add Company Admin
            </button>
        </a>
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
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($companyAdmins as $key=>$value)
                    <tr>
                        <td>{{ $companyAdmins->firstItem() + $loop->index }}</td>
                        <td>{{$value->first_name}}</td>
                        <td>{{$value->last_name}}</td>
                        <td>{{$value->email}}</td>
                        <td>
                            <a href="{{ route('admin.company-admins.edit', $value->id) }}">Edit</a> | <a
                                onclick="return confirm('Are you sure want to delete?')"
                                href="{{route('admin.company-admins.delete', $value->id)}}">Delete</a>
                            @if($value->CompanyAdminProfile && $value->CompanyAdminProfile->is_company_profile_submitted)
                                | <a href="{{ route('admin.company-admins.view', $value->id) }}">View</a>
                            @endif
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
        </div>
    </div>
@endsection
