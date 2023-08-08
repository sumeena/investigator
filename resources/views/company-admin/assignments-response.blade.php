<table class="table" id="assignment-table">
    <thead>
    <tr>
        <th>#</th>
        <th>Assignment ID</th>
        <th>Client ID</th>
        <th>Date Saved</th>
        <th class="text-center">Action</th>
    </tr>
    </thead>
    <tbody>
    @forelse($assignments as $assignment)
        <tr>
            <td>{{ $assignments->firstItem() + $loop->index }}</td>
            <td>{{ Str::upper($assignment->assignment_id) }}</td>
            <td>{{ Str::upper($assignment->client_id) }}</td>
            <td>
                {{ $assignment->created_at->format('m/d/Y') }}
            </td>

            <td class="text-center">
                <button type="button"
                        class="btn btn-info btn-sm editAssignmentBtn"
                        data-id="{{ $assignment->id }}">
                    <i class="fas fa-pencil"></i>
                </button>

                <button type="button"
                        class="btn btn-danger btn-sm deleteAssignmentBtn"
                        data-id="{{ $assignment->id }}">
                    <i class="fas fa-trash"></i>
                </button>
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
