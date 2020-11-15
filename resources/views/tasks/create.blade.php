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

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.26.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
    <script src="https://cdn.tiny.cloud/1/{{config('app.tinymce_api_key')}}/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

    <script>
        $(function () {
            $('.datetimepicker').datepicker({
                format: 'yyyy-mm-dd'
            });

            tinymce.init({
                selector:'#task-description',
                plugins: 'image code link autolink',
                width: 600,
                height: 400,
                tinycomments_author: '{{$user->name}}',
                setup: function(editor){
                    editor.on('init', function() {
                        $(editor.getBody()).on('click', 'a[href]', function(e) {
                            window.open($(e.currentTarget).attr('href'));
                        });
                    });
                }
            });
        });
    </script>
@endsection
