<?php

namespace App\Http\Controllers;

use App\Task;
use App\User;
use App\Task_User;
use Auth;
use DB;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    protected $rules = [
        'name' 			=> 'required|max:60',
        'description'   => 'max:155',
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
            'tasks'           => Task::orderBy('status', 'asc')->orderBy('created_at', 'asc')->wherein('id', function ($query) use ($user) {
                $query->select('task_id')->from('task__users')->where('user_id', $user->id);
            })->get(),

            'tasksNotStarted' => Task::orderBy('created_at', 'asc')->wherein('id', function ($query) use ($user) {
                $query->select('task_id')->from('task__users')->where('user_id', $user->id);
            })->where('status', '0')->get(),

            'tasksInProgress' => Task::orderBy('created_at', 'asc')->wherein('id', function ($query) use ($user) {
                $query->select('task_id')->from('task__users')->where('user_id', $user->id);
            })->where('status', '1')->get(),

            'tasksComplete'   => Task::orderBy('created_at', 'asc')->wherein('id', function ($query) use ($user) {
                $query->select('task_id')->from('task__users')->where('user_id', $user->id);
            })->where('status', '2')->get(),
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_all()
    {
        $user = Auth::user();

        return view('tasks.filtered', [
            'tasks'           => Task::orderBy('status', 'asc')->orderBy('created_at', 'asc')->wherein('id', function ($query) use ($user) {
                $query->select('task_id')->from('task__users')->where('user_id', $user->id);
            })->get(),
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_incomplete()
    {
        $user = Auth::user();

        return view('tasks.filtered', [
            'tasks' => Task::orderBy('created_at', 'asc')->wherein('id', function ($query) use ($user) {
                $query->select('task_id')->from('task__users')->where('user_id', $user->id);
            })->where('status', '0')->get(),
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_complete()
    {
        $user = Auth::user();

        return view('tasks.filtered', [
            'tasks' => Task::orderBy('created_at', 'asc')->wherein('id', function ($query) use ($user) {
                $query->select('task_id')->from('task__users')->where('user_id', $user->id);
            })->where('status', '1')->get(),
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
        
        $data = array(
            'additionalUsers' => $additionalUsers,
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
        $task = $request->all();
        $task['creator_id'] = $user->id;

        $task_id = Task::create($task)->id;

        // init task__user rows with the creator's row
        $rows = array([
            'task_id' => $task_id,
            'user_id' => $user->id
        ]);
        
        // add any additional assigned users
        foreach($request->input('assignedUsers', []) as $u) {
            $rows[] = array('user_id' => $u, 'task_id' => $task_id);
        }

        // commit to db
        Task_User::insert($rows);

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

        // grab the one task with supplied $id for the left join
        $taskRow = Task_User::query()->select('*')->where('task_id', $id);

        // left join users column against the one task row from above
        // should result in:
        //      id, name, taskId: id and name will be from the users table,
        //      taskId will be NULL if the user is not assigned to the task or the task ID if the user is assigned to the task
        $taskUsers = User::query()
            ->leftJoinSub($taskRow, 'tu', function ($join) {
                $join->on('users.id', '=', 'tu.user_id');
            })->select('users.id', 'users.name as name', 'tu.id as tskId')
            ->where('users.id', '!=', $task->creator_id)
            ->get();

        $creatorName = User::where("id", $task->creator_id)->value('name');

        $data = array(
            'task' => $task,
            'creatorName' => $creatorName,
            'taskUsers' => $taskUsers,
            'user' => $user
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

        $task = Task::findOrFail($id);
        $task->name = $request->input('name');
        $task->description = $request->input('description');
        $task->status = $request->input('status');

        $task->save();

        Task_User::where([
            ['task_id', '=', $task->id],
            ['user_id', '!=', $task->creator_id]
        ])->delete();

        $rows = array();
        foreach($request->input('assignedUsers', []) as $u) {
            $rows[] = array('user_id' => $u, 'task_id' => $task->id);
        }

        Task_User::insert($rows);

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
}
