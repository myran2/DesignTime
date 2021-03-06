@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-sm-offset-1 col-sm-10">

            <!-- Display Validation Errors -->
            @include('common.status')

            <div id="content">
                @if ($authedUser->role == 1)
                    {{ Form::open(array('route' => array('tasks.index'), 'id' => 'changeUser', 'method' => 'get')) }}
                        {{ Form::select('selectedUser', $allUsers, $user->id, ['class' => 'selectpicker pull-right', 'id' => 'userPicker']) }}
                    {{ Form::close() }}
                @endif

                <ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
                    <li class="active"><a href="#all" data-toggle="tab"><span class="fa fa-tasks" aria-hidden="true"></span> <span class="hidden-xs">All</span></a></li>
                    <li><a href="#hold" data-toggle="tab"><span class="fa fa-times" aria-hidden="true"></span> <span class="hidden-xs">Hold</span></a></li>
                    <li><a href="#in-progress" data-toggle="tab"><span class="fa fa-square-o" aria-hidden="true"></span> <span class="hidden-xs">In Progress</span></a></li>
                    <li><a href="#complete" data-toggle="tab"><span class="fa fa-check-square-o" aria-hidden="true"></span> <span class="hidden-xs">Complete</span></a></li>
                </ul>
                <div id="my-tab-content" class="tab-content">

                    @include('tasks/partials/task-tab', array('tab' => 'all', 'tasks' => $tasks, 'title' => 'All Tasks', 'status' => 'active'))
                    @include('tasks/partials/task-tab', array('tab' => 'hold', 'tasks' => $tasksHold, 'title' => 'Tasks On Hold'))
                    @include('tasks/partials/task-tab', array('tab' => 'in-progress', 'tasks' => $tasksInProgress, 'title' => 'In Progress Tasks'))
                    @include('tasks/partials/task-tab', array('tab' => 'complete', 'tasks' => $tasksComplete, 'title' => 'Complete Tasks'))
                </div>
            </div>
        </div>
    </div>
@endsection