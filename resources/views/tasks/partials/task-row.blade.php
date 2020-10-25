<tr id="item_{{ $task->id }}">
    <!-- Task Name -->
    <td class="table-text">
        <a href="{{ route('tasks.edit', $task->id) }}">
            {{ $task->name }}
        </a>
    </td>

    <!-- Parent Project Name -->
    <td class="table-text">
        <a href="{{ route('tasks.edit', $task->id) }}">
            {{ $task->project()->value('name') }}
        </a>
    </td>

    <!-- Task Description
    <td>
        {{ $task->description }}
    </td>-->

    <!-- Task Status 
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
    </td>-->

    <!-- Task Edit Icon -->
    <td>
        <a href="{{ route('tasks.edit', $task->id) }}" class="">
            <span class="fa fa-pencil fa-fw" aria-hidden="true"></span>
            <span class="sr-only">Edit Task</span>
        </a>
    </td>
</tr>