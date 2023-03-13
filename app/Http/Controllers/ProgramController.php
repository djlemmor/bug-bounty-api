<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProgramRequest;
use App\Http\Resources\ProgramResource;
use App\Models\Program;
use Symfony\Component\HttpFoundation\Response;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ProgramResource::collection(Program::paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProgramRequest $request)
    {
        $program = new Program();
        $program->user_id = $request->user()->id;
        $program->name = $request->name;
        $program->pentesting_start_date = $request->pentesting_start_date;
        $program->pentesting_end_date = $request->pentesting_end_date;
        if ($program->save()) {
            return response($program, Response::HTTP_CREATED);
        }

        return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new ProgramResource(Program::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProgramRequest $request, $id)
    {
        $program = Program::find($id);
        $program->update($request->all());
        return response($program, Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Program::destroy($id);
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
