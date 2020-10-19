@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-sm-offset-1 col-sm-10">

            <!-- Display Validation Errors -->
            @include('common.status')

            <div id="content">
                <ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
                    <li class="active"><a href="#all" data-toggle="tab"><span class="fa fa-tasks" aria-hidden="true"></span> <span class="hidden-xs">All</span></a></li>
                    <li><a href="#not-started" data-toggle="tab"><span class="fa fa-times" aria-hidden="true"></span> <span class="hidden-xs">Not Started</span></a></li>
                    <li><a href="#in-progress" data-toggle="tab"><span class="fa fa-square-o" aria-hidden="true"></span> <span class="hidden-xs">In Progress</span></a></li>
                    <li><a href="#complete" data-toggle="tab"><span class="fa fa-check-square-o" aria-hidden="true"></span> <span class="hidden-xs">Complete</span></a></li>
                </ul>
                <div id="my-tab-content" class="tab-content">

                    @include('tasks/partials/task-tab', array('tab' => 'all', 'tasks' => $tasks, 'title' => 'All Tasks', 'status' => 'active'))
                    @include('tasks/partials/task-tab', array('tab' => 'not-started', 'tasks' => $tasksNotStarted, 'title' => 'Not Started Tasks'))
                    @include('tasks/partials/task-tab', array('tab' => 'in-progress', 'tasks' => $tasksInProgress, 'title' => 'In Progress Tasks'))
                    @include('tasks/partials/task-tab', array('tab' => 'complete', 'tasks' => $tasksComplete, 'title' => 'Complete Tasks'))
                </div>
            </div>
        </div>
    </div>
@endsection