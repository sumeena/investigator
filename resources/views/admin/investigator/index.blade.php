@extends('layouts.dashboard')
@section('title', 'Investigators')
@section('content')
    <div class="card manage-index-list">
        <h5 class="card-header">Manage Investigators</h5>
        <a href="{{ route('admin.investigators.add') }}" class="float-right">
            <button type="button" class="btn btn-primary" style="float:right;margin-right: 26px;">Add Investigator
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
                @foreach($investigators as $key=>$value)
                    <tr>
                        <td>{{ $investigators->firstItem() + $loop->index }}</td>
                        <td>{{$value->first_name}}</td>
                        <td>{{$value->last_name}}</td>
                        <td>{{$value->email}}</td>
                        <td>
                            <a href="{{route('admin.investigators.edit', $value->id)}}">Edit</a> |
                            <a onclick="return confirm('Are you sure want to delete?')"
                               href="{{route('admin.investigators.delete', $value->id)}}">Delete</a>
                            @if($value->is_investigator_profile_submitted)
                                |<a href="{{ route('admin.investigators.view', $value->id) }}">View</a>
                            @endif

                        </td>
                    </tr>
                @endforeach
                </tbody>

                @if(count($investigators))
                    <tfoot>
                    <tr>
                        <td colspan="100%">
                            <div class="float-end">
                                {{ $investigators->withQueryString()->links() }}
                            </div>
                        </td>
                    </tr>
                    </tfoot>
                @endif
            </table>
        </div>
    </div>
@endsection
