{{assignmentUsers}}
<table class="table" id="investigator-table">
    <thead>
    <tr>
        <th>#</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Surveillance</th>
        <th>Hourly Rate</th>
        <th>Statements</th>
        <th>Hourly Rate</th>
        <th>Misc</th>
        <th>Hourly Rate</th>
        <th class="text-center">Distance (In Miles)</th>
        <th class="text-center">Action</th>
    </tr>
    </thead>
    <tbody>
    @forelse($investigators as $investigator)
        <tr>
            <td>{{ $investigators->firstItem() + $loop->index }}</td>
            <td>{{ $investigator->first_name }}</td>
            <td>{{ $investigator->last_name }}</td>
            @php
                $surv = $investigator->getServiceType('surveillance');
                $stat = $investigator->getServiceType('statements');
                $misc = $investigator->getServiceType('misc');
            @endphp
            <td>{{ $surv ? 'Yes' : '-' }}</td>
            <td>{{ $surv ? $surv->hourly_rate : '-' }}</td>
            <td>{{ $stat ? 'Yes' : '-' }}</td>
            <td>{{ $stat ? $stat->hourly_rate : '-' }}</td>
            <td>{{ $misc ? 'Yes' : '-' }}</td>
            <td>{{ $misc ? $misc->hourly_rate : '-' }}</td>
            <td class="text-center">{{ number_format($investigator->calculated_distance, 2) }}
                miles
            </td>
            <td class="text-center">
                <button type="button"
                        class="btn btn-info btn-sm inviteSendBtn"
                        data-assignment-count="{{ $assignmentCount }}"
                        data-investigator-id="{{ $investigator->id }}">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="100%" class="text-center">No investigators found!</td>
        </tr>
    @endforelse
    </tbody>
    @if(count($investigators))
        <tfoot>
        <tr>
            <td colspan="100%">
                <div class="float-end" id="pagination-links">
                    {{ $investigators->withQueryString()->links() }}
                </div>
            </td>
        </tr>
        </tfoot>
    @endif
</table>
