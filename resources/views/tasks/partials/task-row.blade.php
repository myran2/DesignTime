<tr>

    <!-- Task Id -->
    <!--<td class="table-text">
        {{ $task->id }}
    </td>-->

    <!-- Task Name -->
    <td class="table-text">
        {{ $task->name }}
    </td>

    <!-- Parent Project Name -->
    <td class="table-text">
        {{ $task->project()->value('name') }}
    </td>

    <!-- Task Description -->
    <td>
        {{ $task->description }}
    </td>

    <!-- Task Status -->
    <td>
        @if ($task->status === 2)
            <span class="label label-success">
                Complete
            </span>
        @elseif ($task->status === 1)
        <span class="label label-info">
                In Progress
            </span>
        @else
            <span class="label label-default">
                Not Started
            </span>
        @endif
    </td>

    <!-- Task Edit Icon -->
    <td>
        <a href="{{ route('tasks.edit', $task->id) }}" class="pull-right">
            <span class="fa fa-pencil fa-fw" aria-hidden="true"></span>
            <span class="sr-only">Edit Task</span>
        </a>
    </td>
</tr>