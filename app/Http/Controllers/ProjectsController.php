<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use Auth;
use DB;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    protected $rules = [
        'name' 			=> 'required|max:60',
        'description'   => 'max:255',
    ];
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $maxStatusByProject = Task::select('project_id')->selectRaw('max(status) as mstatus')->groupBy('project_id');

        return view('projects.index', [
            'projects'           => Project::leftJoinSub($maxStatusByProject, 'maxStatusSubQ', function ($join) {
                                        $join->on('projects.id', '=', 'maxStatusSubQ.project_id');
                                    })->select('projects.name', 'projects.description', 'projects.id', 'mstatus')
                                    ->get(),

            'projectsNotStarted' => Project::leftJoinSub($maxStatusByProject, 'maxStatusSubQ', function ($join) {
                                        $join->on('projects.id', '=', 'maxStatusSubQ.project_id');
                                    })->select('projects.name', 'projects.description', 'projects.id', 'mstatus')
                                    ->where('mstatus', '0')->get(),

            'projectsInProgress' => Project::leftJoinSub($maxStatusByProject, 'maxStatusSubQ', function ($join) {
                                        $join->on('projects.id', '=', 'maxStatusSubQ.project_id');
                                    })->select('projects.name', 'projects.description', 'projects.id', 'mstatus')
                                    ->where('mstatus', '1')->get(),

            'projectsComplete'   => Project::leftJoinSub($maxStatusByProject, 'maxStatusSubQ', function ($join) {
                                        $join->on('projects.id', '=', 'maxStatusSubQ.project_id');
                                    })->select('projects.name', 'projects.description', 'projects.id', 'mstatus')
                                    ->where('mstatus', '2')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();

        $orphanTasks = Task::whereNull('project_id')->get();

        $data = array(
            'orphanTasks' => $orphanTasks,
        );
        return view('projects.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->rules);

        $user = Auth::user();
        $project_data = $request->all();
        $project_data['creator_id'] = $user->id;

        // saves new task to task table
        $project_id = Project::create($project_data)->id;

        $task_ids = $request->input('tasks', []);
        Task::whereIn('id', $task_ids)->update(['project_id' => $project_id]);

        return redirect('projects')->with('success', 'Project Created');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = Project::query()->findOrFail($id);

        $user = Auth::user();

        $tasks = Task::query()->where('project_id', $id)->orWhereNull('project_id')->get();
        
        $data = array(
            'project' => $project,
            //'user' => $user,
            'tasks' => $tasks,
        );
        return view('projects.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, $this->rules);

        $project = Project::findOrFail($id);

        $task_ids = $request->input('tasks', []);
        Task::whereIn('id', $task_ids)->update(['project_id' => $id]);

        return redirect('projects')->with('success', 'Project Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Project::findOrFail($id)->delete();

        return redirect('/projects')->with('success', 'Project Deleted');
    }
}
