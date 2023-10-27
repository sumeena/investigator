@php
            $action = route('company-admin.find_investigator');
            $assignmentsAction = route('company-admin.assignments');
            $assignmentCreateAction = route('company-admin.assignments.create');
            $assignmentsListAction = route('company-admin.assignments-list');
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
            $assignmentsListAction = route('hm.assignments-list');
            $assignmentStoreAction = route('hm.assignments.store');
            $assignmentInviteAction = route('hm.assignments.invite');
            $assignmentSelect2Action = route('hm.select2-assignments');
            $searchStoreAction = route('hm.save-investigator-search-history');
            }
            @endphp

            <form method="get" action="{{ $assignmentsListAction }}" id="findAssignmentForm">

              <div class="row">
                  <div class="col-md-12">
                      <div class="mb-1">
                          <div class="card">
                              <h5 class="card-header pt-2 pb-0">Search</h5>
                              <div class="table-responsive text-nowrap">
                                  <table class="table hr_contact">
                                      <tbody>
                                      <tr>
                                          <td>
                                              <input type="text" class="form-control"
                                                     name="searchby" placeholder="Search by Assignment ID OR CLIENT ID OR CREATED BY"
                                                     value="<?php if(isset($_GET['searchby'])){ echo $_GET['searchby'];};?>"
                                                     id="searchby">
                                          </td>
                                          <td>
                                              <select class="form-select" name="status-select"
                                                      id="status-select">
                                                  <option value="">Select Status</option>
                                                      <option value="OPEN" <?php  if(isset($_GET['status-select']) && $_GET['status-select'] =="OPEN"){ echo "selected"; };?> >OPEN </option>
                                                      <option value="INVITED" <?php  if(isset($_GET['status-select']) && $_GET['status-select'] =="INVITED"){ echo "selected"; };?> >INVITED </option>
                                                      <option value="ASSIGNED" <?php  if(isset($_GET['status-select']) && $_GET['status-select'] =="ASSIGNED"){ echo "selected"; };?> >ASSIGNED </option>
                                              </select>
                                            </td>
                                            <td>
                                                <input type="submit" value="Search" class="btn btn-primary"/>
                                              </td>
                                        </tr>
                                      </tbody>
                                  </table>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>

              </form>
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
                                            <td>{{ @$assignment->author->first_name }} {{ @$assignment->author->last_name }}</td>
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
