<div class="tab-pane {{{ $status ?? '' }}}" id="{{ $tab }}">
    <h1>
        {{ $title }} - {{ $user->name }}
    </h1>

    <div class="table-responsive">
        <table class="table table-striped table-hover display" id="task-table">
            <thead>
                <th>Name</th>
                <th>Project</th>
                <th>Due Date</th>
                <th></th>
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
        // init ajax token to prevent errors
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // use sortable library for drag and drop sorting of tasks
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

        // use datatable library for easy search/sorting by columns
        $(document).ready(function() {
            $('table').DataTable({
                paging: false,
                info: false,
                order: []
            });

            $('#userPicker').change(function() {
                $('#changeUser').submit();
            });
        });
    </script>
@stop
