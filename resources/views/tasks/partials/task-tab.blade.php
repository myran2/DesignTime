<div class="tab-pane {{{ $status ?? '' }}}" id="{{ $tab }}">
    <h1>
        {{ $title }}
    </h1>

    <div class="table-responsive">
        <table class="table table-striped table-hover" id="task-table">
            <thead>
               <!-- <th>ID</th>-->
                <th>Name</th>
                <th>Project</th>
                <!--<th>Description</th>
                <th colspan="3">Status</th>-->
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                    @include('tasks.partials.task-row')
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@section('scripts')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('tbody').sortable({
            update:function(event, ui) {
                $.ajax({
                    type:'POST',
                    url:'{{ url("/tasks/order") }}',
                    data: $(this).sortable('serialize'),
                    success: function(data) {
                    },
                    error: function() {
                        alert('Sort save failed!');
                    }
                });
            }
        });
    </script>
@stop
