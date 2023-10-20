@php
            $action = route('company-admin.find_investigator');
            $assignmentsAction = route('company-admin.assignments');
            $assignmentCreateAction = route('company-admin.assignments.create');
            $assignmentStoreAction = route('company-admin.assignments.store');
            $assignmentEditAction = 'company-admin.assignments.edit';
            $assignmentShowAction = 'company-admin.assignment.show';
            $assignmentInviteAction = route('company-admin.assignments.invite');
            $assignmentSelect2Action = route('company-admin.select2-assignments');
            $searchStoreAction = route('company-admin.save-investigator-search-history');
            if (request()->routeIs('hm.assignments')) {
            $action = route('hm.find_investigator');
            $assignmentsAction = route('hm.assignments');
            $assignmentCreateAction = route('hm.assignments.create');
            $assignmentEditAction = 'hm.assignments.edit';
            $assignmentShowAction = 'hm.assignment.show';
            $assignmentStoreAction = route('hm.assignments.store');
            $assignmentInviteAction = route('hm.assignments.invite');
            $assignmentSelect2Action = route('hm.select2-assignments');
            $searchStoreAction = route('hm.save-investigator-search-history');
            }
            @endphp

<!-- <table class="table" id="assignment-table">
    <thead>
        <tr>
            <th>#</th>
            <th>Assignment ID</th>
            <th>Client ID</th>
            <th>Invites Sent</th>
            <th>Status</th>
            <th>Date Created</th>
            <th class="text-center">Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse($assignments as $assignment)
        <tr>
            <td>{{ $assignments->firstItem() + $loop->index }}</td>
            <td>{{ Str::upper($assignment->assignment_id) }}</td>
            <td>{{ Str::upper($assignment->client_id) }}</td>
            <td>{{ Str::upper($assignment->users_count) }}</td>
            <td>{{ Str::upper($assignment->status) }}</td>
            <td>
                {{ $assignment->created_at->format('m/d/Y') }}
            </td>

            <td class="text-center">
                <a href="{{ route('company-admin.assignments.edit', [$assignment->id]) }}"><i class="fas fa-pencil"></i></a> |

                <a href="{{ route('company-admin.assignment.show', [$assignment->id]) }}"><i class="fas fa-eye"></i></a> |

                @php
                $pointer="pointer-events: none";
                if($assignment->status == 'OPEN')
                $pointer="";
                @endphp
                <a style="@php echo $pointer; @endphp" href="javascript:void(0)" class="deleteAssignmentBtn" data-id="{{ $assignment->id }}">
                    <i class="fas fa-trash"></i>
                </a> |
                <a class="callCloneAssignmentModal" data-assignment-id="{{ $assignment->id }}" data-assignment-url="{{ $assignmentCreateAction }}" data-client-id="{{ $assignment->client_id }}" href="javascript:void(0)"><i class="fa-solid fa-clone"></i></a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="100%" class="text-center">
                No assignments found!
            </td>
        </tr>
        @endforelse
    </tbody>
    @if(count($assignments))
    <tfoot>
        <tr>
            <td colspan="100%">
                <div class="float-end" id="assignment-pagination-links">
                    {{ $assignments->withQueryString()->links() }}
                </div>
            </td>
        </tr>
    </tfoot>
    @endif
</table> -->


<table class="table" id="assignment-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Assignment ID</th>
                                            <th>Client ID</th>
                                            <th>Created By</th>
                                            <th>Invites Sent</th>
                                            <th>Status</th>
                                            <th>Date Created</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($assignments as $assignment)
                                        <tr>
                                            <td>{{ $assignments->firstItem() + $loop->index }}</td>
                                            <td>{{ Str::upper($assignment->assignment_id) }}</td>
                                            <td>{{ Str::upper($assignment->client_id) }}</td>
                                            <td>{{ $assignment->author->first_name }} {{ $assignment->author->last_name }}</td>
                                            <td>{{ Str::upper($assignment->users_count) }}</td>
                                            <td>{{ Str::upper($assignment->status) }}</td>
                                            <td>
                                                {{ $assignment->created_at->format('m/d/Y') }}
                                            </td>

                                            <td class="text-center">
                                                @php
                                                $pointer="pointer-events: none";
                                                if($assignment->status == 'OPEN' || $assignment->status == 'INVITED')
                                                    $pointer="";
                                                @endphp
                                                <a style="@php echo $pointer; @endphp" href="{{ route($assignmentEditAction, [$assignment->id]) }}"><i class="fas fa-pencil"></i></a> |

                                                <a href="{{ route($assignmentShowAction, [$assignment->id]) }}"><i class="fas fa-eye"></i></a> |

                                                @php
                                                $pointer="pointer-events: none";
                                                if($assignment->status == 'OPEN')
                                                    $pointer="";
                                                @endphp
                                                <a style="@php echo $pointer; @endphp" href="javascript:void(0)" class="deleteAssignmentBtn" data-id="{{ $assignment->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </a> | 
                                                <a class="callCloneAssignmentModal" data-assignment-id="{{ $assignment->id }}" data-assignment-url="{{ $assignmentCreateAction }}" data-client-id="{{ $assignment->client_id }}" href="javascript:void(0)"><i class="fa-solid fa-clone"></i></a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="100%" class="text-center">
                                                No assignments found!
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                    @if(count($assignments))
                                    <tfoot>
                                        <tr>
                                            <td colspan="100%">
                                                <div class="float-end" id="assignment-pagination-links">
                                                    {{ $assignments->withQueryString()->links() }}
                                                </div>
                                            </td>
                                        </tr>
                                    </tfoot>
                                    @endif
                                </table>