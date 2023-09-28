@php
$assignmentCreateAction = route('company-admin.assignments.create');
if (request()->routeIs('hm.find_investigator')) {
$assignmentCreateAction = route('hm.assignments.create');
}
@endphp

<table class="table" id="assignment-table">
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
</table>