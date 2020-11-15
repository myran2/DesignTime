@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-sm-offset-1 col-sm-10">

            <!-- Display Validation Errors -->
            @include('common.status')

            <div id="content">
                <ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
                    <li class="active"><a href="#all" data-toggle="tab"><span class="fa fa-tasks" aria-hidden="true"></span> <span class="hidden-xs">All</span></a></li>
                    <li><a href="#unassigned" data-toggle="tab"><span class="fa fa-times" aria-hidden="true"></span> <span class="hidden-xs">Unassigned</span></a></li>
                    <li><a href="#assigned" data-toggle="tab"><span class="fa fa-square-o" aria-hidden="true"></span> <span class="hidden-xs">Assigned</span></a></li>
                    <li><a href="#complete" data-toggle="tab"><span class="fa fa-check-square-o" aria-hidden="true"></span> <span class="hidden-xs">Complete</span></a></li>
                </ul>
                <div id="my-tab-content" class="tab-content">
                    @include('projects/partials/project-tab', array('tab' => 'all', 'projects' => $projects, 'title' => 'All Projects', 'status' => 'active'))
                    @include('projects/partials/project-tab', array('tab' => 'unassigned', 'projects' => $projectsUnassigned, 'title' => 'Unassigned'))
                    @include('projects/partials/project-tab', array('tab' => 'assigned', 'projects' => $projectsAssigned, 'title' => 'Assigned'))
                    @include('projects/partials/project-tab', array('tab' => 'complete', 'projects' => $projectsComplete, 'title' => 'Complete'))
                </div>
            </div>
        </div>
    </div>
@endsection