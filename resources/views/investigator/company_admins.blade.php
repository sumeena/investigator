@extends('layouts.dashboard')
@section('title', 'Company Admins')
@section('content')
    <div class="card">
        <h5 class="card-header">Companies</h5>
        <p class="card-body">You can block the companies so that your profile is not visible in their search.</p>

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

            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Company Name</th>
                    <th class="text-center">Is Blocked</th>
                </tr>
                </thead>
                <tbody>
                @foreach($companyAdmins as $key=>$value)
                    <tr>
                        <td>{{ $companyAdmins->firstItem() + $loop->index }}</td>
                        <td>{{$value->first_name}} {{$value->last_name}}</td>
                        <td class="text-center">
                            @if(auth()->user()->checkIsBlockedCompanyAdmin($value->id))
                                <label for="unblock-user">
                                    <input class="form-check-input" type="checkbox" name="unblock_user" value="1"
                                           id="unblock-user-{{ $value->id }}" checked
                                           onchange="blockUnblockCompanyAdmin(`{!! $value->id !!}`, false)">
                                </label>
                            @else
                                <label for="block-user">
                                    <input class="form-check-input" type="checkbox" name="block_user" value="1"
                                           id="block-user-{{ $value->id }}"
                                           onchange="blockUnblockCompanyAdmin(`{!! $value->id !!}`, true)">
                                </label>
                            @endif

                            <form action="{{ route('investigator.company-admins.block-unblock', $value->id) }}"
                                  method="POST"
                                  id="block-user-form-{{$value->id}}">
                                @csrf
                            </form>
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

@push('scripts')
    <script type="text/javascript">
        function blockUnblockCompanyAdmin(id, isBlocked = true) {
            if (isBlocked) {
                if (confirm('Are you sure you want to block this user?')) {
                    $(`#block-user-${id}`).prop('checked', true);
                    $('#block-user-form-' + id).submit();
                } else {
                    $(`#block-user-${id}`).prop('checked', false);
                }
            } else {
                if (confirm('Are you sure you want to unblock this user?')) {
                    $(`#unblock-user-${id}`).prop('checked', false);
                    $('#block-user-form-' + id).submit();
                } else {
                    $(`#unblock-user-${id}`).prop('checked', true);
                }
            }
        }
    </script>
@endpush
