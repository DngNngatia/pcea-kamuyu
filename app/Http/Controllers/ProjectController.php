<?php

namespace App\Http\Controllers;

use App\Data\Models\Contribution;
use App\Data\Models\Project;
use App\Http\Controllers\Transformers\ProjectTransformer;
use Carbon\Carbon;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    use Helpers;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $projects = Project::where('church_id', $request->user()->church_id)->paginate(50);
        return $this->response->paginator($projects, new ProjectTransformer());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'project_name' => ['required','unique:projects'],
            'project_desc' => ['required'],
            'project_status' => ['required'],
            'start' => ['required', 'date'],
            'end' => ['required', 'date'],
        ]);
        $contribution = null;
        if ($request->exists('amount')) {
            $this->validate($request, [
                'deadline' => ['required', 'date'],
                'payment_method' => ['required'],
            ]);
            $contribution = Contribution::create([
                'title' => $request->project_name,
                'message' => $request->message,
                'amount' => $request->amount,
                'deadline' => Carbon::parse($request->deadline)->toDate(),
                'payment_method' => $request->payment_method,
                'church_id' => $request->user()->church_id

            ]);
        }
        Project::create([
            'project_name' => $request->project_name,
            'project_desc' => $request->project_desc,
            'project_status' => $request->project_status,
            'uploaded_by' => $request->user()->id,
            'church_id' => $request->user()->church_id,
            'start' => Carbon::parse($request->start)->toDate(),
            'end' => Carbon::parse($request->end)->toDate(),
            'contribution_id' => $contribution ? $contribution->id : null
        ]);
        return $this->index($request);

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request['start'] = Carbon::parse($request->input('start'))->toDate();
        $request['end'] = Carbon::parse($request->input('end'))->toDate();
        $project = Project::findOrFail($id);
        $project->update($request->only('project_name', 'project_desc', 'project_status', 'start', 'end'));
        if ($request->exists('amount')) {
            Contribution::updateOrCreate([
                'project_id' => $project->id,
                'title' => $project->project_name,
                'message' => $request->message,
                'amount' => $request->amount,
                'deadline' => Carbon::parse($request->deadline)->toDate(),
                'payment_method' => $request->payment_method,
                'church_id' => $request->user()->church_id

            ]);
        }
        return $this->index($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();
        return $this->index(null);
    }
}
