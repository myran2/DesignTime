@extends('layouts.app')

@section('content')
    <div class="container">
        <div row>
            <div class="col-md-10 col-md-offset-1">

                <!-- Display Validation Errors -->
                @include('common.status')

                <div class="panel panel-default">
                    <div class="panel-heading">
                        Create New Task
                    </div>
                    <div class="panel-body">

                        @include('tasks.partials.create-task')

                    </div>
                    <div class="panel-footer">
                        <a href="{{ route('tasks.index') }}" class="btn btn-sm btn-info" type="button">
                            <span class="fa fa-reply" aria-hidden="true"></span> Back to Tasks
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection