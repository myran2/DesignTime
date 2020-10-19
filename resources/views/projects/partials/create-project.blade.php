<!-- New project Form -->
{!! Form::model(new App\Models\Project, ['route' => ['projects.store'], 'class'=>'form-horizontal', 'role' => 'form']) !!}

    <!-- project Name -->
    <div class="form-group">
        <label for="project-name" class="col-sm-3 control-label">Project Name</label>

        <div class="col-sm-6">
            <input type="text" name="name" id="project-name" class="form-control" value="{{ old('project') }}">
        </div>
    </div>

    <!-- Project Description -->
    <div class="form-group">
        <label for="project-description" class="col-sm-3 control-label">Description</label>

        <div class="col-sm-6">
            <textarea name="description" id="project-description" class="form-control" value="{{ old('project') }}" maxlength="155"></textarea>
        </div>
    </div>

     <!-- Task Dropdown -->
     <div class="form-group row">
        {!! Form::label('tasks', 'Tasks', array('class' => 'col-sm-3 control-label text-right')) !!}
        <div class="col-sm-6">
            <select name="tasks[]" id="tasks" class="selectpicker" multiple data-live-search="true">
                @foreach ($orphanTasks as $t)
                    <option value="{{$t->id}}">{{$t->name}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Add Project Button -->
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-6">
             {{Form::button('<span class="fa fa-plus fa-fw" aria-hidden="true"></span> Create Project', array('type' => 'submit', 'class' => 'btn btn-success btn-block'))}}
        </div>
    </div>

{!! Form::close() !!}