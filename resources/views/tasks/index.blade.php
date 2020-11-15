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
                    <li><a href="#unassigned" data-toggle="tab"><span class="fa fa-times" aria-hidden="true"></span> <span class="hidden-xs">Unassigned</span></a></li>
                    <li><a href="#assigned" data-toggle="tab"><span class="fa fa-square-o" aria-hidden="true"></span> <span class="hidden-xs">Assigned</span></a></li>
                    <li><a href="#complete" data-toggle="tab"><span class="fa fa-check-square-o" aria-hidden="true"></span> <span class="hidden-xs">Complete</span></a></li>
                </ul>
                <div id="my-tab-content" class="tab-content">

                    @include('tasks/partials/task-tab', array('tab' => 'all', 'tasks' => $tasks, 'title' => 'All Tasks', 'status' => 'active'))
                    @include('tasks/partials/task-tab', array('tab' => 'unassigned', 'tasks' => $tasksUnassigned, 'title' => 'Unassigned Tasks'))
                    @include('tasks/partials/task-tab', array('tab' => 'assigned', 'tasks' => $tasksAssigned, 'title' => 'Assigned Tasks'))
                    @include('tasks/partials/task-tab', array('tab' => 'complete', 'tasks' => $tasksComplete, 'title' => 'Complete Tasks'))
                </div>
            </div>
        </div>
    </div>
@endsection