@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">

                <!-- Display Validation Errors -->
                @include('common.status')

                <div class="panel panel-default">
                    <div class="panel-heading">
                        Editing Project <strong>{{$project->name}}</strong>
                    </div>
                    <div class="panel-body">

                        {!! Form::model($project, array('action' => array('ProjectsController@update', $project->id), 'method' => 'PUT')) !!}

                            <!-- Project Name -->    
                            <div class="form-group row">
                                {!! Form::label('name', 'Project Name', array('class' => 'col-sm-3 col-sm-offset-1 control-label text-right')) !!}
                                <div class="col-sm-6">
                                    {!! Form::text('name', null, array('class' => 'form-control')) !!}
                                </div>
                            </div>

                            <!-- Project Description -->
                            <div class="form-group row">
                                {!! Form::label('description', 'Project Description', array('class' => 'col-sm-3 col-sm-offset-1 control-label text-right')) !!}
                                <div class="col-sm-6">
                                    {!! Form::textarea('description', null, array('class' => 'form-control')) !!}
                                </div>
                            </div>

                            <!-- Current Associated Tasks -->
                            <div class="form-group row">
                                {!! Form::label('description', 'Current Task Links', array('class' => 'col-sm-3 col-sm-offset-1 control-label text-right')) !!}
                                <div class="col-sm-6">
                                    <ul class="list-group">
                                        @foreach ($tasks as $t)
                                            @if (!is_null($t->project_id))
                                                <li class="list-group-item">
                                                    <a href="/tasks/{{$t->id}}/edit">{{$t->name}}</a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <!-- Edit Associated Tasks-->
                            <div class="form-group row">
                                {!! Form::label('tasks', 'Edit Associated Tasks', array('class' => 'col-sm-3 col-sm-offset-1 control-label text-right')) !!}
                                <div class="col-sm-6">
                                    <select name="tasks[]" id="tasks" class="selectpicker" multiple data-live-search="true">
                                        @foreach ($tasks as $t)
                                            @if (is_null($t->project_id))
                                                <option value="{{$t->id}}">{{$t->name}}</option>
                                            @else
                                                <option value="{{$t->id}}" selected="selected">{{$t->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Save Project Button -->
                            <div class="form-group row">
                                <div class="col-sm-offset-4 col-sm-6">
                                     {{Form::button('<span class="fa fa-save fa-fw" aria-hidden="true"></span> <span class="hidden-xxs">Save</span> <span class="hidden-xs">Changes</span>', array('type' => 'submit', 'class' => 'btn btn-success btn-block'))}}
                                </div>
                            </div>

                        {!! Form::close() !!}

                    </div>
                    <div class="panel-footer">
                        <a href="{{ route('projects.index') }}" class="btn btn-sm btn-info" type="button">
                            <span class="fa fa-reply" aria-hidden="true"></span> Back to Projects
                        </a>

                        @if ($user->role == 1)
                            <div style="height: 35px"></div>

                            {!! Form::open(array('class' => 'form-inline', 'method' => 'DELETE', 'route' => array('projects.destroy', $project->id))) !!}
                                {{ method_field('DELETE') }}
                                {{Form::button('<span class="fa fa-trash fa-fw" aria-hidden="true"></span> <span class="hidden-xxs">Delete</span> <span class="hidden-sm hidden-xs">Project</span>', array('type' => 'submit', 'class' => 'btn btn-danger', 'onclick' => 'return confirm("Delete this project?")'))}}
                            {!! Form::close() !!}
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection