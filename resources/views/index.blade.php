@extends('layouts.template')

@push('style')
    <style>
        .img-card {
            height: 180px;
            width: auto;
            object-position:center;
            object-fit:cover;
            overflow:hidden;
        }
    </style>
@endpush

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
                    <div class="mb-3">
                        <img class="img-fluid img-card" src="https://e0.365dm.com/18/01/1600x900/skysports-graphic-cover-badges-premier-league_4207507.jpg" alt="">
                    </div>
                    <div class="d-flex flex-column gap-3">
                        <button type="button" data-bs-toggle="modal" data-bs-target="#team-form-modal" class="w-100 btn btn-lg btn-outline-primary">Input a Team</button>
                        <a href="{{ route('teams.index') }}" class="w-100 btn btn-lg btn-primary">View Team Lists</a>

                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card mb-4 rounded-3 shadow-sm">
                <div class="card-header py-3">
                    <h4 class="my-0 fw-normal">Matches</h4>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <img class="img-fluid img-card" src="https://e0.365dm.com/20/10/2048x1152/skysports-premier-league-predictions_5147427.jpg?20201023114548" alt="">
                    </div>
                    <div class="d-flex flex-column gap-3">
                        <button id="btn-input-single-match-result" type="button" class="w-100 btn btn-lg btn-outline-primary">Input Single Match Result</button>
                        <a href="{{ route('match-result.input-multiple-result') }}" class="w-100 btn btn-lg btn-primary">Input Multiple Match Result</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card mb-4 rounded-3 shadow-sm border-primary">
                <div class="card-header py-3 text-bg-primary border-primary">
                    <h4 class="my-0 fw-normal">Team Standings</h4>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <img class="img-fluid img-card" src="https://e0.365dm.com/21/07/1600x900/skysports-premier-league-graphic_5458724.jpg?20210726090016" alt="">
                    </div>
                    <a href="{{ route('teams.standings-table') }}" class="w-100 btn btn-lg btn-primary">View Team Standings</a>
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
                    <button type="button" id="btn-close-team-form" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="btn-save-team" class="btn btn-primary">Save Team</button>
                </div>
            </div>
        </div>
    </div>


    {{-- Modal single match results form --}}
    <div class="modal fade" id="single-match-result-form-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="single-match-result-form-modal-label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="single-match-result-form-modal-label">Input Match Result</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <div class="row">
                            <div class="col">
                                <label for="home-team" class="col-form-label">Home Team:</label>
                                <select class="form-select" id="home-team">
                                    <option disabled value="0" selected>-- Choose home team --</option>
                                </select>
                            </div>
                            <div class="col-4">
                                <label for="home-score" class="col-form-label">Score:</label>
                                <input type="number" value="0" min="0" max="99" minlength="1" maxlength="2" class="form-control" id="home-score">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="row">
                            <div class="col">
                                <label for="away-team" class="col-form-label">Away Team:</label>
                                <select class="form-select" id="away-team">
                                    <option disabled value="0" selected>-- Choose away team --</option>
                                </select>
                            </div>
                            <div class="col-4">
                                <label for="away-score" class="col-form-label">Score:</label>
                                <input type="number" value="0" min="0" max="99" minlength="1" maxlength="2" class="form-control" id="away-score">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex flex-row justify-content-between">
                    <button type="button" id="btn-close-match-result-form" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="btn-save-match-result" class="btn btn-primary">Save Match Result</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script type="module">
        //** Elements

        // Team
        const inputTeamName = $('#team-name');
        const inputTeamCity = $('#team-city');
        const btnSaveTeam = $('#btn-save-team');
        const btnCloseTeamForm = $('#btn-close-team-form');

        // Match result
        const btnInputSingleMatchResult = $('#btn-input-single-match-result');
        const matchResultFormModal = new bootstrap.Modal('#single-match-result-form-modal');
        const homeTeamSelection = $('#home-team');
        const awayTeamSelection = $('#away-team');
        const homeTeamScore = $('#home-score');
        const awayTeamScore = $('#away-score');
        const btnSaveMatchResult = $('#btn-save-match-result');

        // Event List
        btnSaveTeam.on('click', saveTeam)

        btnInputSingleMatchResult.on('click', () => {
            getAllTeams();
            matchResultFormModal.show();
        });

        homeTeamSelection.on('change', function() {
            const selectedHomeTeam = $(this).val();
            if (selectedHomeTeam !== '') {
                getAllTeams(selectedHomeTeam);
            }

            const awayTeamContainer = $('#away-team');
            awayTeamContainer.children('option').not('option:first').remove();
        });

        btnSaveMatchResult.on('click', saveMatchResult)

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
                            btnCloseTeamForm.click();

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
                        btnCloseTeamForm.click();

                        hideModalForm('team-form-modal');
                    }
                });
            }
        }

        function getAllTeams(exclude = null) {
            const data = {};

            if (exclude !== null) {
                data['exclude'] = exclude;
            }

            $.ajax({
                url: '{{ route('ajax.teams.get-all-teams') }}',
                data: data,
                success: (response, textStatus, xhr) => {
                    if (xhr.status === 200) {
                        let teamItem = ``;
                        $.each(response.data.teams, (key, team) => {
                            teamItem += `<option value="${team.id}">${team.name}</option>`;
                        });

                        if (exclude !== null) {
                            const awayTeamContainer = $('#away-team');
                            awayTeamContainer.children('option').not('option:first').remove();
                            awayTeamContainer.append(teamItem);
                        } else {
                            const homeTeamContainer = $('#home-team');
                            homeTeamContainer.children('option').not('option:first').remove();
                            homeTeamContainer.append(teamItem);
                        }
                    }
                }
            })
        }

        function validateMatchResultForm() {
            if (homeTeamSelection.val() === '' || homeTeamSelection.val() === null || homeTeamSelection.val() === 0) {
                showAlert('error', 'Please choose the home team first!');
                homeTeamSelection.focus();
                return false;
            }

            if (awayTeamSelection.val() === '' || awayTeamSelection.val() === null || awayTeamSelection.val() === 0) {
                showAlert('error', 'Please choose the home away first!');
                awayTeamSelection.focus();
                return false;
            }

            return true;
        }

        function saveMatchResult() {
            if (validateMatchResultForm()) {
                $.ajax({
                    method: 'POST',
                    url: '{{ route('ajax.match-result.save-result') }}',
                    data: {
                        'home_team': homeTeamSelection.val(),
                        'away_team': awayTeamSelection.val(),
                        'home_score': homeTeamScore.val(),
                        'away_score': awayTeamScore.val(),
                        '_token': getToken()
                    },
                    success: (response, textStatus, xhr) => {
                        if (xhr.status === 200) {
                            resetForm('team');
                            btnCloseTeamForm.click();

                            showAlert('success', response.message, 3000);
                        } else {
                            showAlert('error', xhr.responseJSON.message, 3000);
                        }
                    },
                    error: (xhr, textStatus, err) => showAlert('error', xhr.responseJSON.message, 3000),
                    done: () => {
                        resetForm('team');
                        btnCloseTeamForm.click();

                        hideModalForm('team-form-modal');
                    }
                })
            }
        }










    </script>
@endpush
