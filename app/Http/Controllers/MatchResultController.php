<?php

namespace App\Http\Controllers;

use App\DataTables\MatchResultsDataTable;
use App\Models\MatchResult;
use App\Models\Team;
use App\Traits\JsonResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class MatchResultController extends Controller
{
    use JsonResponseTrait;

    public function index(MatchResultsDataTable $dataTable)
    {
        return $dataTable->render('match-result.index');
    }

    /**
     * Display a listing of the resource.
     */
    public function showForm()
    {
        return view('match-result.form-multiple');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!$request->ajax()) {
            return $this->sendResourceNotFound();
        }

        $validate = Validator::make($request->all(), [
            'home_team' => 'required|exists:teams,id',
            'away_team' => 'required|exists:teams,id|not_in:' . $request->get('home_team'),
            'home_score' => 'required|numeric',
            'away_score' => 'required|numeric',
        ]);

        if ($validate->fails()) {
            return $this->sendJsonResponse(true, null, $validate->getMessageBag()->first(), 400);
        }

        try {
            $homeTeam = $request->get('home_team');
            $awayTeam = $request->get('away_team');

            $matchResultCount = MatchResult::where('home_team', $homeTeam)
                ->where('away_team', $awayTeam)
                ->count();

            if ($matchResultCount !== 0) {
                $homeTeam = Team::where('id', $homeTeam)->first();
                $awayTeam = Team::where('id', $awayTeam)->first();

                $macthTeam = '[' . $homeTeam->name . ' vs ' . $awayTeam->name . ']';

                return $this->sendJsonResponse(
                    isError: true,
                    data: $request,
                    message: 'The match result ' . $macthTeam . ' already exists in the database!',
                    statusCode: 403
                );
            }

            $matchResult = new MatchResult();
            $matchResult->home_team = $homeTeam;
            $matchResult->away_team = $awayTeam;
            $matchResult->home_score = $request->get('home_score');
            $matchResult->away_score = $request->get('away_score');

            $theWinner = $request->get('home_score') > $request->get('away_score')
                ? 'HOME'
                : ($request->get('home_score') < $request->get('away_score') ? 'AWAY' : null);

            $matchResult->the_winner = $theWinner;
            $matchResult->save();

            return $this->sendJsonResponse(data: ['result' => $matchResult], message: 'Match result was successfully saved!');
        } catch (Exception $ex) {
            Log::error('MatchResultController (store) error: ' . $ex->getMessage() . ' line: ' . $ex->getLine());
            Log::error('MatchResultController (store) exception: ' . $ex->getTraceAsString());

            return $this->sendJsonResponse(true, message: 'Server Error', statusCode: 500);
        }
    }

    public function storeMultiple(Request $request)
    {
        if (!$request->ajax()) {
            return $this->sendResourceNotFound();
        }

        $validate = Validator::make($request->all(), [
            'results' => 'required|array',
            'results.*.home_team' => 'required|exists:teams,id|distinct',
            'results.*.away_team' => 'required|exists:teams,id|distinct',
        ], [
            // Home team
            'results.*.home_team.required' => 'Home team is required at row number :position!',
            'results.*.home_team.distinct' => 'Home team cannot be the be the same as home team in other rows.!',

            // Away team
            'results.*.away_team.required' => 'Away team is required at row number :position!',
            'results.*.away_team.distinct' => 'Away team cannot be the same as away team in other rows!',
        ]);

        if ($validate->fails()) {
            return $this->sendJsonResponse(true, null, $validate->getMessageBag()->first(), 400);
        }

        try {
            $results = $request->get('results');
            $matchResultData = [];

            foreach ($results as $result) {
                $otherMatchCount = MatchResult::where('home_team', $result['home_team'])
                    ->where('away_team', $result['away_team'])
                    ->count();

                if ($otherMatchCount !== 0) {
                    $homeTeam = Team::where('id', $result['home_team'])->first();
                    $awayTeam = Team::where('id', $result['away_team'])->first();

                    $macthTeam = '[' . $homeTeam->name . ' vs ' . $awayTeam->name . ']';

                    return $this->sendJsonResponse(
                        isError: true,
                        data: $request,
                        message: 'The match result ' . $macthTeam . ' already exists in the database!',
                        statusCode: 403
                    );
                    break;
                }

                $theWinner = $result['home_score'] > $result['away_score']
                    ? 'HOME'
                    : ($result['home_score'] < $result['away_score'] ? 'AWAY' : null);
                $result['the_winner'] = $theWinner;
                $matchResultData[] = $result;

                MatchResult::create($result);
            }

            return $this->sendJsonResponse(data: ['result' => $matchResultData], message: 'Match result was successfully saved!');
        } catch (Exception $ex) {
            Log::error('MatchResultController (store) error: ' . $ex->getMessage() . ' line: ' . $ex->getLine());
            Log::error('MatchResultController (store) exception: ' . $ex->getTraceAsString());

            return $this->sendJsonResponse(true, message: 'Server Error', statusCode: 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(MatchResult $matchResult)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MatchResult $matchResult)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MatchResult $matchResult)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MatchResult $matchResult)
    {
        //
    }
}
