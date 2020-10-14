<?php

namespace App\Http\Controllers;

use App\Task;
use App\User;
use App\Task_User;
use Auth;
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

            'tasksInComplete' => Task::orderBy('created_at', 'asc')->wherein('id', function ($query) use ($user) {
                $query->select('task_id')->from('task__users')->where('user_id', $user->id);
            })->where('status', '0')->get(),

            'tasksComplete'   => Task::orderBy('created_at', 'asc')->wherein('id', function ($query) use ($user) {
                $query->select('task_id')->from('task__users')->where('user_id', $user->id);
            })->where('status', '1')->get(),
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
        return view('tasks.create');
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

        $task_id = Task::create($task)->id;

        Task_User::create(['task_id' => $task_id,
                           'user_id' => $user->id]);

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

        // contains all users that are not already assigned to the task
        $usersNotAssignedToTask = User::query()->wherenotin('id', function ($query) use ($id){
            $query->select('user_id')->from('task__users')->where('task_id', $id);
        })->get();

        $data = array(
            'task' => $task,
            'otherUsers' => $usersNotAssignedToTask
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
        //TaskUsers::delete from task__users where task_id = $task->id
        //TaskUsers::insert into task__users (user_id, task_id) VALUES ()

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
