<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use App\Models\Task_User;
use Auth;
use DB;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    protected $rules = [
        'name' 			=> 'required|max:60',
        'description'   => 'max:2500',
        'status'    	=> 'numeric',
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
        $user = Auth::user();

        return view('tasks.index', [
            'tasks'           => $user->tasks()->orderBy('pivot_sort_order')->get(),
            'tasksNotStarted' => $user->tasks()->where('status', '0')->orderBy('pivot_sort_order')->get(),
            'tasksInProgress' => $user->tasks()->where('status', '1')->orderBy('pivot_sort_order')->get(),
            'tasksComplete'   => $user->tasks()->where('status', '2')->orderBy('pivot_sort_order')->get(),
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

        $additionalUsers = User::query()
            ->where('id', '!=', $user->id)
            ->get();

        $projects = Project::query()->get();
        
        $data = array(
            'additionalUsers' => $additionalUsers,
            'projects' => $projects
        );
        return view('tasks.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->rules);
        $user = Auth::user();
        $task_data = $request->all();
        $task_data['creator_id'] = $user->id;

        // Assign a project to the task if one is selected.
        $task_data['project_id'] = $request->input('project', NULL);

        // saves new task to task table
        $task_id = Task::create($task_data)->id;

        $user_ids = $request->input('assignedUsers', []);
        $user_ids[] = $user->id;

        // fetch newly inserted task and use it to insert user relations to task_user pivot table
        Task::query()->findOrFail($task_id)->users()->sync($user_ids);

        return redirect('/tasks')->with('success', 'Task created');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = Task::query()->findOrFail($id);

        $user = Auth::user();

        /**
         * TODO: There's probably a nicer way to do all of this.
         * Look for a different way to query all users and flag the ones that are already associated with a task
         * Without directly querying the pivot table.
         */
        // query pivot table directly so that we can use it for the left join below
        $taskUserResult = DB::table('task_user')->where('task_id', $id);

        // left join users column against the one task_user rows from above
        // should result in:
        //      id, name, taskId: id and name will be from the users table,
        //      taskId will be NULL if the user is not assigned to the task or the task ID if the user is assigned to the task
        $taskUsers = User::query()
            ->leftJoinSub($taskUserResult, 'tu', function ($join) {
                $join->on('users.id', '=', 'tu.user_id');
            })->select('users.id', 'users.name as name', 'tu.id as tskId')
            ->where('users.id', '!=', $task->creator_id)
            ->get();

        $creatorName = User::where("id", $task->creator_id)->value('name');

        $projects = Project::query()->get();

        $data = array(
            'task' => $task,
            'creatorName' => $creatorName,
            'taskUsers' => $taskUsers,
            'user' => $user,
            'projects' => $projects
        );
        return view('tasks.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Task $task, Request $request, $id)
    {
        $this->validate($request, $this->rules);

        // save task based on request from view
        $task = Task::findOrFail($id);
        $task->name = $request->input('name');
        $task->description = $request->input('description');
        $task->status = $request->input('status');

        // Assign a project to the task if one is selected.
        $task['project_id'] = $request->input('project', NULL);
        $task->save();

        // sync users assigned to task based on assignedUsers[] selector from view
        $user_ids = $request->input('assignedUsers', []);
        $user_ids[] = $task->creator_id;
        $task->users()->sync($user_ids);

        return redirect('tasks')->with('success', 'Task Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Task::findOrFail($id)->delete();

        return redirect('/tasks')->with('success', 'Task Deleted');
    }

    public function setOrder(Request $request)
    {
        $user = Auth::user();

        foreach($request->input('item') as $sort_order => $task_id) {
            echo $task_id . " " . $sort_order ."\n\n";
            $user->tasks()->updateExistingPivot($task_id, ['sort_order' => $sort_order]);
        }
    }
}
