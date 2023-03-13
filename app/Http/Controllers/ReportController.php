<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReportRequest;
use App\Http\Resources\ReportResource;
use App\Models\Report;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ReportResource::collection(Report::paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReportRequest $request)
    {
        $report = new Report();
        $report->user_id = $request->user()->id;
        $report->program_id = $request->program_id;
        $report->title = $request->title;
        $report->severity = $request->severity;
        $report->status = $request->status;
        if ($report->save()) {
            return response($report, Response::HTTP_CREATED);
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
        return new ReportResource(Report::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ReportRequest $request, $id)
    {
        $report = Report::find($id);
        $report->update($request->all());
        return response($report, Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Report::destroy($id);
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
