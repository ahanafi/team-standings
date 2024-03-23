<?php

namespace App\Http\Controllers;

use App\DataTables\TeamsDataTable;
use App\Models\Team;
use App\Traits\JsonResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TeamController extends Controller
{
    use JsonResponseTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(TeamsDataTable $teamsDataTable)
    {
        return $teamsDataTable->render('teams.index');
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
            'name' => 'required|unique:teams,name',
            'city' => 'required'
        ]);

        if ($validate->fails()) {
            return $this->sendJsonResponse(true, null, $validate->getMessageBag()->first(), 400);
        }

        try {
            $team = new Team();
            $team->name = $request->get('name');
            $team->city = $request->get('city');

            $team->save();

            return $this->sendJsonResponse(data: ['team' => $team]);
        } catch (Exception $ex) {
            Log::error('TeamController (store) error: ' . $ex->getMessage() . ' line: ' . $ex->getLine());
            Log::error('TeamController (store) exception: ' . $ex->getTraceAsString());

            return $this->sendJsonResponse(true, message: 'Server Error', statusCode: 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Team $team)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Team $team)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Team $team)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team)
    {
        //
    }
}
