@extends('layouts.dashboard')
@section('title', 'Hiring Managers')
@section('content')
    <div class="card manage-index-list">
        <h5 class="card-header">Manage Hiring Managers</h5>
        <a href="{{ route('admin.hiring-managers.add') }}" class="float-right">
            <button type="button" class="btn btn-primary" style="float:right;margin-right: 26px;">
                Add Hiring Manager
            </button>
        </a>
        <div class="table-responsive text-nowrap">
            @if (session('success'))
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
                        <th>Company</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($hiringManagers as $key => $value)
                        <tr>
                            <td>{{ $hiringManagers->firstItem() + $loop->index }}</td>
                            <td>{{ $value->first_name }}</td>
                            <td>{{ $value->last_name }}</td>
                            <td>{{ $value->email }}</td>
                            <td>{{ $value?->parentCompany?->company->first_name }} {{ $value?->parentCompany?->company->last_name }}</td>
                            <td>
                                <a href="{{ route('admin.hiring-managers.edit', $value->id) }}">Edit</a> | <a onclick="return confirm('Are you sure want to delete?')" href="{{ route('admin.hiring-managers.delete', $value->id) }}">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

                @if (count($hiringManagers))
                    <tfoot>
                        <tr>
                            <td colspan="100%">
                                <div class="float-end">
                                    {{ $hiringManagers->withQueryString()->links() }}
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>
    </div>
@endsection
