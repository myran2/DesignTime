<div class="tab-pane {{{ $status ?? '' }}}" id="{{ $tab }}">
    <h1>
        {{ $title }}
    </h1>

    <div class="table-responsive">
        <table class="table table-striped table-hover display">
            <thead>
                <th>Name</th>
                <th>Description</th>
                <th>Status</th>
                <th></th>
            </thead>
            <tbody>
                @foreach ($projects as $project)
                    @include('projects.partials.project-row')
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@section('scripts')
    <script>
        $(document).ready(function() {
            $('table').DataTable({
                paging: false,
                info: false
            });
        });
    </script>
@stop