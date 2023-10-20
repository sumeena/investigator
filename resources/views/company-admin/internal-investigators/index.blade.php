@extends('layouts.dashboard')

@section('title', 'Company Users')

@section('content')
    <div class="card manage-index-list">
        <h5 class="card-header">Manage Internal Investigators</h5>
        <a href="{{ route('company-admin.internal-investigators.add') }}" class="float-right">
            <button type="button" class="btn btn-primary" style="float:right;margin-right: 26px;">
                Invite Investigator
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
{{--                    <th>Role</th>--}}
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @if($investigators->count())
                    @foreach($investigators as $key => $investigator)
                        <tr>
                            <td>{{ $investigators->firstItem() + $loop->index }}</td>
                            <td>{{$investigator->first_name}}</td>
                            <td>{{$investigator->last_name}}</td>
                            <td>{{$investigator->email}}</td>
                            {{--<td>
                                {{ ucfirst($investigator->userRole->role) }}
                            </td>--}}
                            <td>
                                <a href="{{ route('company-admin.internal-investigators.edit', $investigator->id) }}">Edit</a>
                                | <a
                                    onclick="return confirm('Are you sure want to delete?')"
                                    href="{{route('company-admin.internal-investigators.delete', $investigator->id)}}">Delete</a>
                                    | <a href="/company-admin/investigators/{{$investigator->id}}/view">View</a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="text-center" colspan="100%">
                            No internal investigators found!
                        </td>
                    </tr>
                @endif
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
