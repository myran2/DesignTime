<tr>
    <!-- Project Name -->
    <td class="table-text">
        {{ $project->name }}
    </td>

    <!-- Project Description -->
    <td>
        {{ $project->description }}
    </td>

    <!-- Project Status -->
    <td>
        @if ($project->avg_status == 2.0)
            <span class="label label-success">
                Complete
            </span>
        @elseif ($project->avg_status > 0 && $project->avg_status < 2)
        <span class="label label-info">
                In Progress
        </span>
        @elseif ($project->avg_status == 0.0)
            <span class="label label-default">
                Not Started
            </span>
        @endif
    </td>

    <!-- Project Edit Icon -->
    <td>
        <a href="{{ route('projects.edit', $project->id) }}" class="pull-right">
            <span class="fa fa-pencil fa-fw" aria-hidden="true"></span>
            <span class="sr-only">Edit Project</span>
        </a>
    </td>
</tr>