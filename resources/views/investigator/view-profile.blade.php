@extends('layouts.dashboard')
@section('title', 'Investigator Profile')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card profileData">
                    <!-- Profile start -->
                    <div class="row">
                        <div class="col">
                            <h5 class="">
                                Investigator Profile

                                <a href="/investigator/profile"
                                   class="text-white float-end btn btn-outline-primary btn-sm mt-n1">
                                    Edit Investigator Profile
                                </a>
                            </h5>


                            {{--<a href="/investigator/profile" class="investigator-view-profile-link">
                                <button type="button">Edit Investigator Profile</button>
                            </a>--}}
                        </div>
                    </div>
                    <div class="row mx-0 py-1 px-3">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <b><label>First Name:</label></b>
                                </div>
                                <div class="col-md-6">{{ $user->first_name ?? 'N/A' }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <b><label>Last Name:</label></b>
                                </div>
                                <div class="col-md-6">{{ $user->last_name ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="row mx-0 py-1 px-3">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <b><label>Email:</label></b>
                                </div>
                                <div class="col-md-6">{{ $user->email ?? 'N/A' }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <b><label>Phone Number:</label></b>
                                </div>
                                <div class="col-md-6">{{ $user->phone ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="row mx-0 py-1 px-3">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <b><label>Address:</label></b>
                                </div>
                                <div class="col-md-6">{{ $user->address ?? 'N/A' }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <b><label>Address 1:</label></b>
                                </div>
                                <div class="col-md-6">{{ $user->address_1 ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="row mx-0 py-1 px-3">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <b><label>City:</label></b>
                                </div>
                                <div class="col-md-6">{{ $user->city ?? 'N/A' }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <b><label>State:</label></b>
                                </div>
                                <div class="col-md-6">{{ $user->state ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="row mx-0 py-1 px-3">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <b><label>Country:</label></b>
                                </div>
                                <div class="col-md-6">{{ $user->country ?? 'N/A' }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <b><label>Zip Code :</label></b>
                                </div>
                                <div class="col-md-6">{{ $user->zipcode ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="row mx-0 py-1 px-3">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-3">
                                    <b><label>Bio :</label></b>
                                </div>
                                <div class="col-md-9">{{ $user->bio ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </div>
                    <!-- Profile end -->

                    <!-- Service lines start -->
                    <div class="row pt-3">
                        <div class="col">
                            <h5 class="">Service Lines</h5>
                        </div>
                    </div>
                    @forelse($serviceLines as $serviceLine)
                        <div class="row mx-0 py-1 px-3">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <b><label>Investigation Types:</label></b>
                                    </div>
                                    <div class="col-md-6">{{ ucfirst($serviceLine->investigation_type) }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <b><label>Case Experience :</label></b>
                                    </div>
                                    <div class="col-md-6">{{ $serviceLine->case_experience_text }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="row mx-0 py-1 px-3">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <b><label>Years Experience:</label></b>
                                    </div>
                                    <div class="col-md-6">{{ $serviceLine->years_experience }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <b><label>Contractor Hourly Rate :</label></b>
                                    </div>
                                    <div class="col-md-6"><b>$</b>{{ $serviceLine->hourly_rate }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="row mx-0 py-1 px-3">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <b><label>Contractor Travel Rate:</label></b>
                                    </div>
                                    <div class="col-md-6"><b>$</b>{{ $serviceLine->travel_rate }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <b><label>Contractor Milage Rate :</label></b>
                                    </div>
                                    <div class="col-md-6"><b>$</b>{{ $serviceLine->milage_rate }}</div>
                                </div>
                            </div>
                        </div>
                        @if(!$loop->last)
                            <hr>
                        @endif
                    @empty
                        <p class="text-center">Records not found!</p>
                    @endforelse
                    <!-- Service lines end -->

                    <!-- Review start -->
                    <div class="row mx-0 py-2 px-3 highlightRow mt-3">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <b><label>Video Capture Rate:</label></b>
                                </div>
                                <div
                                    class="col-md-6">
                                    {{ ($review && $review->video_claimant_percentage) ?
                                            $review->video_claimant_percentage . '%' : 'N/A' }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <b><label>Upload a survelance report writing Sample :</label></b>
                                </div>
                                <div class="col-md-6">
                                    @if($review && $review->survelance_report)
                                        <a class="fileText"
                                           href="{{ Storage::disk('public')->url($review->survelance_report) }}"
                                           target="_blank">
                                            survelance-report.{{ $review->report_file_ext }}
                                        </a>
                                    @else
                                        <span class="fileText">
                                                N/A
                                            </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Review end -->

                    <!-- Equipment start -->
                    <div class="row pt-3">
                        <div class="col">
                            <h5 class="">Equipment</h5>
                        </div>
                    </div>
                    @if($equipment)
                        <div class="row mx-0 py-1 px-3">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <b><label>Camera Type:</label></b>
                                    </div>
                                    <div
                                        class="col-md-6">
                                        {{ ($equipment && $equipment->camera_type) ? $equipment->camera_type :  'N/A' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <b><label>Camera Model Number :</label></b>
                                    </div>
                                    <div class="col-md-6">
                                        {{ ($equipment && $equipment->camera_model) ? $equipment->camera_model : 'N/A' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mx-0 py-1 px-3">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <b><label>Dashcam:</label></b>
                                    </div>
                                    <div class="col-md-6">
                                        @if($equipment && $equipment->is_dash_cam)
                                            Yes
                                        @else
                                            No
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <b><label>Convert Video :</label></b>
                                    </div>
                                    <div class="col-md-6">
                                        @if($equipment && $equipment->is_convert_video)
                                            Yes
                                        @else
                                            No
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <p class="text-center">Records not found!</p>
                    @endif
                    <!-- Equipment end -->

                    <!-- Licensing start -->
                    <div class="row pt-3">
                        <div class="col">
                            <h5 class="">Licensing</h5>
                        </div>
                    </div>
                    @forelse($licenses as $license)
                        <div class="row mx-0 py-1 px-3">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <b><label>State:</label></b>
                                    </div>
                                    <div class="col-md-6">{{ $license->state_data->code ?? 'N/A' }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <b><label>License Number :</label></b>
                                    </div>
                                    <div class="col-md-6">{{ $license->license_number ?? 'N/A' }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="row mx-0 py-1 px-3">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <b><label>Expiration date:</label></b>
                                    </div>
                                    <div class="col-md-6">
                                        {{ $license->expiration_date ?
                                            \Carbon\Carbon::parse($license->expiration_date)->format('m/d/Y') : 'N/A' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <b><label>Insurance:</label></b>
                                    </div>
                                    <div class="col-md-6">
                                        @if($license->is_insurance)
                                            Yes
                                        @else
                                            No
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mx-0 py-1 px-3">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <b><label>Upload Insurance File :</label></b>
                                    </div>
                                    <div class="col-md-6">
                                        @if($license->is_insurance && $license->insurance_file)
                                            <a class="fileText"
                                               href="{{ Storage::disk('public')->url($license->insurance_file) }}"
                                               target="_blank">
                                                Insurance.{{ $license->insurance_file_ext }}
                                            </a>
                                        @else
                                            <span class="fileText">N/A</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <b><label>Bonded :</label></b>
                                    </div>
                                    <div class="col-md-6">
                                        @if($license->is_bonded)
                                            Yes
                                        @else
                                            No
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if(!$loop->last)
                            <hr>
                        @endif
                    @empty
                        <p class="text-center">Records not found!</p>
                    @endforelse
                    <!-- Licensing end -->

                    <!-- Work vehicle start -->
                    <div class="row pt-3">
                        <div class="col">
                            <h5 class="">Work Vehicle</h5>
                        </div>
                    </div>
                    @forelse($workVehicles as $workVehicle)
                        <div class="row mx-0 py-1 px-3">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <b><label>Year :</label></b>
                                    </div>
                                    <div class="col-md-6">{{ $workVehicle->year }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <b><label>Make :</label></b>
                                    </div>
                                    <div class="col-md-6">{{ $workVehicle->make }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="row mx-0 py-1 px-3">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <b><label>Model :</label></b>
                                    </div>
                                    <div class="col-md-6">{{ $workVehicle->model }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <b><label>Insurance Company Name :</label></b>
                                    </div>
                                    <div class="col-md-6">{{ $workVehicle->insurance_company }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="row mx-0 py-1 px-3">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <b><label>Policy Number :</label></b>
                                    </div>
                                    <div class="col-md-6">{{ $workVehicle->policy_number }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <b><label>Expiration Date :</label></b>
                                    </div>
                                    <div class="col-md-6">
                                        {{ $workVehicle->expiration_date ?
                                            \Carbon\Carbon::parse($workVehicle->expiration_date)->format('m/d/Y') : 'N/A' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mx-0 py-1 px-3">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <b><label>Picture :</label></b>
                                    </div>
                                    <div class="col-md-6">
                                        @if($workVehicle->picture)
                                            <a class="fileText"
                                               href="{{ Storage::disk('public')->url($workVehicle->picture) }}"
                                               target="_blank">
                                                Picture.{{ $workVehicle->picture_ext }}
                                            </a>
                                        @else
                                            <span class="fileText">N/A</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <b><label>Upload Proof of Insurance :</label></b>
                                    </div>
                                    <div class="col-md-6">
                                        @if($workVehicle->proof_of_insurance)
                                            <a class="fileText"
                                               href="{{ Storage::disk('public')->url($workVehicle->proof_of_insurance) }}"
                                               target="_blank">
                                                Proof.{{ $workVehicle->proof_ext }}
                                            </a>
                                        @else
                                            <span class="fileText">N/A</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if(!$loop->last)
                            <hr>
                        @endif
                    @empty
                        <p class="text-center">Records not found!</p>
                    @endforelse
                    <!-- Work vehicle end -->

                    <!-- Language start -->
                    <div class="row pt-3">
                        <div class="col">
                            <h5 class="">Languages</h5>
                        </div>
                    </div>
                    @forelse($languages as $language)
                        <div class="row mx-0 py-1 px-3">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <b><label>Language Spoken :</label></b>
                                    </div>
                                    <div class="col-md-6">{{ $language->investigatorLanguage->name }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <b><label>Spoken Fluency Level :</label></b>
                                    </div>
                                    <div class="col-md-6">{{ $language->fluency_text }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="row mx-0 py-1 px-3">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <b><label>Reading/Writing Fluency Level :</label></b>
                                    </div>
                                    <div class="col-md-6">{{ $language->writing_fluency_text }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">

                                </div>
                            </div>
                        </div>
                        @if(!$loop->last)
                            <hr>
                        @endif
                    @empty
                        <p class="text-center">Records not found!</p>
                    @endforelse
                    <!-- Language end -->

                    <!-- Documents start -->
                    <div class="row pt-3">
                        <div class="col">
                            <h5 class="">Documents</h5>
                        </div>
                    </div>
                    @if($document)
                        <div class="row mx-0 py-1 px-3">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <b><label>DL :</label></b>
                                    </div>
                                    <div class="col-md-6">
                                        @if($document && $document->driving_license)
                                            <a class="fileText"
                                               href="{{ Storage::disk('public')->url($document->driving_license) }}"
                                               target="_blank">
                                                dl.{{ $document->dl_ext }}
                                            </a>
                                        @else
                                            <span class="fileText">N/A</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <b><label>ID/PassPort Photo :</label></b>
                                    </div>
                                    <div class="col-md-6">
                                        @if($document && $document->passport)
                                            <a class="fileText"
                                               href="{{ Storage::disk('public')->url($document->passport) }}"
                                               target="_blank">
                                                photo.{{ $document->passport_ext }}
                                            </a>
                                        @else
                                            <span class="fileText">N/A</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mx-0 py-1 px-3">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <b><label>SSN :</label></b>
                                    </div>
                                    <div class="col-md-6">
                                        @if($document && $document->ssn)
                                            <a class="fileText"
                                               href="{{ Storage::disk('public')->url($document->ssn) }}"
                                               target="_blank">
                                                SSN.{{ $document->ssn_ext }}
                                            </a>
                                        @else
                                            <span class="fileText">N/A</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <b><label>Birth Certificate :</label></b>
                                    </div>
                                    <div class="col-md-6">
                                        @if($document && $document->birth_certificate)
                                            <a class="fileText"
                                               href="{{ Storage::disk('public')->url($document->birth_certificate) }}"
                                               target="_blank">
                                                certificate.{{ $document->brc_ext }}
                                            </a>
                                        @else
                                            <span class="fileText">N/A</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mx-0 py-1 px-3">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <b><label>Form 19 :</label></b>
                                    </div>
                                    <div class="col-md-6">
                                        @if($document && $document->form_19)
                                            <a class="fileText"
                                               href="{{ Storage::disk('public')->url($document->form_19) }}"
                                               target="_blank">
                                                Form19.{{ $document->form_19_ext }}
                                            </a>
                                        @else
                                            <span class="fileText">N/A</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <p class="text-center">There are no documents!</p>
                    @endif
                    <!-- Documents end -->

                    <!-- Availability start -->
                    <div class="row pt-3">
                        <div class="col">
                            <h5 class="">General availability and notice for lead time?</h5>
                        </div>
                    </div>
                    @if($availability)
                        <div class="row mx-0 py-1 px-3">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <b><label>Days :</label></b>
                                    </div>
                                    <div class="col-md-6">
                                        {{ ($availability && $availability->days) ? $availability->days : 'N/A' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <b><label>Hours :</label></b>
                                    </div>
                                    <div class="col-md-6">
                                        {{ ($availability && $availability->hours) ? $availability->hours : 'N/A' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <p class="text-center">Records not found!</p>
                    @endif

                    <div class="row pt-3">
                        <div class="col">
                            <h5 class="">Availability</h5>
                        </div>
                    </div>
                    @if($availability)
                        <div class="row mx-0 pt-1 pb-4 px-3">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <b><label>Distance - You willing to travel to work a case? (in miles) :</label></b>
                                    </div>
                                    <div class="col-md-6">
                                        {{ ($availability && $availability->distance) ? $availability->distance : 'N/A' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <p class="text-center">Records not found!</p>
                    @endif

                    <div class="row pt-3">
                        <div class="col">
                            <h5 class="">Timezone</h5>
                        </div>
                    </div>
                    @if($availability)
                        <div class="row mx-0 pt-1 pb-4 px-3">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <b><label>Timezone</label></b>
                                    </div>
                                    <div class="col-md-6">
                                        {{ $availability->timezone ? $availability->timezone->timezone . ' - [' . $availability->timezone->name . ']' : ''  }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <p class="text-center">Records not found!</p>
                    @endif
                    <!-- Availability end -->
                </div>
            </div>
        </div>
    </div>
@endsection
