@extends('layouts.app')

@section('content')
    <div class="container">
        <div row>
            <div class="col-md-10 col-md-offset-1">

                <!-- Display Validation Errors -->
                @include('common.status')

                <div class="panel panel-default">
                    <div class="panel-heading">
                        Create New Project
                    </div>
                    <div class="panel-body">

                        @include('projects.partials.create-project')

                    </div>
                    <div class="panel-footer">
                        <a href="{{ route('projects.index') }}" class="btn btn-sm btn-info" type="button">
                            <span class="fa fa-reply" aria-hidden="true"></span> Back to Projects
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
