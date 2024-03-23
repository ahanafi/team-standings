@extends('layouts.template')

@push('style')
<style>
    .match-result-item {
        padding-bottom: 1.25rem !important;
    }
</style>
@endpush

@section('content')
    <div class="pricing-header p-3 pb-md-4 mx-auto text-center">
        <h1 class="display-4 fw-normal text-body-emphasis">Input Match Result</h1>
        <p class="fs-5 text-body-secondary">
            Form input multiple match results.
        </p>
    </div>

    <div class="row row-cols-1 mb-3 text-center">
        <div class="col">
            <div class="card mb-4 rounded-3 shadow-sm">
                <div class="card-header">
                    <h4 class="my-0 fw-normal">Input Match Result</h4>
                </div>
                <div class="card-body" id="container-form">
                    <div data-index="1" class="match-result-item row border-bottom py-3">
                        <div class="col-2">
                            <div class="d-flex flex-row justify-content-center align-items-center align-content-center border-end">
                                <h3 class="mt-3 match-order">1</h3>
                            </div>
                        </div>
                        <div class="col">
                            <div class="row">
                                <!-- Home team -->
                                <div class="col-3 text-start">
                                    <label for="home-team" class="col-form-label">Home Team:</label>
                                    <select class="form-select home-teams" id="home-team" data-index="1">
                                        <option disabled value="0" selected>-- Choose home team --</option>
                                    </select>
                                </div>
                                <div class="col-2 text-start">
                                    <label for="home-score" class="col-form-label">Score:</label>
                                    <input type="number" data-index="1" value="0" min="0" max="99" minlength="1" maxlength="2" class="form-control team-scores home-scores" id="home-score">
                                </div>

                                <div class="col-2">
                                    <div class="d-flex flex-row justify-content-center align-items-center mt-4">
                                        <h4 class="versus-text bg-light-subtle p-2 rounded text-light">VS</h4>
                                    </div>
                                </div>

                                <!-- Away team -->
                                <div class="col-3 text-start">
                                    <label for="away-team" class="col-form-label">Away Team:</label>
                                    <select class="form-select away-teams" id="away-team" data-index="1">
                                        <option disabled value="0" selected>-- Choose away team --</option>
                                    </select>
                                </div>
                                <div class="col-2 text-start">
                                    <label for="away-score" class="col-form-label">Score:</label>
                                    <input type="number" data-index="1" value="0" min="0" max="99" minlength="1" maxlength="2" class="form-control team-scores away-scores" id="away-score">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-top-0 pb-3">
                    <div class="d-flex flex-row justify-content-between">
                        <div class="d-flex flex-row justify-content-between gap-3">
                            <button type="button" id="btn-add-match-row" class="btn btn-secondary">+ Add Row</button>
                            <button type="button" id="btn-remove-match-row" class="btn btn-outline-danger d-none">Remove Last Row</button>
                        </div>
                        <button type="button" id="btn-save-result" class="btn btn-primary">Save All Results</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script type="module">
        //** Elements
        let counter = 1;

        // Match result
        const homeTeamSelection = $('.home-teams');
        const awayTeamSelection = $('.away-teams');
        const homeTeamScore = $('#home-score');
        const awayTeamScore = $('#away-score');
        const btnSaveMatchResult = $('#btn-save-result');
        const btnAddMatchRow = $('#btn-add-match-row');
        const btnRemoveMatchRow = $('#btn-remove-match-row');
        const containerForm = $('#container-form');
        const matchResultItems = $('.match-result-item');


        // Event List
        $(document).ready(function() {
            getAllTeams();
        });

        btnAddMatchRow.on('click', addRowMatchResultForm);
        btnRemoveMatchRow.on('click', removeLastRowMatchResultForm);

        homeTeamSelection.on('change', function() {
            const selectedHomeTeam = $(this).val();
            const dataIndex = $(this).attr('data-index');

            if (selectedHomeTeam !== '') {
                getAllTeams(selectedHomeTeam, dataIndex);
            }

            const awayTeamContainer = $(`.away-teams[data-index="${dataIndex}"]`);
            awayTeamContainer.children('option').not('option:first').remove();
        });

        btnSaveMatchResult.on('click', saveMatchResult)

        // Function Lists
        function addRowMatchResultForm() {
            counter++;
            const newIndex = counter;
            const matchResultRow = $('#container-form .match-result-item:first').clone();

            // modify index
            matchResultRow.attr('data-index', newIndex);
            matchResultRow.find('h3.match-order').text(newIndex);
            matchResultRow.find('.form-select').attr('data-index', newIndex);
            matchResultRow.find('.team-scores').attr('data-index', newIndex);

            // append
            containerForm.append(matchResultRow);
            showRemoveButton();
        }

        function removeLastRowMatchResultForm() {
            if (counter > 1) {
                $('#container-form .match-result-item:last').remove();
                counter--;
            }

            showRemoveButton();
        }

        function showRemoveButton() {
            if (counter > 1) {
                btnRemoveMatchRow.removeClass('d-none');
            } else {
                btnRemoveMatchRow.addClass('d-none');
            }
        }

        function getAllTeams(exclude = null, index = null) {
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
                            const awayTeamContainer = index === null
                                ? $('.away-teams[data-index="1"]')
                                : $(`.away-teams[data-index="${index}"]`);

                            awayTeamContainer.children('option').not('option:first').remove();
                            awayTeamContainer.append(teamItem);
                        } else {
                            const homeTeamContainer = index === null
                                ? $('.home-teams[data-index="1"]')
                                : $(`.home-teams[data-index="${index}"]`);

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

        function getMatchData() {
            const data = [];
            $('.match-result-item').each((index, matchItemEl) => {
                const dataIndex = index + 1;

                const homeTeam = $(matchItemEl).find(`.home-teams[data-index="${dataIndex}"]`).val();
                const homeScore = $(matchItemEl).find(`.home-scores[data-index="${dataIndex}"]`).val();

                const awayTeam = $(matchItemEl).find(`.away-teams[data-index="${dataIndex}"]`).val();
                const awayScore = $(matchItemEl).find(`.away-scores[data-index="${dataIndex}"]`).val();

                data.push({
                    'home_team': homeTeam,
                    'home_score': homeScore,
                    'away_team': awayTeam,
                    'away_score': awayScore
                });
            });

            return data;
        }

        function saveMatchResult() {
            const data = getMatchData();
            if (validateMatchResultForm()) {
                $.ajax({
                    method: 'POST',
                    url: '{{ route('ajax.match-result.save-multiple-result') }}',
                    data: {
                        'results': data,
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
