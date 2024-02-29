<table class="table" id="investigator-table">
    <thead>
        <tr>
            <th><input type="checkbox" class="select-all-investigators"></th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Surveillance</th>
            <th>Hourly Rate</th>
            <th>Statements</th>
            <th>Hourly Rate</th>
            <th>Misc</th>
            <th>Hourly Rate</th>
            <th class="text-center">Distance (In Miles)</th>
            <th class="text-center">Estimated Cost</th>
            <th class="text-center">Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse($investigators as $investigator)
        <tr>
            @php
            $hourlyRate = $mileageRate = 0;
            foreach($investigator->investigatorServiceLines as $serviceLine)
            {
                if($serviceLine->investigation_type == NULL) {
                    $hourlyRate = $hourlyRate+$serviceLine->hourly_rate;
                    $mileageRate = $mileageRate+$serviceLine->milage_rate;
                }
                else if($service == $serviceLine->investigation_type_id) {
                    $hourlyRate = $serviceLine->hourly_rate;
                    $mileageRate = $serviceLine->milage_rate;
                }
            }

            $disabled = '';

            if(in_array($investigator->id,$assignmentUsers))
            $disabled = 'disabled';

            $serviceCost = 0;
            $dayTypes = explode(',', $days);

            foreach($dayTypes as $day){
                if($day == 1)
                $hours = 4;
                else if($day == 2)
                $hours = 8;

                $serviceCost = $serviceCost + ($hourlyRate * $hours);
            }

           $mileageCost = ((number_format((float)$investigator->calculated_distance, 2, '.', '')*2) * $mileageRate);

           $estimatedCost = $mileageCost+$serviceCost;

                $investigator->surveillance = $investigator->statements = $investigator->misc = '';
                foreach($investigator->investigatorServiceLines as $serviceline) {
                    if($serviceline->investigation_type == 'surveillance')
                    $investigator->surveillance = 'surveillance';
                    
                    if($serviceline->investigation_type == 'statements')
                    $investigator->statements = 'statements';

                    if($serviceline->investigation_type == '')
                    $investigator->misc = 'misc';
                }
                
            @endphp
            <td>
                <input {{$disabled}} data-userid="{{ $investigator->id }}" class="send-invite-checkbox" type="checkbox"> <!-- {{ $investigators->firstItem() + $loop->index }} -->
            </td>
            <td>{{ $investigator->first_name }}</td>
            <td>{{ $investigator->last_name }}</td>

            <td>{{ $investigator->surveillance ? 'Yes' : '-' }}</td>
            <td>{{ $investigator->surveillance ? $hourlyRate : '-' }}</td>
            <td>{{ $investigator->statements ? 'Yes' : '-' }}</td>
            <td>{{ $investigator->statements ? $hourlyRate : '-' }}</td>
            <td>{{ $investigator->misc ? 'Yes' : '-' }}</td>
            <td>{{ $investigator->misc ? $hourlyRate : '-' }}</td>
            <td class="text-center">{{ number_format((float)$investigator->calculated_distance, 2) }}
                miles
            </td>
            <td>${{$estimatedCost}}</td>
            <td class="text-center">

                @if(!empty($disabled))
                <button type="button" {{$disabled}} class="btn btn-success btn-sm inviteSendBtn" data-assignment-count="{{ $assignmentCount }}" data-investigator-id="{{ $investigator->id }}">
                    <i class="fas fa-check"></i>
                </button>
                @else
                <button type="button" class="btn btn-info bt+n-sm inviteSendBtn" data-assignment-count="{{ $assignmentCount }}" data-investigator-id="{{ $investigator->id }}">
                    <i class="fas fa-paper-plane"></i>
                </button>
                @endif
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