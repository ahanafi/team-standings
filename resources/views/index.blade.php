@extends('layouts.template')

@section('content')
    <div class="pricing-header p-3 pb-md-4 mx-auto text-center">
        <h1 class="display-4 fw-normal text-body-emphasis">Simple Team Standings</h1>
        <p class="fs-5 text-body-secondary">
            A simple application for viewing team standings based on the match results.
        </p>
    </div>

    <div class="row row-cols-1 row-cols-md-3 mb-3 text-center">
        <div class="col">
            <div class="card mb-4 rounded-3 shadow-sm">
                <div class="card-header py-3">
                    <h4 class="my-0 fw-normal">Teams</h4>
                </div>
                <div class="card-body">
                    <h1 class="card-title pricing-card-title">$0<small class="text-body-secondary fw-light">/mo</small></h1>
                    <ul class="list-unstyled mt-3 mb-4">
                        <li>10 users included</li>
                        <li>2 GB of storage</li>
                        <li>Email support</li>
                        <li>Help center access</li>
                    </ul>
                    <button type="button" data-bs-toggle="modal" data-bs-target="#team-form-modal" class="w-100 btn btn-lg btn-outline-primary">Input a Team</button>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card mb-4 rounded-3 shadow-sm">
                <div class="card-header py-3">
                    <h4 class="my-0 fw-normal">Matches</h4>
                </div>
                <div class="card-body">
                    <h1 class="card-title pricing-card-title">$15<small class="text-body-secondary fw-light">/mo</small></h1>
                    <ul class="list-unstyled mt-3 mb-4">
                        <li>20 users included</li>
                        <li>10 GB of storage</li>
                        <li>Priority email support</li>
                        <li>Help center access</li>
                    </ul>
                    <button type="button" class="w-100 btn btn-lg btn-primary">Input Match Result</button>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card mb-4 rounded-3 shadow-sm border-primary">
                <div class="card-header py-3 text-bg-primary border-primary">
                    <h4 class="my-0 fw-normal">Team Standings</h4>
                </div>
                <div class="card-body">
                    <h1 class="card-title pricing-card-title">$29<small class="text-body-secondary fw-light">/mo</small></h1>
                    <ul class="list-unstyled mt-3 mb-4">
                        <li>30 users included</li>
                        <li>15 GB of storage</li>
                        <li>Phone and email support</li>
                        <li>Help center access</li>
                    </ul>
                    <button type="button" class="w-100 btn btn-lg btn-primary">View Team Standings</button>
                </div>
            </div>
        </div>
    </div>


    {{-- Modal team form --}}
    <div class="modal fade" id="team-form-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="team-form-modal-label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="team-form-modal-label">Create new team</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="team-name" class="col-form-label">Team Name:</label>
                        <input type="text" class="form-control" id="team-name">
                    </div>
                    <div class="mb-3">
                        <label for="team-city" class="col-form-label">City:</label>
                        <input type="text" class="form-control" id="team-city">
                    </div>
                </div>
                <div class="modal-footer d-flex flex-row justify-content-between">
                    <button type="button" id="btn-clos-team-form" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="btn-save-team" class="btn btn-primary">Save Team</button>
                </div>
            </div>
        </div>
    </div>


    {{-- Modal match results form --}}
@endsection

@push('script')
    <script type="text/javascript">
        //** Elements

        // Team
        const inputTeamName = $('#team-name');
        const inputTeamCity = $('#team-city');
        const btnSaveTeam = $('#btn-save-team');
        const btnCloseTeamForm = $('#btn-close-team-form');

        // Event List
        btnSaveTeam.on('click', saveTeam)

        // Function Lists
        function resetForm(formType) {
            if (formType === 'team') {
                inputTeamName.val('');
                inputTeamCity.val('');
            } else if(formType === 'match-results') {

            }
        }

        function validateTeamForm() {
            if (inputTeamName.val() === '' || inputTeamName.val().length === 0) {
                showAlert('error', 'Team name must be filled!');
                inputTeamName.focus();
                return false;
            }

            if (inputTeamCity.val() === '' || inputTeamCity.val().length === 0) {
                showAlert('error', 'Team city must be filled!');
                inputTeamCity.focus();
                return false;
            }

            return true;
        }

        function saveTeam() {
            if (validateTeamForm()) {
                $.ajax({
                    method: 'POST',
                    url: `{{ route('ajax.teams.store') }}`,
                    data: {
                        'name': inputTeamName.val(),
                        'city': inputTeamCity.val(),
                        '_token': getToken()
                    },
                    success: (response, textStatus, xhr) => {
                        if (xhr.status === 200) {
                            resetForm('team');
                            showAlert('success', 'A new team was sucessfully added!', 3000, () => {
                                window.location.href = '{{ route('teams.index') }}';
                            });
                        } else {
                            showAlert('error', xhr.responseJSON.message, 3000);
                        }
                    },
                    error: (xhr, textStatus, err) => showAlert('error', xhr.responseJSON.message, 3000),
                    done: () => {
                        resetForm('team');
                        hideModalForm('team-form-modal');
                    }
                });
            }
        }











    </script>
@endpush
