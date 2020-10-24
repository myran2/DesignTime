<!-- New Task Form -->
{!! Form::model(new App\Models\Task, ['route' => ['tasks.store'], 'class'=>'form-horizontal', 'role' => 'form']) !!}

    <!-- Task Name -->
    <div class="form-group">
        <label for="task-name" class="col-sm-3 control-label">Task Name</label>

        <div class="col-sm-6">
            <input type="text" name="name" id="task-name" class="form-control" value="{{ old('task') }}">
        </div>
    </div>

    <!-- Task Description -->
    <div class="form-group">
        <label for="task-description" class="col-sm-3 control-label">Description</label>

        <div class="col-sm-6">
            <textarea name="description" id="task-description" class="form-control" value="{{ old('task') }}" maxlength="155"></textarea>
        </div>
    </div>

    <!-- Project -->
    <div class="form-group row">
        {!! Form::label('projects', 'Project', array('class' => 'col-sm-3 control-label text-right')) !!}
        <div class="col-sm-6">
            <select name="project" id="project" class="selectpicker" data-live-search="true">
                @foreach ($projects as $p)
                    <option value="{{$p->id}}">{{$p->name}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Assigned Users -->
    <div class="form-group row">
        {!! Form::label('additional-assigned-users', 'Additional Assigned Users', array('class' => 'col-sm-3 control-label text-right')) !!}
        <div class="col-sm-6">
            <select name="assignedUsers[]" id="assignedUsers" class="selectpicker" multiple data-live-search="true">
                @foreach ($additionalUsers as $u)
                    <option value="{{$u->id}}">{{$u->name}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Add Task Button -->
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-6">
             {{Form::button('<span class="fa fa-plus fa-fw" aria-hidden="true"></span> Create Task', array('type' => 'submit', 'class' => 'btn btn-success btn-block'))}}
        </div>
    </div>

{!! Form::close() !!}