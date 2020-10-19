<div class="tab-pane {{{ $status ?? '' }}}" id="{{ $tab }}">
    <h1>
        {{ $title }}
    </h1>

    <div class="table-responsive">
        <table class="table table-striped task-table table-condensed">
            <thead>
                <th>Name</th>
                <th>Description</th>
                <th colspan="3">Status</th>
            </thead>
            <tbody>
                @foreach ($projects as $project)
                    @include('projects.partials.project-row')
                @endforeach
            </tbody>
        </table>
    </div>
</div>
